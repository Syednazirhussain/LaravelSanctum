<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PhoneController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\MenuItemController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\NotificationController;
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
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::put('/forgot-password-reset', [AuthController::class, 'resetPasswordWithToken'])->name('password.update');

Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/email/resend', [AuthController::class, 'resendVerificationEmail'])
        ->middleware(['throttle:6,1'])
        ->name('verification.send');

    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::middleware('admin')->group(function () {
        Route::post('add-user', [AdminController::class, 'addUser']);
        Route::post('/send-notification', [AdminController::class, 'sendNotification']);
    });

    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::put('/notifications/{id}/read', [NotificationController::class, 'read']);
    Route::put('/notifications/read-all', [NotificationController::class, 'readAll']);

    Route::get('/user/send-email', [UserController::class, 'sendEmail'])->middleware('admin');
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/profile', [UserController::class, 'currentUser']);
    Route::put('/user/profile', [UserController::class, 'updateProfile']);
    Route::put('/user/password', [UserController::class, 'resetPassword']);
    Route::post('/user/device-token', [UserController::class, 'addDeviceToken']);
    Route::delete('/user/device-token', [UserController::class, 'removeDeviceToken']);

    Route::get('phones', [PhoneController::class, 'index']);
    Route::post('phones', [PhoneController::class, 'store']);
    Route::put('phones/{phone}', [PhoneController::class, 'update']);
    Route::delete('phones/{phone}', [PhoneController::class, 'destroy']);
    Route::patch('phones/{phone}/mark-as-active', [PhoneController::class, 'markAsActive']);

    Route::get('addresses', [AddressController::class, 'index']);
    Route::post('addresses', [AddressController::class, 'store']);
    Route::put('addresses/{address}', [AddressController::class, 'update']);
    Route::delete('addresses/{address}', [AddressController::class, 'destroy']);
    Route::patch('addresses/{address}/mark-as-active', [AddressController::class, 'markAsActive']);

    Route::middleware('admin')->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);
    });

    Route::middleware('admin')->group(function () {
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

    Route::middleware(['order'])->group(function () {
        // Route::post('/orders', [OrderController::class, 'create'])->middleware("role:waiter,customer");
        Route::post('/orders', [OrderController::class, 'create'])->middleware("abilities:view_menu");
    });
    
});
