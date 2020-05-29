<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers')->group(fn () => Auth::routes(['register' => false]));

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

