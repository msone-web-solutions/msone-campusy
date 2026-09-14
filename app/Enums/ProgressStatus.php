<?php

namespace App\Enums;

enum ProgressStatus: string
{
    case Started = 'started';
    case NotebookDone = 'notebook_done';
    case Passed = 'passed';
    case Mastered = 'mastered';

    public function label(): string
    {
        return match ($this) {
            self::Started => 'Begonnen',
            self::NotebookDone => 'Hefteintrag erledigt',
            self::Passed => 'Test bestanden',
            self::Mastered => 'Gesichert',
        };
    }

    public function rank(): int
    {
        return match ($this) {
            self::Started => 1,
            self::NotebookDone => 2,
            self::Passed => 3,
            self::Mastered => 4,
        };
    }

    public function isPassed(): bool
    {
        return $this->rank() >= self::Passed->rank();
    }
}
