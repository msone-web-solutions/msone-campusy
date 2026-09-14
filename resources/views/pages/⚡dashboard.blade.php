<?php

use App\Enums\ProgressStatus;
use App\Models\QuizAttempt;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\TopicProgress;
use App\Review\ReviewPlanner;
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
    <x-raque.page-banner :title="'Hallo '.auth()->user()->name.'!'" eyebrow="Dein Dashboard">
        <p style="color:#fff;opacity:.9;margin-top:4px">Hier siehst du, wo du stehst – und wo es weitergeht.</p>
    </x-raque.page-banner>

    <section class="rq-section rq-section--tight rq-section--panel">
        <div class="rq-container rq-stack" style="gap:30px">
            @if ($this->dueCount > 0)
                <div class="rq-card" style="padding:25px 35px;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:20px;border-left:5px solid var(--color-secondary)">
                    <div>
                        <span class="rq-eyebrow" style="margin-bottom:4px;color:var(--color-secondary)">Tägliche Übung</span>
                        <h2 style="font-size:var(--fs-h3);font-weight:600;line-height:1.4">{{ $this->dueCount }} Aufgaben fällig · etwa {{ (int) ceil(min($this->dueCount, 10) * 0.6) }} Minuten</h2>
                        <p style="margin-top:4px">Gemischt aus allem, was du schon kannst – mit Abstand wiederholen ist der stärkste Lerneffekt.</p>
                    </div>
                    <x-raque.button icon="bx bx-refresh" :href="route('practice')" wire:navigate>Jetzt üben</x-raque.button>
                </div>
            @endif

            @if ($this->continueTopic)
                @php $t = $this->continueTopic; @endphp
                <div class="rq-card" style="padding:30px 35px;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:20px;border-left:5px solid var(--color-primary)">
                    <div>
                        <span class="rq-eyebrow" style="margin-bottom:4px">Weiter lernen</span>
                        <h2 style="font-size:var(--fs-h3);font-weight:600;line-height:1.4">{{ $t->title }}</h2>
                        <p style="margin-top:4px">{{ $t->topicArea->subject->name }} · Themenfeld {{ $t->topicArea->sort }} · {{ $t->topicArea->name }}</p>
                    </div>
                    <x-raque.button icon="bx bx-right-arrow-alt" :href="route('learn.topic', [$t->topicArea->subject, $t->topicArea, $t])" wire:navigate>Los geht's</x-raque.button>
                </div>
            @endif

            <div class="rq-grid rq-grid--4">
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

            <div class="rq-grid" style="grid-template-columns:3fr 2fr">
                <div>
                    <h2 style="font-size:var(--fs-h4);font-weight:600;margin-bottom:15px">Fortschritt je Fach</h2>
                    <div style="display:grid;gap:15px">
                        @foreach ($this->subjects as $subject)
                            @php
                                $topics = $subject->topicAreas->flatMap->topics;
                                $passed = $topics->filter(fn ($t) => $t->progress->first()?->status->isPassed() ?? false)->count();
                                $percent = $topics->isEmpty() ? 0 : (int) round($passed * 100 / $topics->count());
                            @endphp
                            <a href="{{ route('learn.subject', $subject) }}" wire:navigate wire:key="dash-subject-{{ $subject->id }}" class="rq-card rq-card--lift" style="display:block;padding:20px 25px">
                                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px">
                                    <span style="font-size:16.5px;font-weight:500">{{ $subject->name }}</span>
                                    <span class="rq-muted rq-num">{{ $passed }}/{{ $topics->count() }} · {{ $percent }} %</span>
                                </div>
                                <div class="rq-progress"><span style="width: {{ $percent }}%"></span></div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h2 style="font-size:var(--fs-h4);font-weight:600;margin-bottom:15px">Letzte Tests</h2>
                    @if ($this->recentAttempts->isEmpty())
                        <div class="rq-callout"><i class="bx bx-info-circle"></i><p>Noch kein Test gemacht. Such dir ein Thema aus und leg los!</p></div>
                    @else
                        <ul class="rq-list rq-card">
                            @foreach ($this->recentAttempts as $attempt)
                                <li class="rq-topic" style="padding:14px 20px" wire:key="attempt-{{ $attempt->id }}">
                                    <span class="rq-topic__nr {{ $attempt->passed ? 'rq-topic__nr--done' : '' }}" style="font-size:12px">{{ $attempt->percent() }}%</span>
                                    <span style="min-width:0;flex:1">
                                        <span class="rq-topic__title" style="font-size:15px">{{ $attempt->topic->title }}</span>
                                        <span class="rq-topic__intro">{{ $attempt->topic->topicArea->subject->name }} · {{ $attempt->finished_at->diffForHumans() }}</span>
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
