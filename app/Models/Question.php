<?php

namespace App\Models;

use App\Enums\QuestionType;
use Database\Factories\QuestionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $topic_id
 * @property string $key
 * @property QuestionType $type
 * @property string $prompt
 * @property array<int|string, mixed>|null $options
 * @property array<int|string, mixed> $answer
 * @property string|null $explanation
 * @property int $points
 * @property int $difficulty
 * @property int $sort
 */
#[Fillable(['topic_id', 'key', 'type', 'prompt', 'options', 'answer', 'explanation', 'points', 'difficulty', 'sort'])]
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
            'options' => 'array',
            'answer' => 'array',
        ];
    }

    /** @return BelongsTo<Topic, $this> */
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }
}
