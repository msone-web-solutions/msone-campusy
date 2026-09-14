<?php

namespace App\Models;

use App\Enums\ProgressStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int $topic_id
 * @property ProgressStatus $status
 * @property Carbon|null $notebook_confirmed_at
 * @property int $best_percent
 * @property Carbon|null $last_seen_at
 */
#[Fillable(['user_id', 'topic_id', 'status', 'notebook_confirmed_at', 'best_percent', 'last_seen_at'])]
class TopicProgress extends Model
{
    protected $table = 'topic_progress';

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'status' => 'started',
        'best_percent' => 0,
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => ProgressStatus::class,
            'notebook_confirmed_at' => 'datetime',
            'last_seen_at' => 'datetime',
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

    /**
     * Only ever move the status forward, never back.
     */
    public function advanceTo(ProgressStatus $status): void
    {
        if ($status->rank() > $this->status->rank()) {
            $this->status = $status;
        }
    }
}
