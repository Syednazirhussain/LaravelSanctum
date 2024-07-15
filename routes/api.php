<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\MenuItemController;
use App\Http\Controllers\Api\MenuItemCategoryController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', [AuthController::class, 'currentUser']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware('admin')->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::get('menu-item-categories', [MenuItemCategoryController::class, 'index']);
        Route::get('menu-item-categories/{menu_item_category}', [MenuItemCategoryController::class, 'show']);
        Route::post('menu-item-categories', [MenuItemCategoryController::class, 'store']);
        Route::put('menu-item-categories/{menu_item_category}', [MenuItemCategoryController::class, 'update']);
        Route::delete('menu-item-categories/{menu_item_category}', [MenuItemCategoryController::class, 'destroy']);

    });

    Route::get('menu-items', [MenuItemController::class, 'index']);
    Route::get('menu-items/{menu_item}', [MenuItemController::class, 'show']);

    Route::middleware('role:admin,chef')->group(function () {
        Route::post('menu-items', [MenuItemController::class, 'store']);
        Route::put('menu-items/{menu_item}', [MenuItemController::class, 'update']);
        Route::delete('menu-items/{menu_item}', [MenuItemController::class, 'destroy']);
    });
});
