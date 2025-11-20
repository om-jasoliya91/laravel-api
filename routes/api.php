<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('throttle:10,1')->group(function () {
    Route::apiResource('posts', PostController::class);
});

use App\Http\Controllers\Api\UserController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class)->middleware('auth:sanctum');
    Route::post('/logout', [UserController::class, 'logout']);
});
Route::post('/login', [UserController::class, 'login']);
