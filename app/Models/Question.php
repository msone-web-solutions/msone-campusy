<?php

namespace App\Models;

use App\Enums\QuestionRole;
use App\Enums\QuestionType;
use Database\Factories\QuestionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $topic_id
 * @property string $key
 * @property QuestionRole $role
 * @property int|null $segment
 * @property QuestionType $type
 * @property string $prompt
 * @property array<int|string, mixed>|null $options
 * @property array<int|string, mixed> $answer
 * @property string|null $explanation
 * @property int $points
 * @property int $difficulty
 * @property int $sort
 */
#[Fillable(['topic_id', 'key', 'role', 'segment', 'type', 'prompt', 'options', 'answer', 'explanation', 'points', 'difficulty', 'sort'])]
class Question extends Model
{
    /** @use HasFactory<QuestionFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => QuestionType::class,
            'role' => QuestionRole::class,
            'options' => 'array',
            'answer' => 'array',
        ];
    }

    /** @return BelongsTo<Topic, $this> */
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    /** @return HasMany<ReviewItem, $this> */
    public function reviewItems(): HasMany
    {
        return $this->hasMany(ReviewItem::class);
    }

    /**
     * @param  Builder<Question>  $query
     * @return Builder<Question>
     */
    public function scopeTest(Builder $query): Builder
    {
        return $query->where('role', QuestionRole::Test);
    }

    /**
     * @param  Builder<Question>  $query
     * @return Builder<Question>
     */
    public function scopeCheck(Builder $query): Builder
    {
        return $query->where('role', QuestionRole::Check);
    }
}
