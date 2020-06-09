<?php

use App\Http\Controllers\Bar\EventsController;
use Illuminate\Support\Facades\Route;

Route::get('events', [EventsController::class, 'index'])->name('bar.events.index');
Route::get('events/{event}', [EventsController::class, 'show'])->name('bar.events.show');
