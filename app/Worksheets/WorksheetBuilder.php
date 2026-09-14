<?php

namespace App\Worksheets;

use App\Enums\QuestionType;
use App\Models\Question;
use App\Models\Topic;
use App\Support\Markdown;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as PdfDocument;

/**
 * Turns a topic's question pool into a printable "Probearbeit" (a classroom-style
 * test sheet) with a header block, numbered tasks with answer space, and an
 * answer key on the last page.
 */
class WorksheetBuilder
{
    public function build(Topic $topic): PdfDocument
    {
        $topic->loadMissing(['topicArea.subject', 'questions']);

        $tasks = $topic->questions->values()->map(fn (Question $q, int $i) => [
            'nr' => $i + 1,
            'points' => $q->points,
            'type' => $q->type,
            'prompt' => $this->promptHtml($q),
            'options' => $q->options && in_array($q->type, [QuestionType::SingleChoice, QuestionType::MultipleChoice], true)
                ? array_map(fn ($o) => Markdown::inline((string) $o), $q->options)
                : [],
            'unit' => $q->options['unit'] ?? null,
            'hint' => $this->hint($q),
            'solution' => Markdown::inline($this->solutionText($q)),
            'explanation' => $q->explanation ? Markdown::inline($q->explanation) : null,
        ]);

        return Pdf::loadView('pdf.worksheet', [
            'topic' => $topic,
            'area' => $topic->topicArea,
            'subject' => $topic->topicArea->subject,
            'tasks' => $tasks,
            'totalPoints' => $tasks->sum('points'),
        ])->setPaper('a4');
    }

    public function filename(Topic $topic): string
    {
        return sprintf('probearbeit-%d-%d-%s.pdf', $topic->topicArea->sort, $topic->sort, $topic->slug);
    }

    private function promptHtml(Question $q): string
    {
        $prompt = $q->prompt;

        if ($q->type === QuestionType::GapText) {
            $prompt = str_replace('___', '<span class="gap"></span>', $prompt);
        }

        return (string) Markdown::inline($prompt);
    }

    private function hint(Question $q): string
    {
        return match ($q->type) {
            QuestionType::SingleChoice => 'Kreuze die richtige Antwort an.',
            QuestionType::MultipleChoice => 'Kreuze alle richtigen Antworten an.',
            QuestionType::TrueFalse => 'Kreuze an: wahr oder falsch.',
            QuestionType::Numeric => 'Rechne und trage das Ergebnis ein.',
            QuestionType::GapText => 'Fülle die Lücken aus.',
        };
    }

    private function solutionText(Question $q): string
    {
        $answer = $q->answer;

        return match ($q->type) {
            QuestionType::SingleChoice => (string) ($q->options[$answer['index']] ?? ''),
            QuestionType::MultipleChoice => implode(', ', array_map(fn (int $i) => (string) ($q->options[$i] ?? ''), $answer['indexes'] ?? [])),
            QuestionType::TrueFalse => ($answer['value'] ?? false) ? 'wahr' : 'falsch',
            QuestionType::Numeric => $this->formatNumber((string) ($answer['value'] ?? implode(' oder ', $answer['values'] ?? []))).($q->options['unit'] ?? null ? ' '.$q->options['unit'] : ''),
            QuestionType::GapText => implode(' · ', array_map(fn (array $gap) => (string) $gap[0], $answer['gaps'] ?? [])),
        };
    }

    /**
     * "-1/2" → "−1/2", "0.75" → "0,75" – typeset the way the lesson texts do.
     */
    private function formatNumber(string $value): string
    {
        return str_replace(['.', '-'], [',', '−'], $value);
    }
}
