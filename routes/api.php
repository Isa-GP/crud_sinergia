<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
    
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::apiResource('pacientes', UserController::class);
});


