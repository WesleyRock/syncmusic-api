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
        Route::put('/posts/{id}', [PostController::class, 'update']);
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

    Route::get('/musics', function () {
    return response()->json([
        [
            'id' => 1,
            'nameMusic' => 'Pecado Capital',
            'nameArtist' => 'Xamã',
            'image' => 'https://i.pinimg.com/736x/e0/30/87/e0308750fc6286a12dea2bbd167981d6.jpg',
            'colorCard' => '#952175',
        ],
        [
            'id' => 2,
            'nameMusic' => 'Marília Mendonça - Ao vivo',
            'nameArtist' => 'Marília Mendonça',
            'image' => 'https://i.pinimg.com/736x/7a/e6/3c/7ae63c03616acee1d01e52ea9b48c906.jpg',
            'colorCard' => '#342e7b',
        ],
        [
            'id' => 3,
            'nameMusic' => 'Clube da Esquina',
            'nameArtist' => 'Lô Borges e Milton Nascimento',
            'image' => 'https://i.pinimg.com/736x/c5/12/8e/c5128e11e158a39bd38fa0f5cfb65661.jpg',
            'colorCard' => '#342e7b',
        ],
        [
            'id' => 4,
            'nameMusic' => 'Short n Sweet',
            'nameArtist' => 'Sabrina Carpenter',
            'image' => 'https://i.pinimg.com/736x/ab/43/04/ab43048b671d7de6590d91627422d69f.jpg',
            'colorCard' => '#234c9e',
        ],
        [
            'id' => 5,
            'nameMusic' => 'The Laws of Scourge',
            'nameArtist' => 'Sarcófago',
            'image' => 'https://i.pinimg.com/736x/3d/80/b9/3d80b941218f367b53dbdc1d4b621111.jpg',
            'colorCard' => '#082a97',
        ],
    ]);
});

});
