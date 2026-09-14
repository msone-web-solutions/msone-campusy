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
 * @property string|null $curriculum_ref
 * @property int $estimated_minutes
 * @property int $pass_percent
 * @property int $sort
 */
#[Fillable(['topic_area_id', 'slug', 'title', 'intro', 'explanation', 'notebook_entry', 'curriculum_ref', 'estimated_minutes', 'pass_percent', 'sort'])]
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
