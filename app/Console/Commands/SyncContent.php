<?php

namespace App\Console\Commands;

use App\Content\ContentImporter;
use Illuminate\Console\Command;

class SyncContent extends Command
{
    protected $signature = 'content:sync';

    protected $description = 'Liest die Lerninhalte aus database/content ein und aktualisiert die Datenbank';

    public function handle(): int
    {
        $stats = ContentImporter::default()->import();

        $this->info(sprintf(
            'Importiert: %d Fächer, %d Themenfelder, %d Themen, %d Fragen',
            $stats['subjects'], $stats['areas'], $stats['topics'], $stats['questions'],
        ));

        return self::SUCCESS;
    }
}
