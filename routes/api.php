<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PenjualanController;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => ''
], function ($router) {
    Route::get('/pelanggan', [PelangganController::class, 'index']);
    Route::get('/pelanggan/{id}', [PelangganController::class, 'getById']);
    Route::post('/pelanggan', [PelangganController::class, 'submit']);
    Route::delete('/pelanggan/{id}', [PelangganController::class, 'delete']);

    Route::get('/barang', [BarangController::class, 'index']);
    Route::get('/barang/{id}', [BarangController::class, 'getById']);
    Route::post('/barang', [BarangController::class, 'submit']);
    Route::delete('/barang/{id}', [BarangController::class, 'delete']);

    Route::get('/penjualan', [PenjualanController::class, 'index']);
    Route::post('/penjualan', [PenjualanController::class, 'submit']);
    Route::delete('/penjualan/{id}', [PenjualanController::class, 'delete']);
    
});
