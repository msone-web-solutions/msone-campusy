<?php

use App\Enums\ProgressStatus;
use App\Models\QuizAttempt;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\TopicProgress;
use App\Review\ReviewPlanner;
use App\Schedule\Curriculum;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Dashboard')] class extends Component
{
    /**
     * @return Collection<int, Subject>
     */
    #[Computed]
    public function subjects(): Collection
    {
        return Subject::query()
            ->orderBy('sort')
            ->with(['topicAreas.topics.progress' => fn ($q) => $q->where('user_id', auth()->id())])
            ->get();
    }

    #[Computed]
    public function continueTopic(): ?Topic
    {
        $lastSeen = TopicProgress::query()
            ->where('user_id', auth()->id())
            ->whereNotIn('status', [ProgressStatus::Passed, ProgressStatus::Mastered])
            ->latest('last_seen_at')
            ->with('topic.topicArea.subject')
            ->first();

        if ($lastSeen) {
            return $lastSeen->topic;
        }

        return $this->subjects
            ->flatMap(fn (Subject $s) => $s->topicAreas->flatMap->topics)
            ->first(fn (Topic $t) => ! ($t->progress->first()?->status->isPassed() ?? false));
    }

    /**
     * @return array<string, mixed>
     */
    #[Computed]
    public function pace(): array
    {
        return Curriculum::for(auth()->user())->pace(now());
    }

    #[Computed]
    public function dueCount(): int
    {
        return app(ReviewPlanner::class)->dueCountFor(auth()->user());
    }

    /**
     * @return Collection<int, QuizAttempt>
     */
    #[Computed]
    public function recentAttempts(): Collection
    {
        return QuizAttempt::query()
            ->where('user_id', auth()->id())
            ->whereNotNull('finished_at')
            ->latest('finished_at')
            ->with('topic.topicArea.subject')
            ->limit(6)
            ->get();
    }

    /**
     * @return array{total: int, passed: int, mastered: int, notebooks: int, attempts: int}
     */
    #[Computed]
    public function stats(): array
    {
        $topics = $this->subjects->flatMap(fn (Subject $s) => $s->topicAreas->flatMap->topics);
        $progress = TopicProgress::query()->where('user_id', auth()->id())->get();

        return [
            'total' => $topics->count(),
            'passed' => $progress->filter(fn (TopicProgress $p) => $p->status->isPassed())->count(),
            'mastered' => $progress->where('status', ProgressStatus::Mastered)->count(),
            'notebooks' => $progress->whereNotNull('notebook_confirmed_at')->count(),
            'attempts' => QuizAttempt::query()->where('user_id', auth()->id())->whereNotNull('finished_at')->distinct('topic_id')->count('topic_id'),
        ];
    }
};
?>

<div>
    @php $stats = $this->stats; @endphp
    <x-raque.shell>
        <x-slot:left>
            <x-raque.profile-card
                :name="auth()->user()->name"
                headline="Klasse 7 · Sekundarschule Sachsen-Anhalt"
                :badges="[
                    ['icon' => 'bx bx-task', 'label' => 'Erster Test', 'earned' => $stats['attempts'] > 0],
                    ['icon' => 'bx bx-check-circle', 'label' => '5 Themen bestanden', 'earned' => $stats['passed'] >= 5],
                    ['icon' => 'bx bx-shield-quarter', 'label' => 'Erstes Thema gesichert', 'earned' => $stats['mastered'] > 0],
                    ['icon' => 'bx bx-pencil', 'label' => '10 Hefteinträge', 'earned' => $stats['notebooks'] >= 10],
                    ['icon' => 'bx bx-trophy', 'label' => 'Halbzeit', 'earned' => $stats['total'] > 0 && $stats['passed'] * 2 >= $stats['total']],
                ]"
                :stats="[
                    ['label' => 'Themen bestanden', 'value' => $stats['passed'].' / '.$stats['total']],
                    ['label' => 'Davon gesichert', 'value' => $stats['mastered']],
                    ['label' => 'Themen getestet', 'value' => $stats['attempts']],
                    ['label' => 'Hefteinträge', 'value' => $stats['notebooks']],
                    ['label' => 'Fällige Übungen', 'value' => $this->dueCount],
                    ['label' => 'Lernstand', 'value' => $this->pace['backlog_blocks'] > 0 ? $this->pace['backlog_blocks'].' Blöcke Rückstand' : ($this->pace['backlog_blocks'] < 0 ? abs($this->pace['backlog_blocks']).' Blöcke Vorsprung' : 'im Plan')],
                ]"
                footer="Zum Stundenplan"
                :footer-href="route('school-day')" />

            <x-raque.card title="Fortschritt je Fach">
                @foreach ($this->subjects as $subject)
                    @php
                        $topics = $subject->topicAreas->flatMap->topics;
                        $passed = $topics->filter(fn ($t) => $t->progress->first()?->status->isPassed() ?? false)->count();
                        $percent = $topics->isEmpty() ? 0 : (int) round($passed * 100 / $topics->count());
                    @endphp
                    <a href="{{ route('learn.subject', $subject) }}" wire:navigate wire:key="dash-subject-{{ $subject->id }}" style="display:block;padding:15px 20px;border-bottom:1px solid var(--border-default)">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                            <span style="font-weight:500">{{ $subject->name }}</span>
                            <span class="rq-muted rq-num">{{ $passed }}/{{ $topics->count() }} · {{ $percent }} %</span>
                        </div>
                        <div class="rq-progress"><span style="width: {{ $percent }}%"></span></div>
                    </a>
                @endforeach
                <a href="{{ route('learn.index') }}" class="rq-card__footer-link" wire:navigate>Alle Fächer</a>
            </x-raque.card>
        </x-slot:left>

        {{-- Feed --}}
        @php $pace = $this->pace; @endphp
        @if ($pace['backlog_blocks'] > 0)
            <x-raque.card style="border-left:5px solid var(--micko-amber-500)">
                <div style="display:flex;gap:1rem;padding:var(--pad-post-head)">
                    <span class="rq-row__avatar" style="width:42px;height:42px;font-size:18px;background:var(--micko-amber-500);color:#fff"><i class="bx bx-error"></i></span>
                    <div style="min-width:0;flex:1">
                        <span style="display:block;font-weight:500;margin-bottom:5px">Rückstand: {{ $pace['backlog_blocks'] }} {{ $pace['backlog_blocks'] === 1 ? 'Block' : 'Blöcke' }}</span>
                        <span style="font-size:var(--fs-xs);color:var(--text-secondary)">≈ {{ number_format(abs($pace['backlog_days']), 1, ',', '.') }} Schultage hinter dem Plan · Ist {{ $pace['percent_done'] }} % · Soll {{ $pace['percent_expected'] }} %</span>
                    </div>
                </div>
                <div style="padding:var(--pad-post-body)"><div class="rq-progress rq-pace" style="height:10px"><span class="rq-pace__soll" style="width:{{ $pace['percent_expected'] }}%"></span><span class="rq-pace__ist" style="width:{{ $pace['percent_done'] }}%"></span></div></div>
                <div style="display:flex;gap:8px;padding:var(--pad-post-actions);border-top:1px solid var(--border-default)">
                    <x-raque.button icon="bx bx-time-five" :href="route('school-day')" wire:navigate>Heute aufholen</x-raque.button>
                    <x-raque.button variant="cancel" icon="bx bx-calendar-week" :href="route('week-plan')" wire:navigate>Wochenplan</x-raque.button>
                </div>
            </x-raque.card>
        @endif

        @if ($this->continueTopic)
            @php $t = $this->continueTopic; @endphp
            <x-raque.card>
                <div style="display:flex;gap:1rem;padding:var(--pad-post-head)">
                    <span class="rq-row__avatar" style="width:42px;height:42px;font-size:18px;background:var(--color-primary);color:#fff"><i class="bx bx-play"></i></span>
                    <div style="min-width:0;flex:1">
                        <span style="display:block;font-weight:500;margin-bottom:5px">Weiter lernen</span>
                        <span style="font-size:var(--fs-xs);color:var(--text-secondary)">{{ $t->topicArea->subject->name }} · Themenfeld {{ $t->topicArea->sort }} · {{ $t->topicArea->name }}</span>
                    </div>
                </div>
                <div style="padding:var(--pad-post-body)">
                    <h2 style="font-size:var(--fs-lg);font-weight:600;line-height:1.4;margin-bottom:6px">{{ $t->title }}</h2>
                    <p>{{ $t->intro }}</p>
                </div>
                <div style="display:flex;gap:8px;padding:var(--pad-post-actions);border-top:1px solid var(--border-default)">
                    <x-raque.button icon="bx bx-right-arrow-alt" :href="route('learn.topic', [$t->topicArea->subject, $t->topicArea, $t])" wire:navigate>Los geht's</x-raque.button>
                    <x-raque.button variant="cancel" icon="bx bx-book-open" :href="route('learn.subject', $t->topicArea->subject)" wire:navigate>{{ $t->topicArea->subject->name }}</x-raque.button>
                </div>
            </x-raque.card>
        @endif

        @if ($this->dueCount > 0)
            <x-raque.card>
                <div style="display:flex;gap:1rem;padding:var(--pad-post-head)">
                    <span class="rq-row__avatar" style="width:42px;height:42px;font-size:18px;background:var(--color-success);color:#fff"><i class="bx bx-refresh"></i></span>
                    <div style="min-width:0;flex:1">
                        <span style="display:block;font-weight:500;margin-bottom:5px">Tägliche Übung</span>
                        <span style="font-size:var(--fs-xs);color:var(--text-secondary)">{{ $this->dueCount }} Aufgaben fällig · etwa {{ (int) ceil(min($this->dueCount, 10) * 0.6) }} Minuten</span>
                    </div>
                </div>
                <div style="padding:var(--pad-post-body)"><p>Gemischt aus allem, was du schon kannst – mit Abstand wiederholen ist der stärkste Lerneffekt.</p></div>
                <div style="padding:var(--pad-post-actions);border-top:1px solid var(--border-default)">
                    <x-raque.button icon="bx bx-refresh" :href="route('practice')" wire:navigate>Jetzt üben</x-raque.button>
                </div>
            </x-raque.card>
        @endif

        <div class="rq-grid rq-grid--2" style="gap:var(--space-20)">
            @foreach ([
                ['label' => 'Themen bestanden', 'value' => $stats['passed'].' / '.$stats['total'], 'icon' => 'bx bx-check-circle'],
                ['label' => 'Davon gesichert', 'value' => $stats['mastered'], 'icon' => 'bx bx-shield-quarter'],
                ['label' => 'Themen getestet', 'value' => $stats['attempts'], 'icon' => 'bx bx-task'],
                ['label' => 'Fächer', 'value' => $this->subjects->count(), 'icon' => 'bx bx-book-open'],
            ] as $tile)
                <div class="rq-card rq-stat-tile">
                    <div class="rq-stat-tile__label"><i class="{{ $tile['icon'] }}"></i>{{ $tile['label'] }}</div>
                    <div class="rq-stat-tile__value">{{ $tile['value'] }}</div>
                </div>
            @endforeach
        </div>

        <x-raque.card title="Letzte Tests" footer="Alle Fächer" :footer-href="route('learn.index')">
            @if ($this->recentAttempts->isEmpty())
                <p style="padding:30px 20px;text-align:center">Noch kein Test gemacht. Such dir ein Thema aus und leg los!</p>
            @else
                @foreach ($this->recentAttempts as $attempt)
                    <x-raque.row wire:key="attempt-{{ $attempt->id }}"
                        :title="$attempt->topic->title"
                        :sub="$attempt->topic->topicArea->subject->name.' · '.$attempt->finished_at->diffForHumans()"
                        :nr="$attempt->percent().'%'"
                        :href="route('learn.topic', [$attempt->topic->topicArea->subject, $attempt->topic->topicArea, $attempt->topic])"
                        :style="$attempt->passed ? '--row-ok:1' : ''">
                        <span class="rq-badge {{ $attempt->passed ? 'rq-badge--green' : 'rq-badge--amber' }}">{{ $attempt->passed ? 'Bestanden' : 'Nochmal' }}</span>
                    </x-raque.row>
                @endforeach
            @endif
        </x-raque.card>

        <x-slot:right>
            <x-raque.card title="Entdecken" footer="Alle Fächer" :footer-href="route('learn.index')">
                <div class="rq-explore">
                    @foreach ($this->subjects as $subject)
                        <div class="rq-explore__group" wire:key="explore-{{ $subject->id }}">
                            <h6>{{ $subject->name }}</h6>
                            <ul>
                                @foreach ($subject->topicAreas as $area)
                                    <li><a href="{{ route('learn.subject', $subject) }}#tf-{{ $area->sort }}" wire:navigate>#{{ $area->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </x-raque.card>

            <x-raque.card title="Nächste Themen" footer="Zum Stundenplan" :footer-href="route('school-day')">
                @foreach ($this->subjects as $subject)
                    @php $next = $subject->topicAreas->flatMap->topics->first(fn ($t) => ! ($t->progress->first()?->status->isPassed() ?? false)); @endphp
                    @if ($next)
                        <x-raque.row wire:key="next-{{ $subject->id }}" :title="$next->title" :sub="$subject->name.' · TF '.$next->topicArea->sort"
                            :icon="['mathematik' => 'bx bx-math', 'chemie' => 'bx bx-test-tube', 'informatik' => 'bx bx-code-alt'][$subject->slug] ?? 'bx bx-book'"
                            :href="route('learn.topic', [$subject, $next->topicArea, $next])">
                            <a href="{{ route('learn.topic', [$subject, $next->topicArea, $next]) }}" class="rq-icon-btn rq-icon-btn--sm rq-icon-btn--outlined" aria-label="Öffnen" wire:navigate><i class="bx bx-right-arrow-alt"></i></a>
                        </x-raque.row>
                    @endif
                @endforeach
            </x-raque.card>

            <div class="rq-card rq-banner-card">
                <div class="rq-banner-card__inner">
                    <div class="rq-banner-card__overlay">
                        <span class="rq-banner-card__eyebrow">Dein Schultag</span>
                        <h4>Drei Doppelstunden, zwei Bewegungspausen – 8 bis 13 Uhr.</h4>
                        <div><x-raque.button variant="on-primary" :href="route('school-day')" wire:navigate>Stundenplan öffnen</x-raque.button></div>
                    </div>
                </div>
            </div>
        </x-slot:right>
    </x-raque.shell>
</div>
