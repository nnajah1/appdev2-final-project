<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;

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
    $user = $request->user()->load('posts', 'comments', 'likes');
    return response()->json($user);
});


Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/users', UserController::class);
    Route::apiResource('/posts', PostController::class);
    Route::apiResource('/comments', CommentController::class);
    Route::apiResource('/likes', LikeController::class);
});