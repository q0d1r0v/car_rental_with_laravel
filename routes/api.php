<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::group([
    'prefix' => 'admin',
    'middleware' => ['jwt.auth']
], function () {
    Route::get('/api/v1/load/users', [UserController::class, 'loadUsers']);
});



Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});
