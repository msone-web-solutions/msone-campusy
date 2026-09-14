<?php

use App\Enums\ProgressStatus;
use App\Enums\QuestionType;
use App\Models\Question;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use App\Models\Topic;
use App\Models\TopicProgress;
use App\Quiz\AnswerGrader;
use App\Support\Markdown;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

new class extends Component
{
    public Topic $topic;

    /** intro | question | result */
    public string $phase = 'intro';

    /** @var array<int, int> */
    #[Locked]
    public array $questionIds = [];

    #[Locked]
    public int $index = 0;

    #[Locked]
    public ?int $attemptId = null;

    public mixed $given = null;

    #[Locked]
    public bool $checked = false;

    #[Locked]
    public bool $wasCorrect = false;

    /** @var array<int, bool> question id → correct */
    #[Locked]
    public array $results = [];

    public function mount(Topic $topic): void
    {
        $this->topic = $topic;
    }

    /**
     * @return Collection<int, Question>
     */
    #[Computed]
    public function questions(): Collection
    {
        return $this->topic->questions()->get();
    }

    #[Computed]
    public function current(): ?Question
    {
        $id = $this->questionIds[$this->index] ?? null;

        return $id ? $this->questions->firstWhere('id', $id) : null;
    }

    #[Computed]
    public function attempt(): ?QuizAttempt
    {
        return $this->attemptId ? QuizAttempt::find($this->attemptId) : null;
    }

    public function start(): void
    {
        $this->questionIds = $this->questions->pluck('id')->all();

        if ($this->questionIds === []) {
            return;
        }

        $attempt = QuizAttempt::create([
            'user_id' => auth()->id(),
            'topic_id' => $this->topic->id,
            'max_score' => $this->questions->sum('points'),
            'started_at' => now(),
        ]);

        $this->attemptId = $attempt->id;
        $this->index = 0;
        $this->results = [];
        $this->phase = 'question';
        $this->prepareAnswer();
        unset($this->attempt);
    }

    public function check(AnswerGrader $grader): void
    {
        $question = $this->current;

        if ($this->checked || $question === null || $this->attempt === null) {
            return;
        }

        $this->wasCorrect = $grader->isCorrect($question, $this->given);
        $this->checked = true;
        $this->results[$question->id] = $this->wasCorrect;

        QuizAnswer::create([
            'quiz_attempt_id' => $this->attempt->id,
            'question_id' => $question->id,
            'given' => is_array($this->given) ? $this->given : [$this->given],
            'is_correct' => $this->wasCorrect,
        ]);
    }

    public function next(): void
    {
        if (! $this->checked) {
            return;
        }

        if ($this->index + 1 >= count($this->questionIds)) {
            $this->finish();

            return;
        }

        $this->index++;
        $this->prepareAnswer();
        $this->js('window.scrollTo({ top: 0, behavior: "smooth" })');
    }

    public function restart(): void
    {
        $this->start();
    }

    private function finish(): void
    {
        $attempt = $this->attempt;

        if ($attempt === null) {
            return;
        }

        $score = $this->questions
            ->filter(fn (Question $q) => $this->results[$q->id] ?? false)
            ->sum('points');
        $percent = $attempt->max_score === 0 ? 0 : (int) round($score * 100 / $attempt->max_score);
        $passed = $percent >= $this->topic->pass_percent;

        $attempt->update([
            'score' => $score,
            'passed' => $passed,
            'finished_at' => now(),
        ]);

        $progress = TopicProgress::firstOrCreate(
            ['user_id' => auth()->id(), 'topic_id' => $this->topic->id],
        );
        $progress->best_percent = max($progress->best_percent, $percent);
        if ($passed) {
            $progress->advanceTo(ProgressStatus::Passed);
        }
        $progress->last_seen_at = now();
        $progress->save();

        unset($this->attempt);
        $this->phase = 'result';
        $this->dispatch('quiz-finished');
    }

    private function prepareAnswer(): void
    {
        $this->checked = false;
        $this->wasCorrect = false;
        $this->given = match ($this->current?->type) {
            QuestionType::MultipleChoice, QuestionType::GapText => [],
            default => null,
        };
    }

    /**
     * @return array<int, string>
     */
    public function gapParts(Question $question): array
    {
        return explode('___', $question->prompt);
    }

    public function correctAnswerText(Question $question): string
    {
        return match ($question->type) {
            QuestionType::SingleChoice => (string) ($question->options[$question->answer['index']] ?? ''),
            QuestionType::MultipleChoice => collect($question->answer['indexes'] ?? [])
                ->map(fn (int $i) => $question->options[$i] ?? '')
                ->join(', '),
            QuestionType::TrueFalse => ($question->answer['value'] ?? false) ? 'Wahr' : 'Falsch',
            QuestionType::Numeric => str_replace('.', ',', (string) ($question->answer['value'] ?? implode(' oder ', $question->answer['values'] ?? []))),
            QuestionType::GapText => collect($question->answer['gaps'] ?? [])
                ->map(fn (array $gap) => (string) $gap[0])
                ->join(' · '),
        };
    }

    public function render(): mixed
    {
        return $this->view([
            'md' => Markdown::class,
        ]);
    }
};
?>

<div class="rq-card" style="overflow:hidden">
    @php $total = count($this->questionIds); @endphp

    {{-- Intro --}}
    @if ($phase === 'intro')
        <div style="padding:35px 40px;display:flex;gap:25px;align-items:flex-start;flex-wrap:wrap">
            <div class="rq-feature__icon" style="margin:0"><i class="bx bx-task"></i></div>
            <div style="flex:1;min-width:260px">
                <h2 style="font-size:var(--fs-h3);font-weight:600;line-height:1.4">Test: {{ $topic->title }}</h2>
                <p style="margin-top:6px">{{ $this->questions->count() }} Aufgaben · Bestanden ab {{ $topic->pass_percent }} %. Nach jeder Aufgabe siehst du sofort, ob deine Antwort richtig war. Du kannst den Test so oft wiederholen, wie du willst.</p>
                <ul class="rq-list" style="margin-top:18px;display:grid;gap:8px">
                    <li class="rq-muted" style="display:flex;gap:8px;align-items:center"><i class="bx bx-check" style="color:var(--color-secondary);font-size:20px"></i>Dezimalzahlen mit Komma eingeben, z. B. <code>−2,5</code></li>
                    <li class="rq-muted" style="display:flex;gap:8px;align-items:center"><i class="bx bx-check" style="color:var(--color-secondary);font-size:20px"></i>Brüche mit Schrägstrich, z. B. <code>-3/4</code></li>
                    <li class="rq-muted" style="display:flex;gap:8px;align-items:center"><i class="bx bx-check" style="color:var(--color-secondary);font-size:20px"></i>Rechne im Heft oder im Kopf – kein Taschenrechner nötig</li>
                </ul>
                <div style="margin-top:25px">
                    <x-raque.button icon="bx bx-play" wire:click="start" :disabled="$this->questions->isEmpty()">Test starten</x-raque.button>
                </div>
            </div>
        </div>
    @endif

    {{-- Question --}}
    @if ($phase === 'question' && $this->current)
        @php $q = $this->current; @endphp
        <div style="padding:20px 40px;border-bottom:1px solid var(--raque-line-blue)">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px">
                <span style="font-size:var(--fs-base);font-weight:500">Aufgabe {{ $index + 1 }} von {{ $total }}</span>
                <span class="rq-muted">{{ $q->type->label() }}</span>
            </div>
            <div class="rq-progress"><span style="width: {{ ($index + ($checked ? 1 : 0)) * 100 / max($total, 1) }}%;background:var(--color-primary)"></span></div>
        </div>

        <div style="padding:35px 40px" wire:key="question-{{ $q->id }}">
            @if ($q->type !== \App\Enums\QuestionType::GapText)
                <div class="lesson-prose" style="font-family:var(--font-ui);font-size:19px;font-weight:500;color:var(--text-heading);margin-bottom:25px;max-width:none">{!! $md::inline($q->prompt) !!}</div>
            @endif

            <fieldset @disabled($checked) style="border:0;padding:0;margin:0;display:grid;gap:10px">
                @switch($q->type)
                    @case(\App\Enums\QuestionType::SingleChoice)
                        @foreach ($q->options as $i => $option)
                            <label class="rq-option" wire:key="opt-{{ $q->id }}-{{ $i }}">
                                <input type="radio" name="given-{{ $q->id }}" value="{{ $i }}" wire:model="given">
                                <span>{!! $md::inline($option) !!}</span>
                            </label>
                        @endforeach
                        @break

                    @case(\App\Enums\QuestionType::MultipleChoice)
                        @foreach ($q->options as $i => $option)
                            <label class="rq-option" wire:key="opt-{{ $q->id }}-{{ $i }}">
                                <input type="checkbox" value="{{ $i }}" wire:model="given">
                                <span>{!! $md::inline($option) !!}</span>
                            </label>
                        @endforeach
                        @break

                    @case(\App\Enums\QuestionType::TrueFalse)
                        <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px">
                            <label class="rq-option"><input type="radio" name="given-{{ $q->id }}" value="true" wire:model="given"><i class="bx bx-check" style="font-size:20px;color:var(--color-secondary)"></i><span>Wahr</span></label>
                            <label class="rq-option"><input type="radio" name="given-{{ $q->id }}" value="false" wire:model="given"><i class="bx bx-x" style="font-size:20px;color:var(--color-primary)"></i><span>Falsch</span></label>
                        </div>
                        @break

                    @case(\App\Enums\QuestionType::Numeric)
                        <div style="display:flex;align-items:center;gap:12px;max-width:360px">
                            <input id="numeric-answer" class="rq-input" style="font-size:18px" type="text" inputmode="text" autocomplete="off" placeholder="Ergebnis" wire:model="given" wire:keydown.enter="check" autofocus>
                            @if (! empty($q->options['unit']))<span style="font-size:18px;color:var(--text-body)">{{ $q->options['unit'] }}</span>@endif
                        </div>
                        <span class="rq-muted" style="font-size:13px">Komma für Dezimalzahlen (−2,5), Schrägstrich für Brüche (-3/4).</span>
                        @break

                    @case(\App\Enums\QuestionType::GapText)
                        <div style="font-size:19px;font-weight:500;line-height:2.4;color:var(--text-heading)">
                            @foreach ($this->gapParts($q) as $i => $part)
                                <span>{!! $md::inline($part) !!}</span>
                                @if (! $loop->last)
                                    <input id="gap-{{ $q->id }}-{{ $i }}" type="text" class="rq-gap" wire:model="given.{{ $i }}" wire:keydown.enter="check" autocomplete="off">
                                @endif
                            @endforeach
                        </div>
                        @break
                @endswitch
            </fieldset>

            @if ($checked)
                <div style="margin-top:25px" wire:key="feedback-{{ $q->id }}">
                    @if ($wasCorrect)
                        <div class="rq-callout rq-callout--green"><i class="bx bx-check-circle"></i><div><h4>Richtig!</h4>@if ($q->explanation)<p>{!! $md::inline($q->explanation) !!}</p>@endif</div></div>
                    @else
                        <div class="rq-callout rq-callout--red"><i class="bx bx-x-circle"></i><div><h4>Leider falsch. Richtig wäre: {!! $md::inline($this->correctAnswerText($q)) !!}</h4>@if ($q->explanation)<p>{!! $md::inline($q->explanation) !!}</p>@endif</div></div>
                    @endif
                </div>
            @endif

            <div style="margin-top:25px;display:flex;justify-content:flex-end;gap:12px">
                @if (! $checked)
                    <x-raque.button icon="bx bx-check" wire:click="check">Prüfen</x-raque.button>
                @else
                    <x-raque.button icon="bx bx-right-arrow-alt" wire:click="next" autofocus>{{ $index + 1 >= $total ? 'Auswertung anzeigen' : 'Nächste Aufgabe' }}</x-raque.button>
                @endif
            </div>
        </div>
    @endif

    {{-- Result --}}
    @if ($phase === 'result' && $this->attempt)
        @php $attempt = $this->attempt; $percent = $attempt->percent(); @endphp
        <div style="padding:35px 40px">
            <div style="display:flex;flex-wrap:wrap;align-items:center;gap:25px">
                <div @class(['rq-score', 'rq-score--fail' => ! $attempt->passed])>
                    <strong>{{ $percent }} %</strong>
                    <span>{{ $attempt->score }}/{{ $attempt->max_score }}</span>
                </div>
                <div style="flex:1;min-width:260px">
                    @if ($attempt->passed)
                        <h2 style="font-size:var(--fs-h3);font-weight:600">Bestanden – stark!</h2>
                        <p style="margin-top:6px">Du hast {{ $attempt->score }} von {{ $attempt->max_score }} Punkten erreicht. Das Thema ist abgehakt. Du kannst trotzdem jederzeit nochmal üben.</p>
                    @else
                        <h2 style="font-size:var(--fs-h3);font-weight:600">Noch nicht bestanden</h2>
                        <p style="margin-top:6px">Du hast {{ $attempt->score }} von {{ $attempt->max_score }} Punkten. Zum Bestehen brauchst du {{ $topic->pass_percent }} %. Schau dir die Erklärungen zu den falschen Aufgaben an und versuch es gleich nochmal.</p>
                    @endif
                    <div style="margin-top:18px;display:flex;flex-wrap:wrap;gap:12px">
                        <x-raque.button icon="bx bx-refresh" wire:click="restart">Nochmal versuchen</x-raque.button>
                        <x-raque.button variant="outline" icon="bx bx-book-open" wire:click="$parent.goTo('explain')">Erklärung nochmal lesen</x-raque.button>
                    </div>
                </div>
            </div>

            <hr class="rq-divider">

            <h3 style="font-size:var(--fs-h4);font-weight:600;margin-bottom:12px">Deine Antworten</h3>
            <ol class="rq-list">
                @foreach ($this->questions as $i => $question)
                    @php $ok = $this->results[$question->id] ?? false; @endphp
                    <li style="display:flex;gap:12px;padding:12px 0;border-top:1px solid var(--raque-line-blue)" wire:key="result-{{ $question->id }}">
                        <i class="bx {{ $ok ? 'bx-check-circle' : 'bx-x-circle' }}" style="font-size:22px;flex:0 0 auto;color:{{ $ok ? 'var(--color-secondary)' : 'var(--color-primary)' }}"></i>
                        <div style="min-width:0;flex:1">
                            <div style="font-size:var(--fs-base);font-weight:500">{!! $md::inline(str_replace('___', '…', $question->prompt)) !!}</div>
                            @unless ($ok)
                                <p style="font-size:14px;margin-top:4px"><strong>Richtig: {!! $md::inline($this->correctAnswerText($question)) !!}</strong>@if ($question->explanation) – {!! $md::inline($question->explanation) !!}@endif</p>
                            @endunless
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    @endif
</div>
