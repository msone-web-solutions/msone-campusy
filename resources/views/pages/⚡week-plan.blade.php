<?php

use App\Schedule\DayPlanner;
use App\Schedule\WeekPlanner;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

new #[Title('Wochenplan')] class extends Component
{
    #[Url(as: 'w')]
    public int $offset = 0;

    public function shift(int $by): void
    {
        $this->offset = max(-8, min(26, $this->offset + $by));
    }

    /**
     * @return array<string, mixed>
     */
    #[Computed]
    public function week(): array
    {
        return app(WeekPlanner::class)->weekFor(auth()->user(), now(), $this->offset);
    }

    public function icon(\App\Models\Subject $subject): string
    {
        return DayPlanner::subjectIcon($subject);
    }
};
?>

<div>
    @php
        $week = $this->week;
        $pace = $week['pace'];
        $weekdays = ['Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa', 'So'];
        $weekdaysLong = ['Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonntag'];
        $weekEnd = $week['week_start']->addDays(6);
    @endphp

    <x-raque.page-banner title="Dein Wochenplan." :emphasis="true" eyebrow="Hochrechnung aus dem Lernstand" :crumbs="[['label' => 'Home', 'href' => route('dashboard')], ['label' => 'Schultag', 'href' => route('school-day')], ['label' => 'Wochenplan']]">
        <p style="color:#fff;opacity:.9;margin-top:4px">{{ $week['week_start']->format('d.m.') }} – {{ $weekEnd->format('d.m.Y') }} · Vergangene Tage zeigen, was bestanden wurde; ab heute zeigt der Plan, was ansteht.</p>
    </x-raque.page-banner>

    <section class="rq-section rq-section--tight rq-section--panel">
        <div class="rq-container rq-stack">

            {{-- Lernstand-Leiste --}}
            <div class="rq-card rq-week__status">
                <div class="rq-week__status-main">
                    @if ($pace['backlog_blocks'] > 0)
                        <span class="rq-badge rq-badge--amber" style="font-size:13px;padding:6px 12px"><i class="bx bx-error"></i>Rückstand: {{ $pace['backlog_blocks'] }} {{ $pace['backlog_blocks'] === 1 ? 'Block' : 'Blöcke' }} · ≈ {{ number_format(abs($pace['backlog_days']), 1, ',', '.') }} Schultage</span>
                    @elseif ($pace['backlog_blocks'] < 0)
                        <span class="rq-badge rq-badge--green" style="font-size:13px;padding:6px 12px"><i class="bx bx-trending-up"></i>Vorsprung: {{ abs($pace['backlog_blocks']) }} {{ abs($pace['backlog_blocks']) === 1 ? 'Block' : 'Blöcke' }}</span>
                    @else
                        <span class="rq-badge rq-badge--green" style="font-size:13px;padding:6px 12px"><i class="bx bx-check-circle"></i>Im Plan</span>
                    @endif
                    <div style="flex:1;min-width:220px">
                        <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:6px"><span>Ist: <strong>{{ $pace['percent_done'] }} %</strong></span><span class="rq-muted">Soll heute: {{ $pace['percent_expected'] }} %</span></div>
                        <div class="rq-progress rq-pace" style="height:10px"><span class="rq-pace__soll" style="width:{{ $pace['percent_expected'] }}%"></span><span class="rq-pace__ist" style="width:{{ $pace['percent_done'] }}%"></span></div>
                    </div>
                    <x-raque.week-goal :week="$week['week_progress']" compact style="flex:1;min-width:200px" />
                    <div class="rq-week__kpis">
                        <div><span class="rq-muted">Offene Blöcke</span><strong>{{ $pace['remaining_blocks'] }}</strong></div>
                        <div><span class="rq-muted">Schultage bis fertig</span><strong>{{ $pace['school_days_left'] }}</strong></div>
                        <div><span class="rq-muted">Voraussichtlich fertig</span><strong>{{ $pace['finish_date']?->format('d.m.Y') ?? '–' }}</strong></div>
                    </div>
                </div>
            </div>

            {{-- Wochennavigation --}}
            <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap">
                <div style="display:flex;gap:8px;align-items:center">
                    <button type="button" class="rq-icon-btn rq-icon-btn--outlined" wire:click="shift(-1)" aria-label="Vorherige Woche"><i class="bx bx-chevron-left"></i></button>
                    <button type="button" class="rq-icon-btn rq-icon-btn--outlined" wire:click="shift(1)" aria-label="Nächste Woche"><i class="bx bx-chevron-right"></i></button>
                    <h2 style="font-size:var(--fs-lg);font-weight:600;margin-left:6px">KW {{ $week['week_start']->isoWeek }} · {{ $week['week_start']->format('d.m.') }} – {{ $weekEnd->format('d.m.Y') }}</h2>
                </div>
                <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">
                    @php $free = collect($week['days'])->reject(fn ($d) => $d['is_school_day']); $todayFree = $free->first(fn ($d) => $d['is_today']); @endphp
                    @if ($todayFree)
                        <span class="rq-day__now-badge"><span class="rq-day__pulse"></span>Heute {{ $weekdays[$todayFree['date']->dayOfWeekIso - 1] }} – kein Schultag</span>
                    @endif
                    @if ($free->isNotEmpty())
                        <span class="rq-badge"><i class="bx bx-coffee"></i>Frei: {{ $free->map(fn ($d) => $weekdays[$d['date']->dayOfWeekIso - 1])->implode(', ') }}</span>
                    @endif
                    @if ($this->offset !== 0)
                        <x-raque.button variant="cancel" size="sm" icon="bx bx-calendar" wire:click="$set('offset', 0)">Diese Woche</x-raque.button>
                    @endif
                </div>
            </div>

            {{-- Tage --}}
            @php $schoolDays = collect($week['days'])->filter(fn ($d) => $d['is_school_day'])->values(); @endphp
            <div class="rq-week__grid" style="--days:{{ max(1, $schoolDays->count()) }}">
                @forelse ($schoolDays as $day)
                    @php
                        $d = $day['date'];
                        $planned = $day['planned'];
                        $passed = $day['passed'];
                        $isFree = false;
                        $short = $day['is_past'] && $day['target_blocks'] > 0 && $passed->count() === 0;
                    @endphp
                    <div class="rq-card rq-week__day {{ $day['is_today'] ? 'is-today' : '' }} {{ $day['is_past'] ? 'is-past' : '' }}" wire:key="day-{{ $d->toDateString() }}">
                        <div class="rq-week__day-head">
                            <div class="rq-week__day-date">
                                <span class="rq-week__day-name">{{ $weekdaysLong[$d->dayOfWeekIso - 1] }}</span>
                                <span class="rq-muted rq-num">{{ $d->format('d.m.') }}</span>
                            </div>
                            @if ($day['is_today'])
                                <span class="rq-day__now-badge"><span class="rq-day__pulse"></span>Heute</span>
                            @elseif ($day['is_past'])
                                <span class="rq-badge {{ $passed->count() >= $day['target_blocks'] ? 'rq-badge--green' : ($passed->isEmpty() ? 'rq-badge--red' : 'rq-badge--amber') }}">{{ $passed->count() }} bestanden</span>
                            @else
                                <span class="rq-badge">{{ count($planned) }} {{ count($planned) === 1 ? 'Block' : 'Blöcke' }}</span>
                            @endif
                        </div>

                        @if ($day['is_past'])
                            @forelse ($passed as $topic)
                                <a href="{{ route('learn.topic', [$topic->topicArea->subject, $topic->topicArea, $topic]) }}" class="rq-week__item is-passed rq-week__item--{{ $topic->topicArea->subject->slug }}" wire:navigate wire:key="p-{{ $topic->id }}">
                                    <i class="bx bx-check-circle"></i>
                                    <span><span class="rq-week__item-title">{{ $topic->title }}</span><span class="rq-muted">{{ $topic->topicArea->subject->name }}</span></span>
                                </a>
                            @empty
                                <p class="rq-week__empty" style="color:var(--color-danger)"><i class="bx bx-x-circle"></i> Nichts bestanden – {{ $day['target_blocks'] }} Blöcke offen geblieben.</p>
                            @endforelse
                        @else
                            @if ($day['is_today'] && $passed->isNotEmpty())
                                @foreach ($passed as $topic)
                                    <div class="rq-week__item is-passed rq-week__item--{{ $topic->topicArea->subject->slug }}" wire:key="tp-{{ $topic->id }}">
                                        <i class="bx bx-check-circle"></i>
                                        <span><span class="rq-week__item-title">{{ $topic->title }}</span><span class="rq-muted">{{ $topic->topicArea->subject->name }} · bestanden</span></span>
                                    </div>
                                @endforeach
                            @endif
                            @forelse ($planned as $bi => $block)
                                <div class="rq-week__block rq-week__item--{{ $block['subject']->slug }}" wire:key="b-{{ $d->toDateString() }}-{{ $bi }}">
                                    <div class="rq-week__block-head"><span class="rq-week__block-icon"><i class="{{ $this->icon($block['subject']) }}"></i></span><span class="rq-week__block-subject">{{ $block['subject']->name }}</span><span class="rq-muted rq-num rq-week__block-min">{{ $block['minutes'] }} min</span></div>
                                    @foreach ($block['units'] as $u)
                                        <a href="{{ route('learn.topic', [$u['topic']->topicArea->subject, $u['topic']->topicArea, $u['topic']]) }}" class="rq-week__item" wire:navigate wire:key="u-{{ $d->toDateString() }}-{{ $bi }}-{{ $loop->index }}">
                                            <span class="rq-day__unit-nr">{{ $u['topic']->topicArea->sort }}.{{ $u['topic']->sort }}</span>
                                            <span><span class="rq-week__item-title">{{ $u['topic']->title }}</span>@if ($u['parts'] > 1)<span class="rq-muted">Teil {{ $u['part'] }} / {{ $u['parts'] }}</span>@endif</span>
                                        </a>
                                    @endforeach
                                </div>
                            @empty
                                <p class="rq-week__empty"><i class="bx bx-party"></i> Nichts mehr geplant – alles erledigt.</p>
                            @endforelse
                        @endif
                    </div>
                @empty
                    <div class="rq-card rq-week__day"><p class="rq-week__empty">In dieser Woche gibt es keine Schultage.</p></div>
                @endforelse
            </div>

            {{-- Fächer-Ausblick --}}
            <x-raque.card title="Wann bist du fertig?" footer="Zum Stundenplan" :footer-href="route('school-day')">
                <div style="overflow-x:auto">
                    <table class="rq-table">
                        <thead><tr><th>Fach</th><th>Bestanden</th><th>Offen</th><th>Offene Lernzeit</th><th>Voraussichtlich fertig</th><th style="width:30%">Fortschritt</th></tr></thead>
                        <tbody>
                            @foreach ($week['outlook'] as $row)
                                <tr wire:key="outlook-{{ $row['subject']->id }}">
                                    <td><i class="{{ $this->icon($row['subject']) }}" style="color:var(--color-icon);margin-right:6px"></i><a href="{{ route('learn.subject', $row['subject']) }}" wire:navigate style="font-weight:500">{{ $row['subject']->name }}</a></td>
                                    <td class="rq-num">{{ $row['passed'] }} / {{ $row['total'] }}</td>
                                    <td class="rq-num">{{ $row['open'] }}</td>
                                    <td class="rq-num">{{ round($row['minutes_open'] / 60, 1) }} Std.</td>
                                    <td class="rq-num">{{ $row['finish_date']?->format('d.m.Y') ?? '✓ fertig' }}</td>
                                    <td><div class="rq-progress"><span style="width:{{ $row['total'] > 0 ? (int) round($row['passed'] * 100 / $row['total']) : 100 }}%"></span></div></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="rq-card__body" style="border-top:1px solid var(--border-default)">
                    <p style="font-size:13px;line-height:1.6"><i class="bx bx-info-circle" style="color:var(--color-icon)"></i> Rechnung: {{ $week['pace']['remaining_blocks'] }} offene Blöcke bei {{ auth()->user()->scheduleSetting?->blocks_per_day ?? 3 }} Blöcken pro Schultag ({{ \App\Models\ScheduleSetting::for(auth()->user())->capacity() }} Lernminuten je Block). Wer den Rückstand aufholt, wird früher fertig; die Termine aktualisieren sich mit jedem bestandenen Test. Rahmen und Fächer-Gewichtung legen deine Eltern fest.</p>
                </div>
            </x-raque.card>
        </div>
    </section>
</div>
