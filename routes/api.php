<?php

use App\Http\Controllers\Api\CreateBookingController;
use App\Http\Controllers\Api\RetrieveEventsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/events', RetrieveEventsController::class);
Route::post('/bookings', CreateBookingController::class);

