<?php

namespace App\Review;

use App\Enums\ProgressStatus;
use App\Enums\QuestionRole;
use App\Models\Question;
use App\Models\QuizAttempt;
use App\Models\ReviewItem;
use App\Models\Topic;
use App\Models\TopicProgress;
use App\Models\User;
use Illuminate\Support\Collection;

class ReviewPlanner
{
    public const SESSION_SIZE = 10;

    public function __construct(private LeitnerScheduler $scheduler = new LeitnerScheduler) {}

    /**
     * After a finished test: put every test question of the topic into the queue.
     * Wrong answers land in box 0 ("Stolpersteine"), right ones in box 1.
     * Existing items keep their box unless the student just got them wrong.
     */
    public function enrollAttempt(QuizAttempt $attempt): void
    {
        $attempt->loadMissing(['answers', 'topic.questions']);
        $wrong = $attempt->answers->where('is_correct', false)->pluck('question_id')->all();

        foreach ($attempt->topic->questions->where('role', QuestionRole::Test) as $question) {
            $item = ReviewItem::firstOrNew(['user_id' => $attempt->user_id, 'question_id' => $question->id]);
            $isWrong = in_array($question->id, $wrong, true);

            if (! $item->exists) {
                $item->box = $isWrong ? 0 : 1;
                $item->due_at = $this->scheduler->initialDue($item->box);
            } elseif ($isWrong) {
                $item->box = 0;
                $item->correct_streak = 0;
                $item->lapses++;
                $item->due_at = $this->scheduler->initialDue(0);
            }

            $item->save();
        }
    }

    /**
     * Today's mixed practice: due items, interleaved so that consecutive questions
     * come from different topics whenever possible (Rohrer et al. 2020).
     *
     * @return Collection<int, ReviewItem>
     */
    public function dueItemsFor(User $user, int $limit = self::SESSION_SIZE): Collection
    {
        $due = ReviewItem::query()
            ->where('user_id', $user->id)
            ->due()
            ->with('question.topic.topicArea')
            ->orderBy('box')
            ->orderBy('due_at')
            ->limit($limit * 3)
            ->get()
            ->shuffle();

        return $this->interleave($due)->take($limit)->values();
    }

    public function dueCountFor(User $user): int
    {
        return ReviewItem::query()->where('user_id', $user->id)->due()->count();
    }

    public function recordAnswer(ReviewItem $item, bool $correct): void
    {
        $this->scheduler->apply($item, $correct)->save();
        $this->refreshMastery($item->user, $item->question->topic);
    }

    /**
     * A topic is "gesichert" once it was passed and (nearly) all of its review
     * items have climbed to the mastery box through spaced reviews.
     */
    public function refreshMastery(User $user, Topic $topic): void
    {
        $progress = TopicProgress::query()->where('user_id', $user->id)->where('topic_id', $topic->id)->first();

        if ($progress === null || ! $progress->status->isPassed()) {
            return;
        }

        $questionIds = $topic->questions()->where('role', QuestionRole::Test)->pluck('id');
        $items = ReviewItem::query()->where('user_id', $user->id)->whereIn('question_id', $questionIds)->get();

        if ($items->isEmpty() || $items->count() < $questionIds->count()) {
            return;
        }

        $secure = $items->where('box', '>=', LeitnerScheduler::MASTERY_BOX)->count();
        $isMastered = $secure >= (int) ceil($items->count() * 0.8);

        if ($isMastered && $progress->status !== ProgressStatus::Mastered) {
            $progress->advanceTo(ProgressStatus::Mastered);
            $progress->mastered_at = now();
            $progress->save();
        }
    }

    /**
     * @param  Collection<int, ReviewItem>  $items
     * @return Collection<int, ReviewItem>
     */
    private function interleave(Collection $items): Collection
    {
        $pool = $items->values()->all();
        $result = [];
        $lastTopic = null;

        while ($pool !== []) {
            $index = 0;
            foreach ($pool as $i => $candidate) {
                if ($candidate->question->topic_id !== $lastTopic) {
                    $index = $i;
                    break;
                }
            }
            $next = array_splice($pool, $index, 1)[0];
            $result[] = $next;
            $lastTopic = $next->question->topic_id;
        }

        return collect($result);
    }

    /**
     * Wrong-answered questions still waiting to be fixed.
     *
     * @return Collection<int, ReviewItem>
     */
    public function stumblingBlocksFor(User $user): Collection
    {
        return ReviewItem::query()
            ->where('user_id', $user->id)
            ->lapsed()
            ->with('question.topic.topicArea')
            ->orderByDesc('lapses')
            ->get();
    }

    /**
     * Three quick questions from the previous topic, shown before a new explanation
     * ("Begin each lesson with a short review", Rosenshine).
     *
     * @return Collection<int, Question>
     */
    public function warmupFor(Topic $topic): Collection
    {
        $previous = $topic->previousTopic();

        if ($previous === null) {
            return collect();
        }

        return $previous->questions()
            ->where('role', QuestionRole::Test)
            ->orderBy('difficulty')
            ->orderBy('sort')
            ->limit(3)
            ->get();
    }
}
