<?php

use App\Http\Controllers\BlogpostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/signup', [UserController::class, 'create']);

Route::prefix('tags')->group(function () {
    Route::get('/', [TagController::class, 'index']);
    Route::post('/store', [TagController::class, 'store']);
    Route::get('/{tag}', [TagController::class, 'show']);
    Route::put('/{tag}', [TagController::class, 'update']);
    Route::delete('/{tag}', [TagController::class, 'destroy']);
});

Route::prefix('category')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::post('/store', [CategoryController::class, 'store']);
    Route::get('/{category}', [CategoryController::class, 'show']);
    Route::put('/{category}', [CategoryController::class, 'update']);
    Route::delete('/{category}', [CategoryController::class, 'destroy']);
});

Route::prefix('blogpost')->group(function () {
    Route::get('/', [BlogpostController::class, 'index']);
    Route::post('/store', [BlogpostController::class, 'store']);
    Route::get('/{blog_post}', [BlogpostController::class, 'show']);
    Route::put('/{blog_post}', [BlogpostController::class, 'update']);
    Route::delete('/{blog_post}', [BlogpostController::class, 'destroy']);
});

Route::prefix('comments')->group(function () {
    Route::get('/{blog_post}/{comment}', [CommentController::class, 'show']);
    Route::post('{blog_post}/store', [CommentController::class, 'store']);
    Route::put('/{blog_post}/{comment}', [CommentController::class, 'update']);
    Route::delete('/{blog_post}/{comment}', [CommentController::class, 'destroy']);
});
