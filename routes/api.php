<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['jwt'])->group(function () {
  Route::get('me', [AuthController::class, 'me']);
  Route::post('logout', [AuthController::class, 'logout']);

  Route::apiResource('users', UserController::class);
  Route::get('stats/users', [StatisticsController::class, 'userStats']);
});
