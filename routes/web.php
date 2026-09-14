<?php

use App\Http\Controllers\TopicWorksheetController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

// Schüler: Dashboard, Schultag, Fächer, Lektionen, tägliche Übung
Route::middleware(['auth', 'verified', 'role:student'])->group(function () {
    Route::livewire('dashboard', 'pages::dashboard')->name('dashboard');
    Route::livewire('ueben', 'pages::practice')->name('practice');
    Route::livewire('schultag', 'pages::school-day')->name('school-day');

    Route::livewire('lernen', 'pages::learn.index')->name('learn.index');
    Route::livewire('lernen/{subject}', 'pages::learn.subject')->name('learn.subject');
    Route::livewire('lernen/{subject}/{topicArea:slug}/{topic:slug}', 'pages::learn.topic')
        ->scopeBindings()
        ->name('learn.topic');
    Route::get('lernen/{subject}/{topicArea:slug}/{topic:slug}/probearbeit.pdf', TopicWorksheetController::class)
        ->scopeBindings()
        ->name('learn.topic.worksheet');
});

// Eltern: Wochenübersicht der verknüpften Kinder
Route::middleware(['auth', 'verified', 'role:parent'])->group(function () {
    Route::livewire('eltern', 'pages::parent-dashboard')->name('parent.dashboard');
});

require __DIR__.'/settings.php';
