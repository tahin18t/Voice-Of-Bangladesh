<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoleController;

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    // Public feedback submission (for citizens)
    Route::post('feedbacks', [FeedbackController::class, 'store']);
    Route::get('feedbacks/track/{tracking_id}', [FeedbackController::class, 'track']);

    // Protect API routes with Sanctum
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('feedbacks', [FeedbackController::class, 'index']);
        Route::get('feedbacks/{id}', [FeedbackController::class, 'show']);
        Route::put('feedbacks/{id}', [FeedbackController::class, 'update']);
        Route::post('feedbacks/{id}/assign', [FeedbackController::class, 'assign']);
        Route::post('feedbacks/{id}/status', [FeedbackController::class, 'updateStatus']);

        // Admin routes (require admin role)
        Route::prefix('admin')->middleware('role:admin')->group(function () {
            Route::get('users', [UserController::class, 'index']);
            Route::post('users', [UserController::class, 'store']);
            Route::get('users/{id}', [UserController::class, 'show']);
            Route::put('users/{id}', [UserController::class, 'update']);
            Route::delete('users/{id}', [UserController::class, 'destroy']);

            Route::get('roles', [RoleController::class, 'index']);
            Route::post('roles', [RoleController::class, 'store']);
            Route::get('roles/{id}', [RoleController::class, 'show']);
            Route::put('roles/{id}', [RoleController::class, 'update']);
            Route::delete('roles/{id}', [RoleController::class, 'destroy']);
        });
    });
});
