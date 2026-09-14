<?php

use App\Enums\QuestionType;
use App\Models\Question;
use App\Models\ReviewItem;
use App\Quiz\AnswerGrader;
use App\Quiz\CorrectAnswerFormatter;
use App\Review\ReviewPlanner;
use App\Support\Markdown;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Tägliche Übung')] class extends Component
{
    /** intro | question | result | empty */
    public string $phase = 'intro';

    /** @var array<int, int> review item ids */
    #[Locked]
    public array $itemIds = [];

    #[Locked]
    public int $index = 0;

    public mixed $given = null;

    #[Locked]
    public bool $checked = false;

    #[Locked]
    public bool $wasCorrect = false;

    /** @var array<int, bool> item id → correct */
    #[Locked]
    public array $results = [];

    public function mount(): void
    {
        if (app(ReviewPlanner::class)->dueCountFor(auth()->user()) === 0) {
            $this->phase = 'empty';
        }
    }

    #[Computed]
    public function dueCount(): int
    {
        return app(ReviewPlanner::class)->dueCountFor(auth()->user());
    }

    #[Computed]
    public function items(): Collection
    {
        return ReviewItem::query()->whereIn('id', $this->itemIds)->with('question.topic.topicArea')->get()->sortBy(fn (ReviewItem $i) => array_search($i->id, $this->itemIds, true))->values();
    }

    #[Computed]
    public function current(): ?ReviewItem
    {
        $id = $this->itemIds[$this->index] ?? null;

        return $id ? $this->items->firstWhere('id', $id) : null;
    }

    #[Computed]
    public function stumblingBlocks(): Collection
    {
        return app(ReviewPlanner::class)->stumblingBlocksFor(auth()->user());
    }

    public function start(): void
    {
        $this->itemIds = app(ReviewPlanner::class)->dueItemsFor(auth()->user())->pluck('id')->all();

        if ($this->itemIds === []) {
            $this->phase = 'empty';

            return;
        }

        $this->index = 0;
        $this->results = [];
        $this->phase = 'question';
        unset($this->items);
        $this->prepareAnswer();
    }

    public function check(AnswerGrader $grader, ReviewPlanner $planner): void
    {
        $item = $this->current;

        if ($this->checked || $item === null) {
            return;
        }

        $this->wasCorrect = $grader->isCorrect($item->question, $this->given);
        $this->checked = true;
        $this->results[$item->id] = $this->wasCorrect;
        $planner->recordAnswer($item, $this->wasCorrect);
    }

    public function next(): void
    {
        if (! $this->checked) {
            return;
        }

        if ($this->index + 1 >= count($this->itemIds)) {
            $this->phase = 'result';
            unset($this->dueCount, $this->stumblingBlocks);

            return;
        }

        $this->index++;
        $this->prepareAnswer();
        $this->js('window.scrollTo({ top: 0, behavior: "smooth" })');
    }

    private function prepareAnswer(): void
    {
        $this->checked = false;
        $this->wasCorrect = false;
        $this->given = match ($this->current?->question->type) {
            QuestionType::MultipleChoice, QuestionType::GapText => [],
            default => null,
        };
    }

    public function correctAnswerText(Question $question): string
    {
        return app(CorrectAnswerFormatter::class)->format($question);
    }

    public function render(): mixed
    {
        return $this->view(['md' => Markdown::class]);
    }
};
?>

<div>
    <x-raque.page-banner title="Tägliche Übung" compact eyebrow="Wiederholen mit Abstand · gemischt aus allen Themen" :crumbs="[['label' => 'Dashboard', 'href' => route('dashboard')], ['label' => 'Üben']]" />

    <section class="rq-section rq-section--tight rq-section--panel">
        <div class="rq-container" style="max-width:860px;display:grid;gap:25px">

            @if ($phase === 'empty')
                <div class="rq-card" style="padding:35px 40px;display:flex;gap:25px;align-items:flex-start;flex-wrap:wrap">
                    <div class="rq-feature__icon" style="margin:0;background:var(--color-secondary);color:#fff"><i class="bx bx-check-double"></i></div>
                    <div style="flex:1;min-width:260px">
                        <h2 style="font-size:var(--fs-h3);font-weight:600">Heute ist nichts fällig</h2>
                        <p style="margin-top:6px">Sobald du einen Themen-Test bestanden hast, kommen seine Aufgaben mit wachsendem Abstand hier wieder dran: nach 1, 3, 7, 14 und 30 Tagen. So bleibt das Gelernte – das ist der am besten belegte Lerntrick überhaupt.</p>
                        <div style="margin-top:18px"><x-raque.button icon="bx bx-book-open" :href="route('learn.index')" wire:navigate>Zu den Fächern</x-raque.button></div>
                    </div>
                </div>
            @endif

            @if ($phase === 'intro')
                <div class="rq-card" style="padding:35px 40px;display:flex;gap:25px;align-items:flex-start;flex-wrap:wrap">
                    <div class="rq-feature__icon" style="margin:0"><i class="bx bx-refresh"></i></div>
                    <div style="flex:1;min-width:260px">
                        <h2 style="font-size:var(--fs-h3);font-weight:600">{{ min($this->dueCount, \App\Review\ReviewPlanner::SESSION_SIZE) }} Aufgaben fällig · etwa {{ (int) ceil(min($this->dueCount, \App\Review\ReviewPlanner::SESSION_SIZE) * 0.6) }} Minuten</h2>
                        <p style="margin-top:6px">Die Aufgaben kommen aus verschiedenen Themen, bunt gemischt – du musst also jedes Mal selbst erkennen, welche Regel gerade dran ist. Das ist anstrengender als Üben am Stück, aber genau deshalb bleibt es länger hängen.</p>
                        <ul class="rq-list" style="margin-top:14px;display:grid;gap:6px">
                            <li class="rq-muted" style="display:flex;gap:8px;align-items:center"><i class="bx bx-check" style="color:var(--color-secondary);font-size:20px"></i>Richtig → die Aufgabe kommt später wieder (3, 7, 14, 30 Tage)</li>
                            <li class="rq-muted" style="display:flex;gap:8px;align-items:center"><i class="bx bx-check" style="color:var(--color-secondary);font-size:20px"></i>Falsch → sie landet bei den Stolpersteinen und kommt morgen nochmal</li>
                        </ul>
                        <div style="margin-top:22px"><x-raque.button icon="bx bx-play" wire:click="start">Übung starten</x-raque.button></div>
                    </div>
                </div>
            @endif

            @if ($phase === 'question' && $this->current)
                @php $item = $this->current; $q = $item->question; $total = count($this->itemIds); @endphp
                <div class="rq-card" style="overflow:hidden">
                    <div style="padding:20px 40px;border-bottom:1px solid var(--raque-line-blue)">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;flex-wrap:wrap;gap:8px">
                            <span style="font-size:var(--fs-base);font-weight:500">Aufgabe {{ $index + 1 }} von {{ $total }}</span>
                            <span class="rq-badge {{ $item->box === 0 ? 'rq-badge--red' : '' }}"><i class="bx bx-folder"></i>{{ $q->topic->topicArea->sort }}.{{ $q->topic->sort }} {{ $q->topic->title }}</span>
                        </div>
                        <div class="rq-progress"><span style="width: {{ ($index + ($checked ? 1 : 0)) * 100 / max($total, 1) }}%;background:var(--color-primary)"></span></div>
                    </div>
                    <div style="padding:35px 40px" wire:key="item-{{ $item->id }}">
                        <x-question.fields :question="$q" :disabled="$checked" />
                        @if ($checked)
                            <div style="margin-top:25px" wire:key="fb-{{ $item->id }}">
                                <x-question.feedback :question="$q" :correct="$wasCorrect" :correct-answer="$this->correctAnswerText($q)" />
                                @unless ($wasCorrect)
                                    <p class="rq-muted" style="margin-top:10px"><a href="{{ route('learn.topic', [$q->topic->topicArea->subject, $q->topic->topicArea, $q->topic]) }}" wire:navigate style="color:var(--color-primary);font-weight:600">Erklärung zu „{{ $q->topic->title }}“ nochmal ansehen →</a></p>
                                @endunless
                            </div>
                        @endif
                        <div style="margin-top:25px;display:flex;justify-content:flex-end">
                            @if (! $checked)
                                <x-raque.button icon="bx bx-check" wire:click="check">Prüfen</x-raque.button>
                            @else
                                <x-raque.button icon="bx bx-right-arrow-alt" wire:click="next" autofocus>{{ $index + 1 >= $total ? 'Fertig' : 'Nächste Aufgabe' }}</x-raque.button>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if ($phase === 'result')
                @php $correct = collect($this->results)->filter()->count(); $total = count($this->results); $percent = $total ? (int) round($correct * 100 / $total) : 0; @endphp
                <div class="rq-card" style="padding:35px 40px;display:flex;flex-wrap:wrap;align-items:center;gap:25px">
                    <div @class(['rq-score', 'rq-score--fail' => $percent < 70])><strong>{{ $percent }} %</strong><span>{{ $correct }}/{{ $total }}</span></div>
                    <div style="flex:1;min-width:260px">
                        <h2 style="font-size:var(--fs-h3);font-weight:600">Übung geschafft</h2>
                        <p style="margin-top:6px">{{ $correct }} von {{ $total }} richtig. Die richtigen Aufgaben kommen mit größerem Abstand wieder, die falschen morgen nochmal.
                            @if ($this->dueCount > 0) Es sind noch {{ $this->dueCount }} Aufgaben fällig. @else Für heute ist alles erledigt. @endif</p>
                        <div style="margin-top:18px;display:flex;flex-wrap:wrap;gap:12px">
                            @if ($this->dueCount > 0)<x-raque.button icon="bx bx-play" wire:click="start">Weiter üben</x-raque.button>@endif
                            <x-raque.button variant="outline" icon="bx bx-home" :href="route('dashboard')" wire:navigate>Zum Dashboard</x-raque.button>
                        </div>
                    </div>
                </div>
            @endif

            @if ($phase !== 'question' && $this->stumblingBlocks->isNotEmpty())
                <div>
                    <h2 style="font-size:var(--fs-h4);font-weight:600;margin-bottom:4px">Meine Stolpersteine</h2>
                    <p style="font-size:14px;margin-bottom:12px">Aufgaben, die zuletzt falsch waren. Sie verschwinden, sobald sie zweimal hintereinander richtig sind.</p>
                    <ul class="rq-list rq-card">
                        @foreach ($this->stumblingBlocks as $block)
                            <li class="rq-topic" style="padding:12px 20px" wire:key="sb-{{ $block->id }}">
                                <span class="rq-topic__nr rq-topic__nr--started" style="font-size:12px">{{ $block->question->topic->topicArea->sort }}.{{ $block->question->topic->sort }}</span>
                                <span style="min-width:0;flex:1">
                                    <span class="rq-topic__title" style="font-size:15px">{!! $md::inline(str_replace('___', '…', $block->question->prompt)) !!}</span>
                                    <span class="rq-topic__intro">{{ $block->question->topic->title }} · {{ $block->lapses }}× falsch</span>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </section>
</div>
