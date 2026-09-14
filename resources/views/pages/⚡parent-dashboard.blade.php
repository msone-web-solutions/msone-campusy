<?php

use App\Enums\ProgressStatus;
use App\Models\QuizAttempt;
use App\Models\Topic;
use App\Models\TopicProgress;
use App\Models\User;
use App\Review\ReviewPlanner;
use App\Schedule\Curriculum;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Elternübersicht')] class extends Component
{
    /**
     * @return Collection<int, User>
     */
    #[Computed]
    public function children(): Collection
    {
        return auth()->user()->children()->orderBy('name')->get();
    }

    /**
     * @return array<string, mixed>
     */
    public function reportFor(User $child): array
    {
        $weekStart = now()->startOfWeek();
        $attempts = QuizAttempt::query()->where('user_id', $child->id)->whereNotNull('finished_at')->with('topic.topicArea')->latest('finished_at')->get();
        $thisWeek = $attempts->where('finished_at', '>=', $weekStart);
        $progress = TopicProgress::query()->where('user_id', $child->id)->get();
        $planner = app(ReviewPlanner::class);

        $activeDays = $attempts->map(fn (QuizAttempt $a) => $a->finished_at->toDateString())->unique();
        $streak = 0;
        for ($d = now()->startOfDay(); $activeDays->contains($d->toDateString()); $d = $d->subDay()) {
            $streak++;
        }

        return [
            'passed' => $progress->filter(fn (TopicProgress $p) => $p->status->isPassed())->count(),
            'mastered' => $progress->where('status', ProgressStatus::Mastered)->count(),
            'total' => Topic::count(),
            'testsThisWeek' => $thisWeek->pluck('topic_id')->unique()->count(),
            'attemptsThisWeek' => $thisWeek->count(),
            'avgThisWeek' => $thisWeek->isEmpty() ? null : (int) round($thisWeek->avg(fn (QuizAttempt $a) => $a->percent())),
            'passedThisWeek' => $thisWeek->where('passed', true)->pluck('topic.title')->unique()->values(),
            'due' => $planner->dueCountFor($child),
            'stumbling' => $planner->stumblingBlocksFor($child)->take(6),
            'explanations' => $attempts->whereNotNull('self_explanation')->take(3),
            'lastActive' => $attempts->first()?->finished_at,
            'streak' => $streak,
            'recent' => $attempts->take(5),
            'pace' => Curriculum::for($child)->pace(now()),
        ];
    }
};
?>

<div>
    <x-raque.page-banner title="Elternübersicht" eyebrow="Wochenbericht" :crumbs="[['label' => 'Dashboard', 'href' => route('dashboard')], ['label' => 'Eltern']]">
        <p style="color:#fff;opacity:.9;margin-top:4px">Was in dieser Woche gelernt wurde, wo es hakt – und was dein Kind in eigenen Worten erklärt hat.</p>
    </x-raque.page-banner>

    <section class="rq-section rq-section--tight rq-section--panel">
        <div class="rq-container rq-stack">
            @forelse ($this->children as $child)
                @php $r = $this->reportFor($child); @endphp
                <div wire:key="child-{{ $child->id }}" style="display:grid;gap:20px">
                    <div style="display:flex;flex-wrap:wrap;align-items:baseline;justify-content:space-between;gap:10px">
                        <h2 style="font-size:26px;font-weight:600">{{ $child->name }}</h2>
                        <span class="rq-muted">Zuletzt aktiv: {{ $r['lastActive']?->diffForHumans() ?? 'noch nie' }} · Lernsträhne: {{ $r['streak'] }} {{ $r['streak'] === 1 ? 'Tag' : 'Tage' }}</span>
                    </div>

                    @php $pace = $r['pace']; @endphp
                    <div class="rq-card" style="padding:18px 25px;display:flex;align-items:center;gap:25px;flex-wrap:wrap;border-left:5px solid {{ $pace['backlog_blocks'] > 0 ? 'var(--micko-amber-500)' : 'var(--color-success)' }}">
                        @if ($pace['backlog_blocks'] > 0)
                            <span class="rq-badge rq-badge--amber" style="font-size:13px;padding:6px 12px"><i class="bx bx-error"></i>Rückstand: {{ $pace['backlog_blocks'] }} {{ $pace['backlog_blocks'] === 1 ? 'Block' : 'Blöcke' }} · ≈ {{ number_format(abs($pace['backlog_days']), 1, ',', '.') }} Schultage</span>
                        @elseif ($pace['backlog_blocks'] < 0)
                            <span class="rq-badge rq-badge--green" style="font-size:13px;padding:6px 12px"><i class="bx bx-trending-up"></i>Vorsprung: {{ abs($pace['backlog_blocks']) }} Blöcke</span>
                        @else
                            <span class="rq-badge rq-badge--green" style="font-size:13px;padding:6px 12px"><i class="bx bx-check-circle"></i>Im Plan</span>
                        @endif
                        <div style="flex:1;min-width:200px">
                            <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:6px"><span>Ist {{ $pace['percent_done'] }} %</span><span class="rq-muted">Soll {{ $pace['percent_expected'] }} %</span></div>
                            <div class="rq-progress rq-pace" style="height:10px"><span class="rq-pace__soll" style="width:{{ $pace['percent_expected'] }}%"></span><span class="rq-pace__ist" style="width:{{ $pace['percent_done'] }}%"></span></div>
                        </div>
                        <span class="rq-muted">Voraussichtlich fertig: <strong style="color:var(--text-heading)">{{ $pace['finish_date']?->format('d.m.Y') ?? '–' }}</strong></span>
                        <x-raque.button size="sm" variant="outline" icon="bx bx-cog" :href="route('parent.schedule', $child)" wire:navigate>Stundenplan einstellen</x-raque.button>
                    </div>

                    <div class="rq-grid rq-grid--4">
                        @foreach ([
                            ['Themen bestanden', $r['passed'].' / '.$r['total'], 'bx bx-check-circle'],
                            ['Davon gesichert', $r['mastered'], 'bx bx-shield-quarter'],
                            ['Themen getestet (Woche)', $r['testsThisWeek'].($r['attemptsThisWeek'] > $r['testsThisWeek'] ? ' · '.$r['attemptsThisWeek'].' Versuche' : '').($r['avgThisWeek'] !== null ? ' · Ø '.$r['avgThisWeek'].' %' : ''), 'bx bx-task'],
                            ['Wiederholungen fällig', $r['due'], 'bx bx-refresh'],
                        ] as [$label, $value, $icon])
                            <div class="rq-card rq-stat-tile"><div class="rq-stat-tile__label"><i class="{{ $icon }}"></i>{{ $label }}</div><div class="rq-stat-tile__value" style="font-size:24px">{{ $value }}</div></div>
                        @endforeach
                    </div>

                    <div class="rq-grid rq-grid--2">
                        <div class="rq-card" style="padding:25px">
                            <h3 style="font-size:var(--fs-h4);font-weight:600;margin-bottom:10px">Diese Woche bestanden</h3>
                            @forelse ($r['passedThisWeek'] as $title)
                                <p style="display:flex;gap:8px;align-items:center"><i class="bx bx-check" style="color:var(--color-secondary);font-size:20px"></i>{{ $title }}</p>
                            @empty
                                <p>Noch kein Thema in dieser Woche abgeschlossen.</p>
                            @endforelse
                            <h3 style="font-size:var(--fs-h4);font-weight:600;margin:20px 0 10px">Letzte Tests</h3>
                            @forelse ($r['recent'] as $a)
                                <p style="display:flex;justify-content:space-between;gap:10px"><span>{{ $a->topic->title }}</span><span class="rq-num" style="color:{{ $a->passed ? 'var(--color-secondary)' : 'var(--color-primary)' }};font-weight:600">{{ $a->percent() }} %</span></p>
                            @empty
                                <p>Noch keine Tests.</p>
                            @endforelse
                        </div>
                        <div class="rq-card" style="padding:25px">
                            <h3 style="font-size:var(--fs-h4);font-weight:600;margin-bottom:10px">Stolpersteine</h3>
                            <p style="font-size:14px;margin-bottom:10px">Aufgaben, die zuletzt falsch waren – hier lohnt sich gemeinsames Nachschauen.</p>
                            @forelse ($r['stumbling'] as $block)
                                <p style="display:flex;gap:8px;align-items:flex-start;font-size:14px"><i class="bx bx-error-circle" style="color:var(--color-primary);font-size:18px;flex:0 0 auto"></i><span>{!! \App\Support\Markdown::inline(str_replace('___', '…', $block->question->prompt)) !!} <span class="rq-muted">({{ $block->question->topic->title }})</span></span></p>
                            @empty
                                <p>Keine – alles läuft rund.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="rq-card" style="padding:25px">
                        <h3 style="font-size:var(--fs-h4);font-weight:600;margin-bottom:10px">In eigenen Worten</h3>
                        <p style="font-size:14px;margin-bottom:12px">Nach jedem bestandenen Test erklärt dein Kind das Thema selbst. Das ist die beste Gelegenheit für ein kurzes Gespräch: „Erzähl mir mal …“</p>
                        @forelse ($r['explanations'] as $a)
                            <blockquote style="margin:0 0 12px;padding:12px 16px;border-left:4px solid var(--color-secondary);background:var(--surface-panel);border-radius:0 5px 5px 0">
                                <p style="font-style:italic">„{{ $a->self_explanation }}“</p>
                                <p class="rq-muted" style="margin-top:4px">{{ $a->topic->title }} · {{ $a->finished_at->format('d.m.Y') }}</p>
                            </blockquote>
                        @empty
                            <p>Noch keine Erklärungen.</p>
                        @endforelse
                    </div>
                </div>
            @empty
                <div class="rq-card" style="padding:35px 40px">
                    <h2 style="font-size:var(--fs-h3);font-weight:600">Noch kein Kind verknüpft</h2>
                    <p style="margin-top:6px">Dein Kind trägt in seinen Einstellungen unter „Familie“ deine E-Mail-Adresse <strong>{{ auth()->user()->email }}</strong> ein. Danach erscheint hier der Wochenbericht.</p>
                </div>
            @endforelse
        </div>
    </section>
</div>
