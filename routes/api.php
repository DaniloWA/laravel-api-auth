<?php

use Illuminate\Support\Facades\Route;
use Danilowa\LaravelApiAuth\Controllers\AuthenticationController;

Route::prefix(config('apiauth.route_prefix'))->group(function () {
    Route::post('/register', [AuthenticationController::class, 'register']);
    Route::post('/login', [AuthenticationController::class, 'login']);
    Route::post('/logout', [AuthenticationController::class, 'logout']);
    Route::get('/user', [AuthenticationController::class, 'currentUser'])->middleware('auth:sanctum');
});
