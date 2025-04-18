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

/* 
These routes set up RESTful API endpoints where events has standard CRUD operations, while events.attendees creates nested routes for managing attendees within specific events. 
The scoped() method adds automatic validation to ensure attendees belong to their parent event, preventing unauthorized access. 
For example, /events/1/attendees/3 will only work if attendee 3 is actually associated with event 1, otherwise returning a 404 error. 
This enforces data integrity directly in the routing layer.
note: php artisan route:list --> command to check the route list
*/
Route::apiResource('events', EventController::class);//
Route::apiResource('events.attendees', AttendeeController::class)->scoped(['attendee','event']); //
