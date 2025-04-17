<?php

use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('events', EventController::class);
Route::apiResource('events.attendees', AttendeeController::class)->scoped(['attendee','event']); //no entiendo esta linea --> 'events.attendees' tiene que ver con que los attendees tengan adelante "event" en la ruta del CRUD, se ve con php artisan r:l --> 'scoped(['attendee','event'])' tiene que ver con route model binding
