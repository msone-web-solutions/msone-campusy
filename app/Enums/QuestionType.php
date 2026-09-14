<?php

namespace App\Enums;

enum QuestionType: string
{
    case SingleChoice = 'single_choice';
    case MultipleChoice = 'multiple_choice';
    case TrueFalse = 'true_false';
    case Numeric = 'numeric';
    case GapText = 'gap_text';

    public function label(): string
    {
        return match ($this) {
            self::SingleChoice => 'Eine Antwort auswählen',
            self::MultipleChoice => 'Alle richtigen Antworten auswählen',
            self::TrueFalse => 'Wahr oder falsch?',
            self::Numeric => 'Ergebnis eintragen',
            self::GapText => 'Lücken ausfüllen',
        };
    }
}
