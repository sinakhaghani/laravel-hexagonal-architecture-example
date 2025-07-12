<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/users', [\App\Http\Controllers\Api\UserController::class, 'store']);
Route::get('/users/{id}', [\App\Http\Controllers\Api\UserController::class, 'show']);
