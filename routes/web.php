<?php

use App\Http\Controllers\TopicWorksheetController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('dashboard', 'pages::dashboard')->name('dashboard');

    Route::livewire('lernen', 'pages::learn.index')->name('learn.index');
    Route::livewire('lernen/{subject}', 'pages::learn.subject')->name('learn.subject');
    Route::livewire('lernen/{subject}/{topicArea:slug}/{topic:slug}', 'pages::learn.topic')
        ->scopeBindings()
        ->name('learn.topic');
    Route::get('lernen/{subject}/{topicArea:slug}/{topic:slug}/probearbeit.pdf', TopicWorksheetController::class)
        ->scopeBindings()
        ->name('learn.topic.worksheet');
});

require __DIR__.'/settings.php';
