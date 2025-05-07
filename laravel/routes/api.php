<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('admin/users', UserController::class);
    });

    Route::middleware('role:manager')->group(function () {
        Route::get('/manager/dashboard', fn() => response()->json(['message' => 'Manager access']));
    });

    Route::middleware('role:client')->group(function () {
        Route::get('/client/dashboard', fn() => response()->json(['message' => 'Client access']));
    });
});
