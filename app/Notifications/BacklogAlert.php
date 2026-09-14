<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Erinnerung an die Eltern, wenn ein Kind die Rückstands-Schwelle überschreitet.
 *
 * @phpstan-import-type Pace from \App\Schedule\Curriculum
 */
class BacklogAlert extends Notification
{
    use Queueable;

    /**
     * @param  Pace  $pace
     */
    public function __construct(public User $child, public array $pace) {}

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): MailMessage
    {
        $blocks = $this->pace['backlog_blocks'];
        $days = number_format(abs($this->pace['backlog_days']), 1, ',', '.');

        return (new MailMessage)
            ->subject($this->child->name.' hat '.$blocks.' Blöcke Rückstand')
            ->greeting('Hallo '.$notifiable->name.',')
            ->line($this->child->name.' liegt aktuell '.$blocks.' '.($blocks === 1 ? 'Block' : 'Blöcke').' (≈ '.$days.' Schultage) hinter dem Plan.')
            ->line('Ist: '.$this->pace['percent_done'].' % des Lehrplans · Soll: '.$this->pace['percent_expected'].' % · voraussichtlich fertig am '.($this->pace['finish_date']?->format('d.m.Y') ?? '–').'.')
            ->line('Offene Themen rücken automatisch nach vorn. Ein zusätzlicher Block an einem freien Tag holt den Rückstand am schnellsten auf.')
            ->action('Zur Elternübersicht', route('parent.dashboard'))
            ->line('Diese Erinnerung kommt höchstens einmal pro Tag. Die Schwelle stellst du unter „Stundenplan einstellen“ ein.');
    }
}
