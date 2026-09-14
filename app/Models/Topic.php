<?php

namespace App\Models;

use Database\Factories\TopicFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $topic_area_id
 * @property string $slug
 * @property string $title
 * @property string|null $intro
 * @property string $explanation
 * @property string $notebook_entry
 * @property string|null $reflect_prompt
 * @property string|null $curriculum_ref
 * @property int $estimated_minutes
 * @property int $pass_percent
 * @property int $sort
 */
#[Fillable(['topic_area_id', 'slug', 'title', 'intro', 'explanation', 'notebook_entry', 'reflect_prompt', 'curriculum_ref', 'estimated_minutes', 'pass_percent', 'sort'])]
class Topic extends Model
{
    /** @use HasFactory<TopicFactory> */
    use HasFactory;

    /** @return BelongsTo<TopicArea, $this> */
    public function topicArea(): BelongsTo
    {
        return $this->belongsTo(TopicArea::class);
    }

    /** @return HasMany<Question, $this> */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('sort');
    }

    /**
     * Questions of the end-of-topic test, easiest first (adaptive ramp).
     *
     * @return HasMany<Question, $this>
     */
    public function testQuestions(): HasMany
    {
        return $this->hasMany(Question::class)->test()->orderBy('difficulty')->orderBy('sort');
    }

    /** @return HasMany<Question, $this> */
    public function checks(): HasMany
    {
        return $this->hasMany(Question::class)->check()->orderBy('segment')->orderBy('sort');
    }

    /**
     * The explanation split at the inline-check markers, so the page can render
     * "segment, check, segment, check …".
     *
     * @return array<int, string>
     */
    public function explanationSegments(): array
    {
        return preg_split('/<!--\s*check:\d+\s*-->/', $this->explanation) ?: [$this->explanation];
    }

    public function reflectPrompt(): string
    {
        return $this->reflect_prompt ?? 'Erkläre in zwei bis drei Sätzen in deinen eigenen Worten: Was hast du in diesem Thema gelernt, und was ist der wichtigste Merksatz?';
    }

    public function previousTopic(): ?Topic
    {
        $previous = $this->topicArea->topics->filter(fn (Topic $t) => $t->sort < $this->sort)->last();

        if ($previous) {
            return $previous;
        }

        $previousArea = $this->topicArea->subject->topicAreas
            ->filter(fn (TopicArea $a) => $a->sort < $this->topicArea->sort)->last();

        return $previousArea?->topics->last();
    }

    /** @return HasMany<QuizAttempt, $this> */
    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }

    /** @return HasMany<TopicProgress, $this> */
    public function progress(): HasMany
    {
        return $this->hasMany(TopicProgress::class);
    }

    public function progressFor(User $user): ?TopicProgress
    {
        return $this->progress->firstWhere('user_id', $user->id);
    }

    /**
     * Public URL of the narrated explanation, if an MP3 has been dropped into
     * public/audio/<subject>/<area>/<topic>.mp3.
     */
    public function audioUrl(): ?string
    {
        $path = sprintf('audio/%s/%s/%s.mp3', $this->topicArea->subject->slug, $this->topicArea->slug, $this->slug);

        return file_exists(public_path($path)) ? asset($path) : null;
    }

    public function nextTopic(): ?Topic
    {
        $next = $this->topicArea->topics->firstWhere('sort', '>', $this->sort);

        if ($next) {
            return $next;
        }

        $nextArea = $this->topicArea->subject->topicAreas
            ->firstWhere('sort', '>', $this->topicArea->sort);

        return $nextArea?->topics->first();
    }
}
