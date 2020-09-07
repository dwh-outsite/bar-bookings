<?php

use App\Http\Controllers\DinnerController;
use App\Http\Controllers\VisitorController;
use App\Http\Middleware\DinnerAuthentication as DinnerAuthenticationAlias;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', 'https://dwhdelft.nl/book');

Route::get('/dinner', DinnerController::class)->middleware(DinnerAuthenticationAlias::class);

Route::get('/visitor', [VisitorController::class, 'index'])->name('visitor');
Route::get('/visitor/welcome', [VisitorController::class, 'enterCode'])->name('visitor.enter_code');
