<?php

use App\Http\Controllers\BlogpostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
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
Route::post('/login', [AuthController::class, 'login']);

Route::apiResources([
    'tag' => TagController::class,
    'category' => CategoryController::class,
    'blogpost' => BlogpostController::class,
]);

Route::apiResource('blogpost.comments', CommentController::class)->shallow();



Route::prefix('blogpost')->group(function () {
    Route::get('/{blog_post}/author', [BlogpostController::class, 'getAuthor']);
    Route::get('/{blog_post}/tags', [BlogpostController::class, 'getTags']);
    Route::get('/{blog_post}/category', [BlogpostController::class, 'getCategory']);
});

Route::prefix('tags')->group(function () {
    Route::get('/{tag}/blogpost', [TagController::class, 'getBlogposts']);
});
