<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// 
// // use Illuminate\Support\Facades\Route;

// Route::apiResource('posts', PostController::class);