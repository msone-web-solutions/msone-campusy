<?php

use App\Enums\QuestionType;
use App\Models\Question;
use App\Quiz\AnswerGrader;
use App\Quiz\CorrectAnswerFormatter;
use Livewire\Attributes\Locked;
use Livewire\Component;

/**
 * A single "Jetzt du"-question inside the explanation (or in the warm-up block).
 * Announces the outcome to the page so the next text segment can be revealed.
 */
new class extends Component
{
    public Question $question;

    public string $label = 'Jetzt du';

    public mixed $given = null;

    #[Locked]
    public bool $checked = false;

    #[Locked]
    public bool $wasCorrect = false;

    #[Locked]
    public int $tries = 0;

    public function mount(Question $question, string $label = 'Jetzt du'): void
    {
        $this->question = $question;
        $this->label = $label;
        $this->given = match ($question->type) {
            QuestionType::MultipleChoice, QuestionType::GapText => [],
            default => null,
        };
    }

    public function check(AnswerGrader $grader): void
    {
        if ($this->checked) {
            return;
        }

        $this->wasCorrect = $grader->isCorrect($this->question, $this->given);
        $this->checked = true;
        $this->tries++;
        $this->dispatch('check-answered', questionId: $this->question->id, correct: $this->wasCorrect);
    }

    public function retry(): void
    {
        $this->checked = false;
        $this->wasCorrect = false;
        $this->given = match ($this->question->type) {
            QuestionType::MultipleChoice, QuestionType::GapText => [],
            default => null,
        };
    }

    public function correctAnswerText(): string
    {
        return app(CorrectAnswerFormatter::class)->format($this->question);
    }
};
?>

<div class="rq-check">
    <div class="rq-check__head"><i class="bx bx-pencil"></i><span>{{ $label }}</span></div>
    <x-question.fields :question="$question" :disabled="$checked" compact />
    @if ($checked)
        <div style="margin-top:14px">
            <x-question.feedback :question="$question" :correct="$wasCorrect" :correct-answer="$this->correctAnswerText()" />
        </div>
    @endif
    <div style="margin-top:14px;display:flex;gap:10px;justify-content:flex-end">
        @if (! $checked)
            <x-raque.button size="sm" icon="bx bx-check" wire:click="check">Prüfen</x-raque.button>
        @elseif (! $wasCorrect && $tries < 2)
            <x-raque.button size="sm" variant="outline" icon="bx bx-refresh" wire:click="retry">Nochmal versuchen</x-raque.button>
        @endif
    </div>
</div>
