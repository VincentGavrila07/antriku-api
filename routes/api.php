<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ServiceController;
// Route::get('/management/data', function () {
//     return response()->json(['message' => 'Admin atau Staff boleh masuk']);
// })->middleware(['auth:sanctum', 'role:admin|staff']);

Route::get('/translations', [LocalizationController::class, 'getTranslations']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/register',[UserController::class,'register']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/me', [UserController::class, 'me'])->middleware('auth:sanctum');
Route::get('/me/permissions', [UserController::class, 'getPermissions'])->middleware('auth:sanctum');
Route::get('/get-all-services',[ServiceController::class,'getAllServices'])->name('getAllServices');
Route::get('/services/{id}/staff', [ServiceController::class, 'getServiceStaff'])->name('getServiceStaff');
Route::post('/book-service',[ServiceController::class,'createQueue'])->name('createQueue');
Route::get('/queues/active/{userId}', [ServiceController::class, 'getActiveQueue']);
Route::get('/queues/by-service', [ServiceController::class, 'getAllQueueByService']);
Route::get('/queues/history/by-service', [ServiceController::class, 'getHistoryByService']);

Route::get('/my-services', [ServiceController::class, 'getMyService']);
Route::get('/service-history/{roleId}', [ServiceController::class, 'getServiceHistory']);
Route::get('total-serve', [ServiceController::class, 'getTotalServe']);

Route::put('/queues/update-status', [ServiceController::class, 'updateStatusQueue']);


Route::middleware('auth:sanctum')->group(function () {
    Route::put('/profile/update', [UserController::class, 'updateProfile']);
});


Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/get-all-user', [UserController::class, 'getAllUser'])->name('getAllUser');
    Route::get('/total-by-role', [UserController::class, 'getTotalUserByRole'])->name('getTotalUserByRole');
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
    
    //permission punya
    Route::get('get-all-permissions', [PermissionController::class, 'getAllPermissions']);
    Route::get('permissions/{id}', [PermissionController::class, 'getPermissionById']);
    Route::get('permissions/{id}/roles', [PermissionController::class, 'getRolesByPermission']);
    Route::put('permissions/{id}/roles', [PermissionController::class, 'updateRoles']);
    
    //service punya
    Route::get('/get-all-services',[ServiceController::class,'getAllServices'])->name('getAllServices');
    Route::get('/services-detail/{id}', [ServiceController::class, 'getServiceById']);
    Route::put('/update-services/{id}', [ServiceController::class, 'updateService']);
    Route::post('/store-service', [ServiceController::class, 'storeService']);
    Route::delete('/delete-services/{id}', [ServiceController::class, 'deleteService']);
    Route::post('/service/generate-report', [ServiceController::class, 'generateReport']);
    Route::get('/download-report/{fileName}', [ServiceController::class, 'downloadReport']);
    
});


Route::get('/staff', function () {
    return response()->json(['message' => 'Halo Staff']);
})->middleware(['auth:sanctum', 'role:staff']);

Route::get('/customer', function () {
    return response()->json(['message' => 'Halo Staff']);
})->middleware(['auth:sanctum', 'role:customer']);

