<?php

use App\Http\Controllers\EventsController;
use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers')->group(fn () => Auth::routes(['register' => false]));

Route::middleware('auth')->group(function () {
    Route::redirect('/', '/admin/events')->name('home');

    Route::resource('events', EventsController::class);
});
