<?php

use App\Enums\ProgressStatus;
use App\Enums\QuestionType;
use App\Models\Question;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use App\Models\Topic;
use App\Models\TopicProgress;
use App\Quiz\AnswerGrader;
use App\Quiz\CorrectAnswerFormatter;
use App\Review\ReviewPlanner;
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

    /** Self-rated confidence before the test: 1 = unsicher, 2 = geht so, 3 = sicher */
    #[Locked]
    public ?int $confidence = null;

    #[Locked]
    public int $wrongStreak = 0;

    public string $selfExplanation = '';

    #[Locked]
    public bool $explanationSaved = false;

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
        return $this->topic->testQuestions()->get();
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

    public function start(int $confidence): void
    {
        $this->questionIds = $this->questions->pluck('id')->all();

        if ($this->questionIds === []) {
            return;
        }

        $attempt = QuizAttempt::create([
            'user_id' => auth()->id(),
            'topic_id' => $this->topic->id,
            'max_score' => $this->questions->sum('points'),
            'confidence' => max(1, min(3, $confidence)),
            'started_at' => now(),
        ]);

        $this->confidence = $attempt->confidence;
        $this->attemptId = $attempt->id;
        $this->index = 0;
        $this->results = [];
        $this->wrongStreak = 0;
        $this->selfExplanation = '';
        $this->explanationSaved = false;
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
        $this->wrongStreak = $this->wasCorrect ? 0 : $this->wrongStreak + 1;

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
        $this->phase = 'intro';
        $this->attemptId = null;
        unset($this->attempt);
    }

    public function saveExplanation(): void
    {
        $attempt = $this->attempt;
        $text = trim($this->selfExplanation);

        if ($attempt === null || mb_strlen($text) < 20) {
            $this->addError('selfExplanation', 'Schreib bitte mindestens zwei Sätze (ab 20 Zeichen).');

            return;
        }

        $attempt->update(['self_explanation' => $text]);
        $this->explanationSaved = true;
        unset($this->attempt);
    }

    /**
     * How the self-rating compared to the result – the metacognitive mirror.
     *
     * @return array{tone: string, text: string}
     */
    public function calibration(int $percent): array
    {
        $expected = match ($this->confidence) { 3 => 85, 2 => 65, default => 45 };
        $label = match ($this->confidence) { 3 => 'sicher', 2 => 'geht so', default => 'unsicher' };

        if ($percent - $expected >= 20) {
            return ['tone' => 'green', 'text' => "Du hattest dich als „{$label}“ eingeschätzt – und warst besser als gedacht ({$percent} %). Trau dir mehr zu!"];
        }

        if ($expected - $percent >= 20) {
            return ['tone' => 'red', 'text' => "Du hattest dich als „{$label}“ eingeschätzt, erreicht hast du {$percent} %. Das ist ein Zeichen, dass sich das Thema sicherer anfühlt, als es sitzt – genau dafür sind die Wiederholungen da."];
        }

        return ['tone' => 'grey', 'text' => "Deine Einschätzung („{$label}“) passte gut zum Ergebnis ({$percent} %). Sich selbst richtig einzuschätzen ist eine echte Stärke beim Lernen."];
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

        // Every test question now enters the spaced-review queue; wrong ones as "Stolpersteine".
        app(ReviewPlanner::class)->enrollAttempt($attempt->fresh(['answers', 'topic.questions']));

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

    public function correctAnswerText(Question $question): string
    {
        return app(CorrectAnswerFormatter::class)->format($question);
    }

    public function render(): mixed
    {
        return $this->view([
            'md' => Markdown::class,
            'notebookHtml' => Markdown::block($this->topic->notebook_entry),
        ]);
    }
};
?>

<div class="rq-card" style="overflow:hidden">
    @php $total = count($this->questionIds); @endphp

    {{-- Intro with self-assessment --}}
    @if ($phase === 'intro')
        <div style="padding:35px 40px;display:flex;gap:25px;align-items:flex-start;flex-wrap:wrap">
            <div class="rq-feature__icon" style="margin:0"><i class="bx bx-task"></i></div>
            <div style="flex:1;min-width:260px">
                <h2 style="font-size:var(--fs-h3);font-weight:600;line-height:1.4">Test: {{ $topic->title }}</h2>
                <p style="margin-top:6px">{{ $this->questions->count() }} Aufgaben, von leicht nach schwer · Bestanden ab {{ $topic->pass_percent }} %. Nach jeder Aufgabe siehst du sofort, ob deine Antwort richtig war. Du kannst den Test so oft wiederholen, wie du willst.</p>
                <ul class="rq-list" style="margin-top:14px;display:grid;gap:6px">
                    <li class="rq-muted" style="display:flex;gap:8px;align-items:center"><i class="bx bx-check" style="color:var(--color-secondary);font-size:20px"></i>Dezimalzahlen mit Komma (−2,5), Brüche mit Schrägstrich (-3/4)</li>
                    <li class="rq-muted" style="display:flex;gap:8px;align-items:center"><i class="bx bx-check" style="color:var(--color-secondary);font-size:20px"></i>Rechne im Heft oder im Kopf – kein Taschenrechner</li>
                </ul>

                <div style="margin-top:25px;padding:20px 22px;background:var(--surface-panel);border-radius:var(--radius-card)">
                    <div style="font-size:var(--fs-lead);font-weight:600;margin-bottom:4px">Kurz vorher: Wie gut kannst du das Thema schon?</div>
                    <p style="font-size:14px;margin-bottom:14px">Schätz dich ehrlich ein – nach dem Test vergleichen wir. Das trainiert, das eigene Können richtig einzuschätzen.</p>
                    <div style="display:flex;flex-wrap:wrap;gap:10px">
                        <x-raque.button variant="outline" size="sm" icon="bx bx-meh" wire:click="start(1)" :disabled="$this->questions->isEmpty()">Noch unsicher</x-raque.button>
                        <x-raque.button variant="outline" size="sm" icon="bx bx-smile" wire:click="start(2)" :disabled="$this->questions->isEmpty()">Geht so</x-raque.button>
                        <x-raque.button size="sm" icon="bx bx-happy-beaming" wire:click="start(3)" :disabled="$this->questions->isEmpty()">Sicher – los!</x-raque.button>
                    </div>
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
                <span class="rq-muted">{{ $q->type->label() }} · {{ ['', 'leicht', 'mittel', 'schwer'][$q->difficulty] ?? '' }}</span>
            </div>
            <div class="rq-progress"><span style="width: {{ ($index + ($checked ? 1 : 0)) * 100 / max($total, 1) }}%;background:var(--color-primary)"></span></div>
        </div>

        <div style="padding:35px 40px" wire:key="question-{{ $q->id }}">
            <x-question.fields :question="$q" :disabled="$checked" />

            @if ($checked)
                <div style="margin-top:25px;display:grid;gap:15px" wire:key="feedback-{{ $q->id }}">
                    <x-question.feedback :question="$q" :correct="$wasCorrect" :correct-answer="$this->correctAnswerText($q)" />

                    @if (! $wasCorrect && $wrongStreak >= 2)
                        <div class="rq-notebook" style="padding:22px 28px">
                            <span class="rq-notebook__label">Kurz nachschauen – dein Hefteintrag</span>
                            <div class="notebook-prose" style="font-size:15px;line-height:1.8">{!! $notebookHtml !!}</div>
                        </div>
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
        @php $attempt = $this->attempt; $percent = $attempt->percent(); $cal = $this->calibration($percent); @endphp
        <div style="padding:35px 40px;display:grid;gap:25px">
            <div style="display:flex;flex-wrap:wrap;align-items:center;gap:25px">
                <div @class(['rq-score', 'rq-score--fail' => ! $attempt->passed])>
                    <strong>{{ $percent }} %</strong>
                    <span>{{ $attempt->score }}/{{ $attempt->max_score }}</span>
                </div>
                <div style="flex:1;min-width:260px">
                    @if ($attempt->passed)
                        <h2 style="font-size:var(--fs-h3);font-weight:600">Bestanden – stark!</h2>
                        <p style="margin-top:6px">{{ $attempt->score }} von {{ $attempt->max_score }} Punkten. Die Aufgaben kommen ab morgen in deine tägliche Übung – erst wenn sie dort mehrmals mit Abstand sitzen, gilt das Thema als <strong>gesichert</strong>.</p>
                    @else
                        <h2 style="font-size:var(--fs-h3);font-weight:600">Noch nicht bestanden</h2>
                        <p style="margin-top:6px">{{ $attempt->score }} von {{ $attempt->max_score }} Punkten, nötig sind {{ $topic->pass_percent }} %. Schau dir unten die Erklärungen zu den falschen Aufgaben an und versuch es gleich nochmal.</p>
                    @endif
                    <div style="margin-top:18px;display:flex;flex-wrap:wrap;gap:12px">
                        <x-raque.button icon="bx bx-refresh" wire:click="restart">Nochmal versuchen</x-raque.button>
                        <x-raque.button variant="outline" icon="bx bx-book-open" wire:click="$parent.goTo('explain')">Erklärung nochmal lesen</x-raque.button>
                    </div>
                </div>
            </div>

            <div class="rq-callout {{ $cal['tone'] === 'green' ? 'rq-callout--green' : ($cal['tone'] === 'red' ? 'rq-callout--red' : '') }}">
                <i class="bx bx-target-lock"></i>
                <div><h4>Selbsteinschätzung vs. Ergebnis</h4><p>{{ $cal['text'] }}</p></div>
            </div>

            @if ($attempt->passed)
                <div class="rq-panel rq-panel--grey" style="padding:25px">
                    <div style="font-size:var(--fs-lead);font-weight:600;margin-bottom:4px"><i class="bx bx-edit" style="color:var(--color-primary)"></i> In eigenen Worten</div>
                    <p style="font-size:14px;margin-bottom:12px">{{ $topic->reflectPrompt() }}</p>
                    @if ($explanationSaved)
                        <div class="rq-callout rq-callout--green"><i class="bx bx-check"></i><div><p><strong>Gespeichert.</strong> {{ $attempt->self_explanation }}</p></div></div>
                    @else
                        <textarea id="self-explanation" wire:model="selfExplanation" rows="3" class="rq-input" style="height:auto;padding:12px 15px;font-family:var(--font-body)" placeholder="Ich habe gelernt, dass …"></textarea>
                        @error('selfExplanation')<div style="color:var(--color-primary);font-size:13px;margin-top:6px">{{ $message }}</div>@enderror
                        <div style="margin-top:12px"><x-raque.button size="sm" icon="bx bx-save" wire:click="saveExplanation">Speichern</x-raque.button></div>
                    @endif
                </div>
            @endif

            <div>
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
        </div>
    @endif
</div>
