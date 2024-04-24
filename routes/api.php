<?php

use App\Http\Controllers\admincontroller;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\KategoriController;
// use App\Http\Controllers\LoginController;
use App\Http\Controllers\Pelanggan_DataController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\Penyewaan_DetailController;
use App\Http\Controllers\PenyewaanController;
use App\Http\Controllers\RegisterController;
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

// Route::post('login', [LoginController::class, 'login']);
Route::post('register', [RegisterController::class, 'register']);
Route::apiResource('/pelanggan', PelangganController::class);

// Middleware untuk autentikasi admin
Route::middleware(['auth:admin-api', 'check.admin.token'])->group(function () {
    Route::apiResource('/alat', AlatController::class);
    Route::apiResource('/pelanggandata', Pelanggan_DataController::class);
    Route::apiResource('/kategori', KategoriController::class);
    Route::apiResource('/penyewaan', PenyewaanController::class);
    Route::apiResource('/penyewaandetail', Penyewaan_DetailController::class);
    Route::apiResource('/admin', AdminController::class);
});
