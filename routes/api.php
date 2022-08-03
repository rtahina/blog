<?php

use App\Http\Controllers\Api\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'auth'
    ], 
    
    function($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);    
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/profile', [AuthController::class, 'profile']);
});

// posts
Route::apiResource('posts', PostController::class)->only(['index', 'show']);

// Comments
Route::get('/posts/{id}/comments', [PostController::class, 'postComments']);
Route::get('/comments', [CommentController::class, 'index']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::apiResource('posts', PostController::class)->only(['store', 'update', 'destroy']);
    Route::post('/posts/{id}/comments', [CommentController::class, 'store']);
    Route::put('/posts/{postId}/comments/{commentId}', [CommentController::class, 'update']);
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);
});