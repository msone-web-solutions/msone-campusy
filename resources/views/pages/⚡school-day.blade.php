<?php

use App\Schedule\DayPlanner;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Dein Schultag')] class extends Component
{
    /**
     * @return array{date: \Carbon\CarbonInterface, is_school_day: bool, blocks: list<array<string, mixed>>, due: int}
     */
    #[Computed]
    public function plan(): array
    {
        return app(DayPlanner::class)->planFor(auth()->user(), now());
    }

    /**
     * Schlanke Version des Plans für Alpine (Uhr, Timeline, Pausen-Modus).
     *
     * @return list<array<string, mixed>>
     */
    #[Computed]
    public function clientBlocks(): array
    {
        return array_map(fn (array $b) => [
            'type' => $b['type'],
            'start' => $b['start'],
            'end' => $b['end'],
            'title' => $b['title'],
            'subject' => $b['subject']?->slug,
            'lessons' => $b['lessons'],
            'exercises' => $b['exercises'],
            'done' => $b['done'],
        ], $this->plan['blocks']);
    }
};
?>

<div x-data="schoolDay(@js($this->clientBlocks), @js($this->plan['first_open']))" x-init="init()" class="rq-day">
    @php
        $plan = $this->plan;
        $weekdays = ['Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonntag'];
        $months = ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];
        $dateLabel = $weekdays[$plan['date']->dayOfWeekIso - 1].', '.$plan['date']->day.'. '.$months[$plan['date']->month - 1];
    @endphp

    <x-raque.page-banner title="Dein Schultag." :emphasis="true" eyebrow="Stundenplan">
        <p style="color:#fff;opacity:.9;margin-top:4px">{{ $dateLabel }} · {{ $plan['lessons_total'] }} Doppelstunden, {{ max(0, $plan['lessons_total'] - 1) }} Bewegungspausen, {{ intdiv($plan['settings']->day_start, 60) }}:{{ sprintf('%02d', $plan['settings']->day_start % 60) }} bis {{ intdiv($plan['day_end'], 60) }}:{{ sprintf('%02d', $plan['day_end'] % 60) }} Uhr.</p>
        @unless ($plan['is_school_day'])
            <p style="margin-top:12px"><span class="rq-badge" style="background:#fff;color:var(--color-primary)"><i class="bx bx-sun"></i>Kein Schultag – das ist dein Plan für {{ $weekdays[$plan['date']->dayOfWeekIso - 1] }}</span></p>
        @endunless
    </x-raque.page-banner>

    <section class="rq-section rq-section--tight rq-section--panel">
        <div class="rq-container rq-day__layout">

            {{-- Uhr + Status --}}
            <div class="rq-card rq-day__clock-card">
                <div class="rq-day__clock" :class="'is-' + (current ? current.type : state)">
                    <svg viewBox="0 0 220 220" role="img" aria-label="Uhr">
                        <circle cx="110" cy="110" r="104" class="rq-clock__face" />
                        {{-- Blöcke als Bögen auf dem Zifferblatt (x-for funktioniert nicht innerhalb von SVG, daher serverseitig) --}}
                        @foreach ($plan['blocks'] as $i => $b)
                            @php
                                $angle = fn (int $min) => deg2rad((($min / 60) % 12) * 30 - 90);
                                $x1 = 110 + 92 * cos($angle($b['start'])); $y1 = 110 + 92 * sin($angle($b['start']));
                                $x2 = 110 + 92 * cos($angle($b['end']) - 0.01); $y2 = 110 + 92 * sin($angle($b['end']) - 0.01);
                            @endphp
                            <path d="M {{ round($x1, 2) }} {{ round($y1, 2) }} A 92 92 0 0 1 {{ round($x2, 2) }} {{ round($y2, 2) }}" class="rq-clock__arc rq-clock__arc--{{ $b['type'] }} {{ $b['subject'] ? 'rq-clock__arc--'.$b['subject']->slug : '' }}" :class="{ 'is-now': current === blocks[{{ $i }}] }" fill="none" stroke-width="12" />
                        @endforeach
                        @for ($i = 1; $i <= 60; $i++)
                            <line x1="110" y1="{{ $i % 5 === 0 ? 16 : 20 }}" x2="110" y2="24" transform="rotate({{ $i * 6 }} 110 110)" class="rq-clock__tick {{ $i % 5 === 0 ? 'is-hour' : '' }}" />
                        @endfor
                        @for ($h = 1; $h <= 12; $h++)
                            <text x="{{ round(110 + 70 * sin($h * M_PI / 6), 2) }}" y="{{ round(110 - 70 * cos($h * M_PI / 6) + 5, 2) }}" text-anchor="middle" class="rq-clock__num">{{ $h }}</text>
                        @endfor
                        {{-- Zeiger --}}
                        <line x1="110" y1="118" x2="110" y2="62" class="rq-clock__hand rq-clock__hand--h" :transform="'rotate(' + hourAngle() + ' 110 110)'" />
                        <line x1="110" y1="122" x2="110" y2="40" class="rq-clock__hand rq-clock__hand--m" :transform="'rotate(' + minuteAngle() + ' 110 110)'" />
                        <line x1="110" y1="126" x2="110" y2="34" class="rq-clock__hand rq-clock__hand--s" :transform="'rotate(' + secondAngle() + ' 110 110)'" x-show="!simulate" />
                        <circle cx="110" cy="110" r="5" class="rq-clock__pin" />
                    </svg>
                    <div class="rq-clock__digital" x-text="digital()"></div>
                </div>

                <div class="rq-day__status">
                    <template x-if="current">
                        <div>
                            <span class="rq-eyebrow" style="margin-bottom:2px" x-text="current.type === 'lesson' ? 'Jetzt: Doppelstunde' : 'Jetzt'"></span>
                            <h2 class="rq-day__status-title" x-text="current.title"></h2>
                            <p class="rq-muted" style="margin-top:4px"><span x-text="time(current.start)"></span> – <span x-text="time(current.end)"></span> · noch <strong x-text="remaining()"></strong></p>
                            <div class="rq-progress" style="margin-top:12px"><span :style="'width:' + blockPercent() + '%'"></span></div>
                            <template x-if="currentLesson()">
                                <p class="rq-day__phase"><i class="bx bx-chevron-right"></i><span x-text="currentLesson().label"></span> <span class="rq-muted">bis <span x-text="time(currentLesson().end)"></span></span></p>
                            </template>
                        </div>
                    </template>
                    <template x-if="!current && state === 'before'">
                        <div>
                            <span class="rq-eyebrow" style="margin-bottom:2px">Gleich geht's los</span>
                            <h2 class="rq-day__status-title">Schulstart um 8:00 Uhr</h2>
                            <p class="rq-muted" style="margin-top:4px">Noch <strong x-text="untilStart()"></strong>. Frühstück, Wasser, Fenster auf – und dann in den Tag.</p>
                        </div>
                    </template>
                    <template x-if="!current && state === 'after'">
                        <div>
                            @if ($plan['lessons_done'] >= $plan['lessons_total'])
                                <span class="rq-eyebrow" style="margin-bottom:2px;color:var(--color-secondary)">Schultag geschafft</span>
                                <h2 class="rq-day__status-title">Feierabend! 🎉</h2>
                                <p class="rq-muted" style="margin-top:4px">Alle {{ $plan['lessons_total'] }} Doppelstunden liegen hinter dir. Beim nächsten Schultag geht's weiter.</p>
                            @else
                                <span class="rq-eyebrow" style="margin-bottom:2px;color:#b45309">Schultag vorbei</span>
                                <h2 class="rq-day__status-title">{{ $plan['lessons_total'] - $plan['lessons_done'] }} von {{ $plan['lessons_total'] }} Blöcken offen</h2>
                                <p class="rq-muted" style="margin-top:4px">Was heute liegen geblieben ist, steht morgen als Erstes im Plan – oder du holst jetzt noch einen Block nach.</p>
                            @endif
                        </div>
                    </template>

                    <div class="rq-day__dayprogress">
                        <div style="display:flex;justify-content:space-between;font-size:13px"><span>Tagesfortschritt</span><span class="rq-num" x-text="dayPercent() + ' %'"></span></div>
                        <div class="rq-progress rq-progress--on-panel" style="margin-top:6px"><span :style="'width:' + dayPercent() + '%'"></span></div>
                    </div>
                </div>

                {{-- Vorschau: Uhr stellen (für den POC, damit der Tagesablauf jederzeit zu sehen ist) --}}
                <div class="rq-day__sim">
                    <label style="display:flex;align-items:center;gap:8px;font-size:13px;cursor:pointer"><input type="checkbox" x-model="simulate"> Vorschau: Uhr stellen</label>
                    <input type="range" min="{{ $plan['settings']->day_start - 15 }}" max="{{ $plan['day_end'] + 15 }}" step="1" x-model.number="simMinutes" x-show="simulate" x-cloak style="width:100%;margin-top:8px;accent-color:var(--color-primary)">
                </div>
            </div>

            {{-- Lernstand --}}
            @php $pace = $plan['pace']; @endphp
            <div class="rq-day__lernstand">
            <x-raque.card title="Lernstand" footer="Zum Wochenplan" :footer-href="route('week-plan')">
                <div class="rq-card__body" style="display:grid;gap:14px">
                    @if ($pace['backlog_blocks'] > 0)
                        <div class="rq-callout rq-callout--red" style="padding:14px 16px">
                            <i class="bx bx-error"></i>
                            <div><strong style="color:var(--text-heading)">Rückstand: {{ $pace['backlog_blocks'] }} {{ $pace['backlog_blocks'] === 1 ? 'Block' : 'Blöcke' }}</strong><p style="line-height:1.5">≈ {{ number_format(abs($pace['backlog_days']), 1, ',', '.') }} Schultage hinter dem Plan. Offene Themen rücken automatisch nach vorn – heute aufholen lohnt sich.</p></div>
                        </div>
                    @elseif ($pace['backlog_blocks'] < 0)
                        <div class="rq-callout rq-callout--green" style="padding:14px 16px">
                            <i class="bx bx-trending-up"></i>
                            <div><strong style="color:var(--text-heading)">Vorsprung: {{ abs($pace['backlog_blocks']) }} {{ abs($pace['backlog_blocks']) === 1 ? 'Block' : 'Blöcke' }}</strong><p style="line-height:1.5">Du bist dem Plan ≈ {{ number_format(abs($pace['backlog_days']), 1, ',', '.') }} Schultage voraus.</p></div>
                        </div>
                    @else
                        <div class="rq-callout rq-callout--green" style="padding:14px 16px"><i class="bx bx-check-circle"></i><div><strong style="color:var(--text-heading)">Im Plan</strong><p style="line-height:1.5">Soll und Ist stimmen überein.</p></div></div>
                    @endif

                    <div>
                        <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:6px"><span>Ist: {{ $pace['percent_done'] }} % des Lehrplans</span><span class="rq-muted">Soll: {{ $pace['percent_expected'] }} %</span></div>
                        <div class="rq-progress rq-pace" style="height:10px"><span class="rq-pace__soll" style="width:{{ $pace['percent_expected'] }}%"></span><span class="rq-pace__ist" style="width:{{ $pace['percent_done'] }}%"></span></div>
                    </div>

                    <x-raque.week-goal :week="$plan['week']" />

                    <ul class="rq-profile__stats" style="padding:0">
                        <li><span>Heute geschafft</span><span>{{ $plan['lessons_done'] }} / {{ $plan['lessons_total'] }} Blöcke</span></li>
                        <li><span>Offene Blöcke gesamt</span><span>{{ $pace['remaining_blocks'] }}</span></li>
                        <li><span>Schultage bis fertig</span><span>{{ $pace['school_days_left'] }}</span></li>
                        <li><span>Voraussichtlich fertig</span><span>{{ $pace['finish_date']?->format('d.m.Y') ?? '–' }}</span></li>
                    </ul>
                </div>
            </x-raque.card>
            </div>

            <div class="rq-day__timeline-wrap">

            {{-- Timeline --}}
            <div class="rq-day__timeline">
                @foreach ($plan['blocks'] as $i => $block)
                    <div class="rq-card rq-day__block rq-day__block--{{ $block['type'] }} {{ $block['subject'] ? 'rq-day__block--'.$block['subject']->slug : '' }}"
                         :class="{ 'is-now': current === blocks[{{ $i }}], 'is-done': isDone({{ $i }}), 'is-next': minutes() < blocks[{{ $i }}].start && !isDone({{ $i }}), 'is-late': isLate({{ $i }}), 'is-focus': firstOpen === {{ $i }} }"
                         style="--delay: {{ $i * 90 }}ms" wire:key="block-{{ $i }}">
                        <div class="rq-day__time">
                            <span class="rq-num">{{ sprintf('%d:%02d', intdiv($block['start'], 60), $block['start'] % 60) }}</span>
                            <span class="rq-day__dot"><i class="bx bx-check"></i></span>
                            <span class="rq-num rq-muted" style="font-size:12px">{{ sprintf('%d:%02d', intdiv($block['end'], 60), $block['end'] % 60) }}</span>
                        </div>
                        <div class="rq-day__body">
                            <div class="rq-day__head">
                                <span class="rq-day__icon"><i class="{{ $block['icon'] }}"></i></span>
                                <div style="min-width:0;flex:1">
                                    <h3 class="rq-day__title">{{ $block['title'] }}</h3>
                                    <p class="rq-day__subtitle">{{ $block['subtitle'] }}</p>
                                </div>
                                <span class="rq-day__now-badge" x-show="current === blocks[{{ $i }}] && !isDone({{ $i }})" x-cloak><span class="rq-day__pulse"></span>Jetzt</span>
                                <span class="rq-day__now-badge rq-day__now-badge--late" x-show="isLate({{ $i }})" x-cloak><i class="bx bx-time"></i>Nachholen</span>
                                <span class="rq-day__now-badge rq-day__now-badge--done" x-show="isDone({{ $i }})" x-cloak><i class="bx bx-check"></i>Geschafft</span>
                            </div>

                            @if ($block['type'] === 'lesson')
                                <ol class="rq-day__lessons">
                                    @foreach ($block['lessons'] as $j => $lesson)
                                        <li :class="{ 'is-now': current === blocks[{{ $i }}] && currentLesson() === blocks[{{ $i }}].lessons[{{ $j }}], 'is-done': isDone({{ $i }}) }" class="{{ $lesson['label'] === 'Mikropause' ? 'is-micro' : '' }}">
                                            <span class="rq-num">{{ sprintf('%d:%02d', intdiv($lesson['start'], 60), $lesson['start'] % 60) }}</span>
                                            <span>{{ $lesson['label'] }}</span>
                                            @if ($lesson['label'] === 'Mikropause')
                                                <button type="button" class="rq-day__minibtn" x-on:click="startBreak(blocks[{{ $i }}], 'Mikropause')"><i class="bx bx-low-vision"></i>Augen & Schultern</button>
                                            @endif
                                        </li>
                                    @endforeach
                                </ol>
                                @if ($block['units'])
                                    <ul class="rq-day__units">
                                        @foreach ($block['units'] as $u)
                                            <li class="{{ $u['passed'] ? 'is-passed' : '' }}" wire:key="unit-{{ $i }}-{{ $loop->index }}">
                                                <span class="rq-day__unit-nr">{{ $u['topic']->topicArea->sort }}.{{ $u['topic']->sort }}</span>
                                                <span style="min-width:0;flex:1">
                                                    <a href="{{ route('learn.topic', [$u['topic']->topicArea->subject, $u['topic']->topicArea, $u['topic']]) }}" wire:navigate style="font-weight:500">{{ $u['topic']->title }}</a>
                                                    @if ($u['parts'] > 1)<span class="rq-badge" style="margin-left:6px">Teil {{ $u['part'] }} / {{ $u['parts'] }}</span>@endif
                                                    <span class="rq-muted" style="display:block">{{ $u['topic']->topicArea->name }} · ca. {{ $u['minutes'] }} min</span>
                                                </span>
                                                <span class="rq-day__unit-steps">
                                                    <span class="{{ $u['notebook'] || $u['passed'] ? 'is-ok' : '' }}" title="Hefteintrag"><i class="bx bx-pencil"></i></span>
                                                    <span class="{{ $u['passed'] ? 'is-ok' : '' }}" title="Test bestanden"><i class="bx bx-task"></i></span>
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @unless ($block['done'])
                                        <div style="margin-top:12px;display:flex;justify-content:flex-end">
                                            <x-raque.button :href="$block['href']" size="sm" icon="bx bx-right-arrow-alt" wire:navigate>{{ $block['topic']?->title }}</x-raque.button>
                                        </div>
                                    @endunless
                                @else
                                    <div class="rq-day__topic">
                                        <div><span class="rq-tag">Frei</span><div style="font-weight:500;margin-top:2px">Alle Themen bestanden – wiederholen und sichern</div></div>
                                        <x-raque.button :href="route('practice')" size="sm" icon="bx bx-refresh" wire:navigate>Üben</x-raque.button>
                                    </div>
                                @endif
                            @else
                                <div class="rq-day__exercises">
                                    @foreach ($block['exercises'] as $ex)
                                        <span class="rq-day__chip rq-day__chip--{{ $ex['category'] }}"><i class="bx {{ ['dehnen' => 'bx-body', 'mobil' => 'bx-rotate-right', 'kraft' => 'bx-dumbbell', 'ausdauer' => 'bx-run', 'ruhe' => 'bx-wind'][$ex['category']] }}"></i>{{ $ex['name'] }} <span class="rq-num" style="opacity:.7">{{ $ex['seconds'] }}s</span></span>
                                    @endforeach
                                </div>
                                <div class="rq-day__topic" style="margin-top:12px">
                                    @if ($block['type'] === 'warmup')
                                        <div><span class="rq-tag">Tägliche Übung</span><div style="font-weight:500;margin-top:2px">{{ $plan['due'] > 0 ? $plan['due'].' Aufgaben fällig – gemischt aus allem, was du kannst' : 'Heute nichts fällig – super' }}</div></div>
                                        <div style="display:flex;gap:8px;flex-wrap:wrap">
                                            <x-raque.button size="sm" variant="outline" icon="bx bx-play" x-on:click="startBreak(blocks[{{ $i }}], 'Aufwärmen')">Dehnen starten</x-raque.button>
                                            <x-raque.button :href="route('practice')" size="sm" icon="bx bx-refresh" wire:navigate>Üben</x-raque.button>
                                        </div>
                                    @elseif ($block['type'] === 'cooldown')
                                        <div><span class="rq-tag">Rückblick</span><div style="font-weight:500;margin-top:2px">Drei Dinge, die du heute gelernt hast – laut sagen oder aufschreiben.</div></div>
                                        <div style="display:flex;gap:8px;flex-wrap:wrap">
                                            <x-raque.button size="sm" variant="outline" icon="bx bx-play" x-on:click="startBreak(blocks[{{ $i }}], 'Cool-down')">Dehnen starten</x-raque.button>
                                            <x-raque.button :href="route('dashboard')" size="sm" icon="bx bx-bar-chart-alt-2" wire:navigate>Dashboard</x-raque.button>
                                        </div>
                                    @else
                                        <div><span class="rq-tag">{{ collect($block['exercises'])->sum('seconds') + 30 }} Sekunden Sport</span><div style="font-weight:500;margin-top:2px">Danach: Snack, Wasser, kurz frische Luft.</div></div>
                                        <x-raque.button size="sm" icon="bx bx-play" x-on:click="startBreak(blocks[{{ $i }}], 'Bewegungspause')">Pause starten</x-raque.button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                <div class="rq-callout" style="margin-top:10px">
                    <i class="bx bx-bulb"></i>
                    <p><strong>Warum so?</strong> Zwei Lernblöcke mit Mikropause, danach richtig bewegen: Bewegung bringt Sauerstoff ins Gehirn und verbessert nachweislich Aufmerksamkeit und Gedächtnis. Die Fächer sind nach Gewichtung verzahnt, kurze Themen teilen sich eine Doppelstunde, lange werden aufgeteilt – und was liegen bleibt, rutscht automatisch in den nächsten Block.</p>
                </div>
            </div>
            </div>
        </div>
    </section>

    {{-- Pausen-Modus --}}
    <div class="rq-break" x-show="breakOpen" x-cloak x-transition.opacity :class="'rq-break--' + breakPhase" x-on:keydown.escape.window="closeBreak()">
        <button type="button" class="rq-break__close" x-on:click="closeBreak()" aria-label="Schließen"><i class="bx bx-x"></i></button>

        <div class="rq-break__inner">
            <span class="rq-break__eyebrow" x-text="breakTitle"></span>

            {{-- Ready --}}
            <template x-if="breakPhase === 'ready'">
                <div class="rq-break__ready">
                    <p class="rq-break__label">Gleich: <strong x-text="exercise().name"></strong></p>
                    <div class="rq-break__count" :key="readyCount" x-text="readyCount"></div>
                    <p class="rq-break__hint">Aufstehen, Platz schaffen, los geht's!</p>
                </div>
            </template>

            {{-- Go --}}
            <template x-if="breakPhase === 'go'">
                <div class="rq-break__stage">
                    <div class="rq-break__figure">
                        <svg viewBox="0 0 200 200" class="rq-fig" :class="'rq-fig--' + exercise().anim + (paused ? ' is-paused' : '')">
                            <line x1="30" y1="176" x2="170" y2="176" class="rq-fig__ground" />
                            <g class="rq-fig__all">
                                <g class="rq-fig__legs">
                                    <g class="rq-fig__leg rq-fig__leg--l"><line x1="100" y1="110" x2="88" y2="140" /><g class="rq-fig__shin rq-fig__shin--l"><line x1="88" y1="140" x2="84" y2="172" /><line x1="84" y1="172" x2="72" y2="172" /></g></g>
                                    <g class="rq-fig__leg rq-fig__leg--r"><line x1="100" y1="110" x2="112" y2="140" /><g class="rq-fig__shin rq-fig__shin--r"><line x1="112" y1="140" x2="116" y2="172" /><line x1="116" y1="172" x2="128" y2="172" /></g></g>
                                </g>
                                <g class="rq-fig__torso">
                                    <line x1="100" y1="110" x2="100" y2="58" class="rq-fig__spine" />
                                    <g class="rq-fig__arm rq-fig__arm--l"><line x1="100" y1="62" x2="84" y2="90" /><g class="rq-fig__fore rq-fig__fore--l"><line x1="84" y1="90" x2="78" y2="116" /></g></g>
                                    <g class="rq-fig__arm rq-fig__arm--r"><line x1="100" y1="62" x2="116" y2="90" /><g class="rq-fig__fore rq-fig__fore--r"><line x1="116" y1="90" x2="122" y2="116" /></g></g>
                                    <g class="rq-fig__head"><circle cx="100" cy="42" r="14" /></g>
                                </g>
                            </g>
                            <g class="rq-fig__breath" x-show="exercise().anim === 'breathe'"><circle cx="100" cy="100" r="60" /></g>
                            <g class="rq-fig__eyes" x-show="exercise().anim === 'eyes'"><circle cx="150" cy="60" r="8" /><circle cx="150" cy="60" r="3" /></g>
                        </svg>
                    </div>

                    <div class="rq-break__info">
                        <div class="rq-break__ring">
                            <svg viewBox="0 0 120 120">
                                <circle cx="60" cy="60" r="52" class="rq-ring__bg" />
                                <circle cx="60" cy="60" r="52" class="rq-ring__fg" :style="'stroke-dashoffset:' + (327 * (1 - remainingSec / exercise().seconds))" />
                            </svg>
                            <div class="rq-break__secs" x-text="remainingSec"></div>
                        </div>
                        <div>
                            <span class="rq-break__step" x-text="(exerciseIndex + 1) + ' / ' + breakExercises.length"></span>
                            <h2 class="rq-break__name" x-text="exercise().name"></h2>
                            <p class="rq-break__how" x-text="exercise().how"></p>
                            <p class="rq-break__tip"><i class="bx bx-bulb"></i><span x-text="exercise().tip"></span></p>
                        </div>
                    </div>
                </div>
            </template>

            {{-- Done --}}
            <template x-if="breakPhase === 'done'">
                <div class="rq-break__ready">
                    <div class="rq-break__trophy"><i class="bx bxs-trophy"></i></div>
                    <h2 class="rq-break__name" style="font-size:34px">Geschafft!</h2>
                    <p class="rq-break__hint" x-text="breakExercises.length + ' Übungen · ' + Math.round(breakExercises.reduce((s, e) => s + e.seconds, 0) / 60) + ' Minuten Bewegung. Jetzt Wasser trinken – und mit frischem Kopf weiter.'"></p>
                    <x-raque.button variant="on-primary" icon="bx bx-right-arrow-alt" x-on:click="closeBreak()">Zurück zum Schultag</x-raque.button>
                </div>
            </template>

            <div class="rq-break__dots" x-show="breakPhase !== 'done'">
                <template x-for="(e, i) in breakExercises" :key="'d' + i"><span :class="{ 'is-done': i < exerciseIndex, 'is-now': i === exerciseIndex }"></span></template>
            </div>
            <div class="rq-break__controls" x-show="breakPhase === 'go'">
                <button type="button" x-on:click="paused = !paused"><i :class="paused ? 'bx bx-play' : 'bx bx-pause'"></i><span x-text="paused ? 'Weiter' : 'Pause'"></span></button>
                <button type="button" x-on:click="nextExercise()"><i class="bx bx-skip-next"></i>Überspringen</button>
            </div>
        </div>

        <div class="rq-confetti" x-show="breakPhase === 'done'" aria-hidden="true">
            <template x-for="i in 70" :key="'c' + i"><span :style="confettiStyle(i)"></span></template>
        </div>
    </div>

    <script>
        function schoolDay(blocks, firstOpen) {
            return {
                blocks,
                firstOpen,
                now: new Date(),
                simulate: false,
                simMinutes: 8 * 60 + 20,
                current: null,
                state: 'before',
                breakOpen: false,
                breakTitle: '',
                breakPhase: 'ready',
                breakExercises: [],
                exerciseIndex: 0,
                readyCount: 3,
                remainingSec: 0,
                paused: false,
                timer: null,
                audio: null,

                init() {
                    this.update();
                    setInterval(() => { this.now = new Date(); this.update(); }, 1000);
                    this.$watch('simulate', () => this.update());
                    this.$watch('simMinutes', () => this.update());
                },
                minutes() {
                    if (this.simulate) return this.simMinutes;
                    return this.now.getHours() * 60 + this.now.getMinutes() + this.now.getSeconds() / 60;
                },
                update() {
                    const m = this.minutes();
                    this.current = this.blocks.find(b => m >= b.start && m < b.end) || null;
                    this.state = this.current ? 'in' : (m < this.blocks[0].start ? 'before' : 'after');
                },
                isDone(i) { const b = this.blocks[i]; return b.type === 'lesson' ? b.done : this.minutes() >= b.end; },
                isLate(i) { const b = this.blocks[i]; return b.type === 'lesson' && !b.done && this.minutes() >= b.end; },
                currentLesson() {
                    if (!this.current || !this.current.lessons.length) return null;
                    const m = this.minutes();
                    return this.current.lessons.find(l => m >= l.start && m < l.end) || null;
                },
                time(min) { return Math.floor(min / 60) + ':' + String(min % 60).padStart(2, '0'); },
                digital() {
                    const m = this.minutes();
                    const s = this.simulate ? 0 : this.now.getSeconds();
                    return this.time(Math.floor(m)) + ':' + String(s).padStart(2, '0');
                },
                remaining() {
                    const left = Math.ceil(this.current.end - this.minutes());
                    return left >= 60 ? Math.floor(left / 60) + ' Std. ' + (left % 60) + ' min' : left + ' min';
                },
                untilStart() {
                    const left = Math.ceil(this.blocks[0].start - this.minutes());
                    return left >= 60 ? Math.floor(left / 60) + ' Std. ' + (left % 60) + ' min' : left + ' min';
                },
                blockPercent() {
                    return Math.min(100, Math.max(0, Math.round((this.minutes() - this.current.start) / (this.current.end - this.current.start) * 100)));
                },
                dayPercent() {
                    const start = this.blocks[0].start, end = this.blocks[this.blocks.length - 1].end;
                    return Math.min(100, Math.max(0, Math.round((this.minutes() - start) / (end - start) * 100)));
                },
                hourAngle() { const m = this.minutes(); return ((m / 60) % 12) * 30; },
                minuteAngle() { return (this.minutes() % 60) * 6; },
                secondAngle() { return this.now.getSeconds() * 6; },

                // ---- Pausen-Modus ----
                startBreak(block, title) {
                    this.breakTitle = title;
                    this.breakExercises = block.exercises;
                    this.exerciseIndex = 0;
                    this.breakOpen = true;
                    this.paused = false;
                    this.ready();
                },
                exercise() { return this.breakExercises[this.exerciseIndex] || this.breakExercises[0]; },
                ready() {
                    clearInterval(this.timer);
                    this.breakPhase = 'ready';
                    this.readyCount = 3;
                    this.beep(660, 0.08);
                    this.timer = setInterval(() => {
                        this.readyCount--;
                        if (this.readyCount <= 0) { this.go(); } else { this.beep(660, 0.08); }
                    }, 1000);
                },
                go() {
                    clearInterval(this.timer);
                    this.breakPhase = 'go';
                    this.remainingSec = this.exercise().seconds;
                    this.beep(880, 0.2);
                    this.timer = setInterval(() => {
                        if (this.paused) return;
                        this.remainingSec--;
                        if (this.remainingSec <= 3 && this.remainingSec > 0) this.beep(660, 0.06);
                        if (this.remainingSec <= 0) this.nextExercise();
                    }, 1000);
                },
                nextExercise() {
                    clearInterval(this.timer);
                    if (this.exerciseIndex + 1 >= this.breakExercises.length) {
                        this.breakPhase = 'done';
                        this.beep(880, 0.12); setTimeout(() => this.beep(1100, 0.12), 150); setTimeout(() => this.beep(1320, 0.25), 300);
                        return;
                    }
                    this.exerciseIndex++;
                    this.ready();
                },
                closeBreak() {
                    clearInterval(this.timer);
                    this.breakOpen = false;
                },
                beep(freq, dur) {
                    try {
                        this.audio ||= new (window.AudioContext || window.webkitAudioContext)();
                        const o = this.audio.createOscillator(), g = this.audio.createGain();
                        o.type = 'sine'; o.frequency.value = freq;
                        g.gain.setValueAtTime(0.0001, this.audio.currentTime);
                        g.gain.exponentialRampToValueAtTime(0.25, this.audio.currentTime + 0.01);
                        g.gain.exponentialRampToValueAtTime(0.0001, this.audio.currentTime + dur);
                        o.connect(g).connect(this.audio.destination);
                        o.start(); o.stop(this.audio.currentTime + dur + 0.05);
                    } catch (e) {}
                },
                confettiStyle(i) {
                    const colors = ['#142fdb', '#7bb544', '#f2b827', '#00b2a9', '#ffffff'];
                    const left = (i * 37) % 100, delay = ((i * 13) % 20) / 10, dur = 2.5 + ((i * 7) % 15) / 10, rot = (i * 53) % 360;
                    return `left:${left}%;background:${colors[i % colors.length]};animation-delay:${delay}s;animation-duration:${dur}s;transform:rotate(${rot}deg)`;
                },
            };
        }
    </script>
</div>
