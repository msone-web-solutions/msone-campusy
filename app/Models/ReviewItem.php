<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * One question in a student's spaced-repetition queue (Leitner boxes).
 *
 * @property int $id
 * @property int $user_id
 * @property int $question_id
 * @property int $box
 * @property CarbonInterface $due_at
 * @property CarbonInterface|null $last_reviewed_at
 * @property int $correct_streak
 * @property int $lapses
 */
#[Fillable(['user_id', 'question_id', 'box', 'due_at', 'last_reviewed_at', 'correct_streak', 'lapses'])]
class ReviewItem extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'due_at' => 'datetime',
            'last_reviewed_at' => 'datetime',
        ];
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsTo<Question, $this> */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * @param  Builder<ReviewItem>  $query
     * @return Builder<ReviewItem>
     */
    public function scopeDue(Builder $query): Builder
    {
        return $query->where('due_at', '<=', now());
    }

    /**
     * Items in box 0 – answered wrong recently ("Stolpersteine").
     *
     * @param  Builder<ReviewItem>  $query
     * @return Builder<ReviewItem>
     */
    public function scopeLapsed(Builder $query): Builder
    {
        return $query->where('box', 0);
    }
}
