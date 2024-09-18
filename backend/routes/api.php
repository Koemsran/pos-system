<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//======================= Authentication ======================
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::put('/customers/{id}/role', [AuthController::class, 'updateRole']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/me', [AuthController::class, 'index'])->middleware('auth:sanctum');

// ========================= Roles =============================
Route::get('/roles/list', [RoleController::class, 'index']);
Route::post('/role/create', [RoleController::class, 'store']);
Route::delete('/role/delete/{id}', [RoleController::class, 'destroy']);
Route::put('/role/update/{id}', [RoleController::class, 'update']);
Route::put('/roles/{roleId}/add-permissions', [RoleController::class, 'updatePermissions']);

// ========================= Permissions =============================
Route::get('/permissions/list', [PermissionController::class, 'index']);
Route::post('/permission/create', [PermissionController::class, 'store']);
Route::put('/permission/update/{id}', [PermissionController::class, 'update']);
Route::delete('/permission/delete/{id}', [PermissionController::class, 'destroy']);


// ========================= Clients =============================
Route::get('/clients/list', [ClientsController::class, 'index']);
Route::get('/client/{id}', [ClientsController::class,'show']);
Route::post('/client/create', [ClientsController::class, 'store']);
Route::put('/client/update/{id}', [ClientsController::class, 'update']);
Route::delete('/client/delete/{id}', [ClientsController::class, 'destroy']);

// ========================= Users =============================
Route::get('/users/list', [UserController::class, 'index']);
Route::post('/user/create', [UserController::class, 'store']);
Route::get('/user/show/{id}', [UserController::class, 'show']);
Route::post('/user/update/{id}', [UserController::class, 'update']);
Route::delete('/user/delete/{id}', [UserController::class, 'destroy']);
