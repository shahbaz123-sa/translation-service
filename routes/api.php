<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TranslationController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/translations', [TranslationController::class, 'store']);
    Route::get('/translations/{id}', [TranslationController::class, 'show']);
    Route::put('/translations/{id}', [TranslationController::class, 'update']);
    Route::get('/search', [TranslationController::class, 'search']);
    Route::get('/translations', [TranslationController::class, 'index']);
});

Route::post('login', [AuthController::class, 'login']);
