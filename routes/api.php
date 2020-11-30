<?php

use App\Http\Controllers\{
    MeetupsController, 
    CustomersController, 
    TicketsController
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->apiResource('customers', CustomersController::class);

Route::middleware('auth:sanctum')->apiResource('meetups', MeetupsController::class);
Route::middleware('auth:sanctum')->get('meetups/{meetup}/availability', [MeetupsController::class, 'availability']);

Route::middleware('auth:sanctum')->post('tickets/', [TicketsController::class, 'store']);
Route::middleware('auth:sanctum')->post('tickets/{ticket}/confirm', [TicketsController::class, 'confirm']);
