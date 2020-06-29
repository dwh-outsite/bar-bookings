<?php

use App\Http\Middleware\DinnerAuthentication as DinnerAuthenticationAlias;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DinnerController;

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
