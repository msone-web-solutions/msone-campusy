<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Database\Factories\ScheduleSettingFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Stundenplan-Rahmen eines Schülers: Startdatum, Startzeit, Blöcke pro Tag,
 * Blocklänge, Pausenlänge, Schultage und Fächer-Gewichtung. Wird von den Eltern gepflegt.
 *
 * @property int $id
 * @property int $user_id
 * @property CarbonInterface $start_date
 * @property int $day_start Minuten seit Mitternacht
 * @property int $blocks_per_day
 * @property int $lesson_minutes Länge einer Doppelstunde inkl. Mikropause
 * @property int $break_minutes
 * @property int $weekly_goal_blocks Wochenziel in Blöcken (0 = aus)
 * @property int $backlog_alert_blocks Eltern-Erinnerung ab so vielen Blöcken Rückstand (0 = aus)
 * @property CarbonInterface|null $backlog_alerted_at
 * @property list<int> $school_days ISO-Wochentage 1–7
 * @property array<string, int> $subject_weights Fach-Slug → Gewicht 1–3
 */
#[Fillable(['user_id', 'start_date', 'day_start', 'blocks_per_day', 'lesson_minutes', 'break_minutes', 'weekly_goal_blocks', 'backlog_alert_blocks', 'school_days', 'subject_weights', 'backlog_alerted_at'])]
class ScheduleSetting extends Model
{
    /** @use HasFactory<ScheduleSettingFactory> */
    use HasFactory;

    public const int MICRO_BREAK = 5;

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'day_start' => 8 * 60,
        'blocks_per_day' => 3,
        'lesson_minutes' => 85,
        'break_minutes' => 20,
        'weekly_goal_blocks' => 12,
        'backlog_alert_blocks' => 3,
        'school_days' => '[1,2,3,4,5]',
        'subject_weights' => '[]',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'backlog_alerted_at' => 'datetime',
            'school_days' => 'array',
            'subject_weights' => 'array',
        ];
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Einstellungen eines Schülers – gespeichert oder Standardwerte (Start = Kontoerstellung).
     */
    public static function for(User $user): self
    {
        return $user->scheduleSetting ?? new self([
            'user_id' => $user->id,
            'start_date' => $user->created_at?->startOfDay() ?? now()->startOfDay(),
        ]);
    }

    /**
     * Lernzeit, die in eine Doppelstunde passt (ohne Mikropause).
     */
    public function capacity(): int
    {
        return max(20, $this->lesson_minutes - self::MICRO_BREAK);
    }

    public function isSchoolDay(CarbonInterface $date): bool
    {
        return in_array($date->dayOfWeekIso, $this->school_days, true);
    }

    public function weightFor(Subject $subject): int
    {
        return max(1, min(3, (int) ($this->subject_weights[$subject->slug] ?? 1)));
    }

    /**
     * Soll-Lernminuten pro Schultag.
     */
    public function minutesPerDay(): int
    {
        return $this->blocks_per_day * $this->capacity();
    }
}
