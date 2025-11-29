<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LocalizationController;

// Route::get('/management/data', function () {
//     return response()->json(['message' => 'Admin atau Staff boleh masuk']);
// })->middleware(['auth:sanctum', 'role:admin|staff']);

Route::get('/translations', [LocalizationController::class, 'getTranslations']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/register',[UserController::class,'register']);

Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/me', [UserController::class, 'me'])->middleware('auth:sanctum');
Route::get('/admin', function () {
    return response()->json(['message' => 'Halo Admin']);
})->middleware(['auth:sanctum', 'role:admin']);

Route::get('/staff', function () {
    return response()->json(['message' => 'Halo Staff']);
})->middleware(['auth:sanctum', 'role:staff']);

Route::get('/customer', function () {
    return response()->json(['message' => 'Halo Staff']);
})->middleware(['auth:sanctum', 'role:customer']);

