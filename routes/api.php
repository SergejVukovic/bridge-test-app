<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public routes

// Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// Post routes
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{post_id}', [PostController::class, 'show']);
// Comments routes
Route::get('/posts/{post_id}/comments', [CommentController::class, 'index']);
Route::get('/posts/{post_id}/comments/{comment_id}', [CommentController::class, 'show']);

// Protected routes
Route::group(['middleware' => 'auth:sanctum'], function () {
    // User routes
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users', [UserController::class, 'update']);
    Route::delete('/users', [UserController::class, 'destroy']);
    // Post routes
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{post_id}', [PostController::class, 'update']);
    Route::delete('/posts/{post_id}', [PostController::class, 'destroy']);
    // Comments routes
    Route::post('/posts/{post_id}/comments', [CommentController::class, 'store']);
    Route::put('/posts/{post_id}/comments/{comment_id}', [CommentController::class, 'update']);
    Route::delete('/posts/{post_id}/comments/{comment_id}', [CommentController::class, 'destroy']);
});
