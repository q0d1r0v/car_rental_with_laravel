<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::prefix('/')->group(function () {
    Route::post('/auth/register', [AuthController::class, 'register']);
});
