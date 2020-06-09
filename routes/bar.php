<?php

use App\Http\Middleware\BarAuthentication;
use App\Http\Controllers\Bar\EventsController;
use Illuminate\Support\Facades\Route;

Route::middleware(BarAuthentication::class)->group(function () {
    Route::redirect('', 'bar/events');
    Route::get('events', [EventsController::class, 'index'])->name('bar.events.index');
    Route::get('events/{event}', [EventsController::class, 'show'])->name('bar.events.show');
});
