<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Database\Factories\QuizAttemptFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user_id
 * @property int $topic_id
 * @property int $score
 * @property int $max_score
 * @property bool $passed
 * @property int|null $confidence
 * @property string|null $self_explanation
 * @property CarbonInterface $started_at
 * @property CarbonInterface|null $finished_at
 */
#[Fillable(['user_id', 'topic_id', 'score', 'max_score', 'passed', 'confidence', 'self_explanation', 'started_at', 'finished_at'])]
class QuizAttempt extends Model
{
    /** @use HasFactory<QuizAttemptFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'passed' => 'boolean',
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
        ];
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsTo<Topic, $this> */
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    /** @return HasMany<QuizAnswer, $this> */
    public function answers(): HasMany
    {
        return $this->hasMany(QuizAnswer::class);
    }

    public function percent(): int
    {
        return $this->max_score === 0 ? 0 : (int) round($this->score * 100 / $this->max_score);
    }
}
