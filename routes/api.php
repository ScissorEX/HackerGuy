<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\VoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('signup', [AuthController::class,'register']);
Route::post('login', [AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('posts',[PostController::class, 'store']);
    Route::patch('posts/{post}',[PostController::class, 'update']);
    Route::delete('posts/{post}',[PostController::class, 'destroy']);
    Route::post('posts/{post}/comments', [CommentController::class, 'store']);
    Route::post('posts/{post}/vote', [VoteController::class, 'votePost']);
    Route::post('comments/{comment}/vote', [VoteController::class, 'voteComment']);
    Route::post('logout', [AuthController::class,'logout']);
});

Route::get('posts', [PostController::class, 'index']);
Route::get('posts/{post}', [PostController::class, 'show']);
Route::get('posts/{post}/comments', [CommentController::class, 'index']);
Route::get('category',[CategoryController::class,'index']);
Route::get('category/{category}',[CategoryController::class,'show']);
Route::get('search', [PostController::class, 'search']);