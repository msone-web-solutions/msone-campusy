<?php

namespace App\Console\Commands;

use App\Enums\UserRole;
use App\Models\ScheduleSetting;
use App\Models\User;
use App\Notifications\BacklogAlert;
use App\Schedule\Curriculum;
use Illuminate\Console\Command;

class SendBacklogAlerts extends Command
{
    protected $signature = 'campusy:backlog-alerts';

    protected $description = 'Erinnert Eltern per Mail, wenn ein Kind die Rückstands-Schwelle überschreitet (höchstens einmal pro Tag)';

    public function handle(): int
    {
        $sent = 0;

        User::query()
            ->where('role', UserRole::Student)
            ->whereNotNull('parent_id')
            ->with(['parent', 'scheduleSetting'])
            ->each(function (User $child) use (&$sent) {
                $settings = ScheduleSetting::for($child);
                $threshold = $settings->backlog_alert_blocks;

                if ($threshold <= 0 || $child->parent === null) {
                    return;
                }

                if ($settings->backlog_alerted_at?->isToday()) {
                    return;
                }

                $pace = Curriculum::for($child)->pace(now());

                if ($pace['backlog_blocks'] < $threshold) {
                    return;
                }

                $child->parent->notify(new BacklogAlert($child, $pace));

                ScheduleSetting::query()->updateOrCreate(['user_id' => $child->id], ['start_date' => $settings->start_date, 'backlog_alerted_at' => now()]);
                $sent++;
                $this->line($child->name.': '.$pace['backlog_blocks'].' Blöcke Rückstand → '.$child->parent->email);
            });

        $this->info($sent.' Erinnerung(en) verschickt.');

        return self::SUCCESS;
    }
}
