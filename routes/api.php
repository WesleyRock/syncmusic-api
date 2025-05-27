<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SavedPostController;
use App\Http\Controllers\ProfileController;

RateLimiter::for('api', function (Illuminate\Http\Request $request) {
    return Limit::perMinute(60)->by($request->ip());
});


// Rotas públicas
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

// Rotas protegidas
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
    });

    Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
        return $request->user()->load('posts');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/posts', [PostController::class, 'index']);
        Route::post('/posts', [PostController::class, 'store']);
        Route::get('/posts/{id}', [PostController::class, 'show']);
        Route::delete('/posts/{id}', [PostController::class, 'destroy']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/posts/{post}/like', [LikeController::class, 'like']);
        Route::delete('/posts/{post}/like', [LikeController::class, 'unlike']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/posts/{post}/comments', [CommentController::class, 'index']);
        Route::post('/posts/{post}/comments', [CommentController::class, 'store']);
        Route::delete('/posts/{post}/comments/{comment}', [CommentController::class, 'destroy']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/posts/{post}/save', [SavedPostController::class, 'toggle']);
        Route::get('/saved', [SavedPostController::class, 'index']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [ProfileController::class, 'show']);
        Route::put('/me', [ProfileController::class, 'update']);
    });

});
