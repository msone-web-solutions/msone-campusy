<?php

use App\Console\Commands\SendBacklogAlerts;
use Illuminate\Support\Facades\Schedule;

// Eltern-Erinnerung bei Rückstand, nach dem Schultag.
Schedule::command(SendBacklogAlerts::class)->dailyAt('17:00');
