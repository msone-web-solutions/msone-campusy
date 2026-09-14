<?php

namespace App\Enums;

enum ProgressStatus: string
{
    case Started = 'started';
    case NotebookDone = 'notebook_done';
    case Passed = 'passed';

    public function label(): string
    {
        return match ($this) {
            self::Started => 'Begonnen',
            self::NotebookDone => 'Hefteintrag erledigt',
            self::Passed => 'Test bestanden',
        };
    }

    public function rank(): int
    {
        return match ($this) {
            self::Started => 1,
            self::NotebookDone => 2,
            self::Passed => 3,
        };
    }
}
