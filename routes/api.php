<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\RoleController;

// Route::get('/management/data', function () {
//     return response()->json(['message' => 'Admin atau Staff boleh masuk']);
// })->middleware(['auth:sanctum', 'role:admin|staff']);

Route::get('/translations', [LocalizationController::class, 'getTranslations']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/register',[UserController::class,'register']);

Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/me', [UserController::class, 'me'])->middleware('auth:sanctum');
Route::get('/me/permissions', [UserController::class, 'getPermissions'])->middleware('auth:sanctum');



Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/get-all-user', [UserController::class, 'getAllUser'])->name('getAllUser');
    Route::post('/store-user',[UserController::class,'storeUser'])->name('storeUser');
    Route::get('/user-detail/{id}',[userController::class,'getUserById'])->name('getUserById');
    Route::delete('/delete-user/{id}', [UserController::class, 'deleteUser'])->name('deleteUser');
    Route::put('/update-user/{id}',[UserController::class,'updateUser'])->name('updateUser');
    
    //role punya
    Route::get('/get-all-role',[RoleController::class,'getAllRole'])->name('getAllRole');
    Route::get('/role-detail/{id}',[RoleController::class,'getRoleById'])->name('getRoleById');
    Route::post('/store-role',[RoleController::class,'storeRole'])->name('storeRole');
    Route::delete('/delete-role/{id}', [RoleController::class, 'deleteRole'])->name('deleteRole');
    Route::put('/update-role/{id}',[RoleController::class,'updateRole'])->name('updateRole');
});


Route::get('/staff', function () {
    return response()->json(['message' => 'Halo Staff']);
})->middleware(['auth:sanctum', 'role:staff']);

Route::get('/customer', function () {
    return response()->json(['message' => 'Halo Staff']);
})->middleware(['auth:sanctum', 'role:customer']);

