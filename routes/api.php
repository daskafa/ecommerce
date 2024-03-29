<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('authenticate', [AuthController::class, 'authenticate']);

Route::middleware('auth:sanctum')->group(function (){});
