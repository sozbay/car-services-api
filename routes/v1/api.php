<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\BalanceController;
use App\Http\Controllers\Api\v1\CarController;
use App\Http\Controllers\Api\v1\OrderController;
use App\Http\Controllers\Api\v1\ServicesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Auth Routes
Route::controller(AuthController::class)->prefix('/auth')->group(function () {
    Route::post('/register', 'register')->name('register')->middleware('json');
    Route::post('/login', 'login')->name('login')->middleware('json');
    Route::post('/logout', 'logout')->name('logout')->middleware('auth:api');
});

// Add Balance Route
Route::post('addBalance', [BalanceController::class, 'addBalance'])->name('add-balance')->middleware(['json', 'auth:api']);

// Get All Services Route
Route::get('getServices', [ServicesController::class, 'getServices'])->name('services')->middleware(['json', 'auth:api']);

// Get All Cars Route
Route::get('getCars', [CarController::class, 'getCars'])->name('getCars')->middleware(['json', 'auth:api']);

// Create Order Route
Route::post('createOrder', [OrderController::class, 'createOrder'])->name('createOrder')->middleware(['json', 'auth:api']);

// Get All Orders Route
Route::get('getOrders', [OrderController::class, 'getOrders'])->name('getOrders')->middleware(['json', 'auth:api']);

