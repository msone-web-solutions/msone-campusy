<?php

use App\Enums\ProgressStatus;
use App\Models\Question;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use App\Models\ReviewItem;
use App\Models\Topic;
use App\Models\TopicArea;
use App\Models\TopicProgress;
use App\Models\User;
use App\Review\LeitnerScheduler;
use App\Review\ReviewPlanner;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->area = TopicArea::factory()->create();
    $this->topic = Topic::factory()->for($this->area)->create(['sort' => 1]);
    $this->questions = collect([
        Question::factory()->for($this->topic)->create(['key' => 'q1', 'sort' => 1]),
        Question::factory()->for($this->topic)->create(['key' => 'q2', 'sort' => 2]),
        Question::factory()->for($this->topic)->create(['key' => 'q3', 'sort' => 3]),
    ]);
});

it('enrolls test questions after an attempt, wrong ones as stumbling blocks', function () {
    $attempt = QuizAttempt::factory()->for($this->user)->for($this->topic)->create();
    QuizAnswer::create(['quiz_attempt_id' => $attempt->id, 'question_id' => $this->questions[0]->id, 'given' => [1], 'is_correct' => true]);
    QuizAnswer::create(['quiz_attempt_id' => $attempt->id, 'question_id' => $this->questions[1]->id, 'given' => [0], 'is_correct' => false]);

    app(ReviewPlanner::class)->enrollAttempt($attempt);

    $items = ReviewItem::where('user_id', $this->user->id)->get()->keyBy('question_id');
    expect($items)->toHaveCount(3)
        ->and($items[$this->questions[0]->id]->box)->toBe(1)
        ->and($items[$this->questions[1]->id]->box)->toBe(0)
        ->and($items[$this->questions[2]->id]->box)->toBe(1)
        ->and($items[$this->questions[1]->id]->due_at->isTomorrow())->toBeTrue();
});

it('interleaves due items so neighbours come from different topics', function () {
    $otherTopic = Topic::factory()->for($this->area)->create(['sort' => 2]);
    $otherQuestions = Question::factory()->for($otherTopic)->count(3)->create();

    foreach ($this->questions->merge($otherQuestions) as $q) {
        ReviewItem::create(['user_id' => $this->user->id, 'question_id' => $q->id, 'box' => 1, 'due_at' => now()->subDay()]);
    }

    $due = app(ReviewPlanner::class)->dueItemsFor($this->user, 6);
    $topics = $due->map(fn (ReviewItem $i) => $i->question->topic_id)->all();

    expect($due)->toHaveCount(6);
    foreach (array_slice($topics, 1) as $i => $topicId) {
        expect($topicId)->not->toBe($topics[$i]);
    }
});

it('marks a passed topic as mastered once its items reach the mastery box', function () {
    TopicProgress::create(['user_id' => $this->user->id, 'topic_id' => $this->topic->id, 'status' => ProgressStatus::Passed, 'best_percent' => 80]);
    foreach ($this->questions as $q) {
        ReviewItem::create(['user_id' => $this->user->id, 'question_id' => $q->id, 'box' => LeitnerScheduler::MASTERY_BOX - 1, 'due_at' => now()]);
    }
    $planner = app(ReviewPlanner::class);

    foreach (ReviewItem::where('user_id', $this->user->id)->get() as $item) {
        $planner->recordAnswer($item, true);
    }

    $progress = TopicProgress::where('user_id', $this->user->id)->where('topic_id', $this->topic->id)->first();
    expect($progress->status)->toBe(ProgressStatus::Mastered)->and($progress->mastered_at)->not->toBeNull();
});

it('offers three warm-up questions from the previous topic', function () {
    $next = Topic::factory()->for($this->area)->create(['sort' => 2]);
    $next->load('topicArea.subject.topicAreas.topics');

    $warmup = app(ReviewPlanner::class)->warmupFor($next);

    expect($warmup)->toHaveCount(3)->and($warmup->pluck('topic_id')->unique()->all())->toBe([$this->topic->id]);
});
