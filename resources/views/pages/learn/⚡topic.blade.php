<?php

use App\Enums\ProgressStatus;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\TopicArea;
use App\Models\TopicProgress;
use App\Review\ReviewPlanner;
use App\Support\Markdown;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

new #[Title('Thema')] class extends Component
{
    public Subject $subject;

    public TopicArea $topicArea;

    public Topic $topic;

    /** explain | notebook | quiz */
    #[Url(as: 'schritt')]
    public string $step = 'explain';

    /** @var array<int, int> ids of inline checks the student has answered this visit */
    public array $answeredChecks = [];

    public function mount(Subject $subject, TopicArea $topicArea, Topic $topic): void
    {
        $this->subject = $subject;
        $this->topicArea = $topicArea;
        $this->topic = $topic;

        if (! in_array($this->step, ['explain', 'notebook', 'quiz'], true)) {
            $this->step = 'explain';
        }

        TopicProgress::updateOrCreate(
            ['user_id' => auth()->id(), 'topic_id' => $topic->id],
            ['last_seen_at' => now()],
        );
    }

    #[Computed]
    public function progress(): TopicProgress
    {
        return TopicProgress::query()
            ->where('user_id', auth()->id())
            ->where('topic_id', $this->topic->id)
            ->firstOrFail();
    }

    #[Computed]
    public function nextTopic(): ?Topic
    {
        return $this->topic->nextTopic();
    }

    public function goTo(string $step): void
    {
        $this->step = $step;
        $this->js('window.scrollTo({ top: 0, behavior: "smooth" })');
    }

    public function confirmNotebook(): void
    {
        $progress = $this->progress;
        $progress->notebook_confirmed_at ??= now();
        $progress->advanceTo(ProgressStatus::NotebookDone);
        $progress->save();

        unset($this->progress);
        $this->goTo('quiz');
    }

    #[On('quiz-finished')]
    public function refreshProgress(): void
    {
        unset($this->progress);
    }

    #[On('check-answered')]
    public function noteCheck(int $questionId): void
    {
        if (! in_array($questionId, $this->answeredChecks, true)) {
            $this->answeredChecks[] = $questionId;
        }
    }

    #[Computed]
    public function checks(): \Illuminate\Support\Collection
    {
        return $this->topic->checks()->get();
    }

    #[Computed]
    public function warmup(): \Illuminate\Support\Collection
    {
        return app(ReviewPlanner::class)->warmupFor($this->topic);
    }

    /**
     * Segment i (0-based) is readable once the check that closes segment i-1 was answered.
     */
    public function segmentVisible(int $index): bool
    {
        if ($index === 0) {
            return true;
        }

        $gate = $this->checks->firstWhere('segment', $index);

        return $gate === null || in_array($gate->id, $this->answeredChecks, true);
    }

    public function render(): mixed
    {
        return $this->view([
            'segments' => array_map(fn (string $part) => Markdown::block($part), $this->topic->explanationSegments()),
            'notebookHtml' => Markdown::block($this->topic->notebook_entry),
        ]);
    }
};
?>

<div>
    <x-raque.page-banner :title="$topic->title" compact :eyebrow="'Themenfeld '.$topicArea->sort.' · Thema '.$topicArea->sort.'.'.$topic->sort" :crumbs="[['label' => 'Fächer', 'href' => route('learn.index')], ['label' => $subject->name, 'href' => route('learn.subject', $subject)], ['label' => $topicArea->name]]">
        <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:18px;align-items:center">
            <span class="rq-badge rq-badge--on-primary"><i class="bx bx-time"></i>ca. {{ $topic->estimated_minutes }} min</span>
            @if ($this->progress->status === ProgressStatus::Mastered)
                <span class="rq-badge rq-badge--on-primary"><i class="bx bxs-shield"></i>Gesichert · {{ $this->progress->best_percent }} %</span>
            @elseif ($this->progress->status === ProgressStatus::Passed)
                <span class="rq-badge rq-badge--on-primary"><i class="bx bx-check-circle"></i>Bestanden · {{ $this->progress->best_percent }} %</span>
            @elseif ($this->progress->best_percent > 0)
                <span class="rq-badge rq-badge--on-primary"><i class="bx bx-refresh"></i>Bester Versuch: {{ $this->progress->best_percent }} %</span>
            @endif
            <a href="{{ route('learn.topic.worksheet', [$subject, $topicArea, $topic]) }}" class="rq-btn rq-btn--on-primary rq-btn--sm rq-btn--icon" style="margin-left:auto"><i class="bx bxs-file-pdf"></i>Probearbeit als PDF</a>
        </div>
    </x-raque.page-banner>

    <section class="rq-section rq-section--tight rq-section--panel">
        <div class="rq-container" style="max-width:960px">
            @if ($topic->intro)
                <p style="font-size:16px;margin:-10px 0 30px;max-width:720px">{{ $topic->intro }}</p>
            @endif

            @php
                $steps = [
                    'explain' => ['nr' => 1, 'label' => 'Erklärung', 'icon' => 'bx bx-book-open'],
                    'notebook' => ['nr' => 2, 'label' => 'Hefteintrag', 'icon' => 'bx bx-pencil'],
                    'quiz' => ['nr' => 3, 'label' => 'Test', 'icon' => 'bx bx-task'],
                ];
                $done = [
                    'explain' => false,
                    'notebook' => $this->progress->notebook_confirmed_at !== null,
                    'quiz' => $this->progress->status->isPassed(),
                ];
            @endphp
            <nav aria-label="Schritte" class="rq-steps">
                @foreach ($steps as $key => $s)
                    <button type="button" wire:click="goTo('{{ $key }}')" wire:key="step-{{ $key }}" aria-current="{{ $step === $key ? 'step' : 'false' }}" @class(['rq-step', 'is-active' => $step === $key])>
                        <span @class(['rq-step__nr', 'rq-step__nr--done' => $done[$key]])>
                            @if ($done[$key])<i class="bx bx-check"></i>@else{{ $s['nr'] }}@endif
                        </span>
                        <i class="{{ $s['icon'] }}" style="font-size:20px"></i>
                        <span class="rq-step__label">{{ $s['label'] }}</span>
                    </button>
                @endforeach
            </nav>

            {{-- Step 1: Explanation --}}
            @if ($step === 'explain')
                @if ($this->warmup->isNotEmpty() && $this->topic->previousTopic())
                    <div class="rq-warmup">
                        <span class="rq-eyebrow" style="margin-bottom:2px">Kurz wiederholt</span>
                        <div style="font-size:var(--fs-lead);font-weight:600">Drei Aufgaben aus „{{ $this->topic->previousTopic()->title }}“</div>
                        <p style="font-size:14px;margin-top:4px">Was du zuletzt gelernt hast, kurz aus dem Gedächtnis holen – dann sitzt das Neue besser darauf.</p>
                        <div class="rq-warmup__grid">
                            @foreach ($this->warmup as $i => $wq)
                                <livewire:inline-check :question="$wq" :label="'Wiederholung '.($i + 1)" :key="'warm-'.$wq->id" />
                            @endforeach
                        </div>
                    </div>
                @endif

                <article class="rq-panel">
                    @if ($audioUrl = $topic->audioUrl())
                        <div class="rq-audio">
                            <div class="rq-audio__icon"><i class="bx bx-headphone"></i></div>
                            <div class="rq-audio__body">
                                <div class="rq-audio__title">Erklärung anhören</div>
                                <div class="rq-muted">Lass dir das Thema vorlesen – und lies unten mit.</div>
                                <audio controls preload="metadata" src="{{ $audioUrl }}" class="rq-audio__player">Dein Browser kann die Audiodatei nicht abspielen.</audio>
                            </div>
                        </div>
                    @endif

                    @php $allVisible = true; @endphp
                    @foreach ($segments as $i => $segmentHtml)
                        @if ($this->segmentVisible($i))
                            <div class="lesson-prose" wire:key="seg-{{ $i }}">{!! $segmentHtml !!}</div>
                            @php $gate = $this->checks->firstWhere('segment', $i + 1); @endphp
                            @if ($gate)
                                <livewire:inline-check :question="$gate" :key="'check-'.$gate->id" />
                            @endif
                        @else
                            @php $allVisible = false; @endphp
                            <div class="rq-locked" wire:key="lock-{{ $i }}"><i class="bx bx-lock-alt"></i>Beantworte die Aufgabe oben, dann geht die Erklärung weiter.</div>
                            @break
                        @endif
                    @endforeach

                    @if ($allVisible)
                        <hr class="rq-divider">
                        <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:15px">
                            <p>Alles verstanden? Dann kommt jetzt der Hefteintrag.</p>
                            <x-raque.button icon="bx bx-pencil" wire:click="goTo('notebook')">Weiter zum Hefteintrag</x-raque.button>
                        </div>
                    @endif
                </article>
            @endif

            {{-- Step 2: Notebook entry --}}
            @if ($step === 'notebook')
                <div style="display:grid;gap:25px">
                    <div class="rq-callout">
                        <i class="bx bx-pencil"></i>
                        <div>
                            <h4>Das kommt ins Heft</h4>
                            <p>Schreibe den Kasten unten <strong>vollständig</strong> in dein Mathe-Heft ab: Überschrift, Merksätze und Beispiele. Schreibe das Datum dazu. Nimm dir Zeit und schreibe ordentlich – dieser Eintrag ist deine Zusammenfassung zum Nachschlagen.</p>
                        </div>
                    </div>

                    <div class="rq-notebook">
                        <span class="rq-notebook__label">Hefteintrag · {{ $subject->name }} · {{ now()->translatedFormat('d.m.Y') }}</span>
                        <div class="notebook-prose">{!! $notebookHtml !!}</div>
                    </div>

                    <div class="rq-panel" style="padding:20px 25px;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:15px">
                        <x-raque.button variant="ghost" icon="bx bx-left-arrow-alt" wire:click="goTo('explain')">Zurück zur Erklärung</x-raque.button>
                        @if ($this->progress->notebook_confirmed_at)
                            <div style="display:flex;align-items:center;gap:15px;flex-wrap:wrap">
                                <span class="rq-badge rq-badge--green"><i class="bx bx-check"></i>Abgeschrieben am {{ $this->progress->notebook_confirmed_at->format('d.m.Y') }}</span>
                                <x-raque.button icon="bx bx-task" wire:click="goTo('quiz')">Zum Test</x-raque.button>
                            </div>
                        @else
                            <x-raque.button icon="bx bx-check" wire:click="confirmNotebook">Ich habe alles abgeschrieben</x-raque.button>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Step 3: Quiz --}}
            @if ($step === 'quiz')
                <div style="display:grid;gap:25px">
                    @if (! $this->progress->notebook_confirmed_at)
                        <div class="rq-callout"><i class="bx bx-error"></i><div><h4>Hefteintrag noch offen</h4><p>Du kannst den Test schon machen – schreib den Hefteintrag aber bitte trotzdem noch ab.</p></div></div>
                    @endif

                    <livewire:quiz-runner :topic="$topic" :key="'quiz-'.$topic->id" />

                    <div class="rq-callout">
                        <i class="bx bxs-file-pdf"></i>
                        <div style="flex:1;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:12px">
                            <div><h4>Probearbeit zum Ausdrucken</h4><p>Dieselben Aufgaben als Test auf Papier – mit Namensfeld, Punkten und Lösungsblatt auf der letzten Seite.</p></div>
                            <a href="{{ route('learn.topic.worksheet', [$subject, $topicArea, $topic]) }}" class="rq-btn rq-btn--outline rq-btn--sm rq-btn--icon"><i class="bx bx-download"></i>PDF herunterladen</a>
                        </div>
                    </div>

                    <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:15px">
                        <x-raque.button variant="ghost" icon="bx bx-left-arrow-alt" :href="route('learn.subject', $subject)" wire:navigate>Zur Themenübersicht</x-raque.button>
                        @if ($this->nextTopic)
                            <x-raque.button variant="outline" icon="bx bx-right-arrow-alt" :href="route('learn.topic', [$subject, $this->nextTopic->topicArea, $this->nextTopic])" wire:navigate>Nächstes Thema: {{ $this->nextTopic->title }}</x-raque.button>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>
