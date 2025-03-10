<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::middleware('auth:api')->post('auth/validate-token', [AuthController::class, 'validateToken']);

Route::prefix('/users')->middleware('auth:api')->group(function () {
    Route::get('/{id}', [UserController::class, 'getUserById']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'delete']);
    Route::get('/{id}/image', [UserController::class, 'getImage']);
});

//handles not found routes
Route::fallback(function (Request $request) {
    return response()->json([
        'request' => $request,
        'hi'=>"Hello",
        'message' => 'Route not found'
    ], 404);
});
