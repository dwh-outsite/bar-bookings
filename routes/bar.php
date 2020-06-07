<?php

use App\Http\Controllers\Bar\EventsController;
use Illuminate\Support\Facades\Route;

Route::get('events', [EventsController::class, 'index']);
Route::get('events/{event}', [EventsController::class, 'show']);
