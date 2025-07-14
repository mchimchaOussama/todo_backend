<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\NotificationController;

Route::get('/user', function (Request $request) {   
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:api')->group(function () {
  Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/tasks', [TaskController::class, 'store']);
     Route::get('/tasks', [TaskController::class, 'index']);
    Route::get('/tasks/{task}', [TaskController::class, 'show']);    
    Route::put('/tasks/{task}', [TaskController::class, 'update']);   
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
});


  