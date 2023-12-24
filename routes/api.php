<?php

use App\Http\Controllers\BlogpostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupJoinRequestController;
use App\Http\Controllers\LikeController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/like', [LikeController::class, 'like']);
    Route::post('/dislike', [LikeController::class, 'dislike']);

    Route::apiResources([
        'tag' => TagController::class,
        'category' => CategoryController::class,
        'blogpost' => BlogpostController::class,
    ]);

    Route::apiResource('blogpost.comments', CommentController::class)->shallow();

    Route::prefix('blogpost')->group(function () {
        Route::get('/{blogpost}/author', [BlogpostController::class, 'getAuthor']);
        Route::get('/{blogpost}/tags', [BlogpostController::class, 'getTags']);
        Route::get('/{blogpost}/category', [BlogpostController::class, 'getCategory']);
        Route::get('/{blogpost}/likes', [BlogpostController::class, 'getLikes']);
        Route::get('/{blogpost}/dislikes', [BlogpostController::class, 'getDislikes']);
    });

    Route::prefix('comment')->group(function () {
        Route::get('/{comment}/likes', [CommentController::class, 'getLikes']);
        Route::get('/{comment}/dislikes', [CommentController::class, 'getDislikes']);
    });

    Route::prefix('tags')->group(function () {
        Route::get('/{tag}/blogpost', [TagController::class, 'getBlogposts']);
    });

    Route::prefix('group-requests')->group(function () {
        Route::get('/', [GroupJoinRequestController::class, 'index']);
        Route::post('/', [GroupJoinRequestController::class, 'store']);
        Route::get('/{join_request}', [GroupJoinRequestController::class, 'show']);
        Route::delete('/{join_request}', [GroupJoinRequestController::class, 'destroy']);
        Route::post('/{join_request}', [GroupJoinRequestController::class, 'update']);
    });

    Route::prefix('groups')->group(function () {
        Route::get('/', [GroupController::class, 'index']);
        Route::post('/', [GroupController::class, 'store']);
        Route::delete('/{group}', [GroupController::class, 'destroy']);
    });
});

