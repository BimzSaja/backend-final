<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PelangganDataController;
use App\Http\Controllers\PenyewaanController;
use App\Http\Controllers\PenyewaanDetailController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);

Route::apiResource('/admin', AdminController::class);
Route::apiResource('/pelanggan', PelangganController::class);
Route::apiResource('/pelangganData', PelangganDataController::class);
Route::apiResource('/kategori', KategoriController::class);
Route::apiResource('/alat', AlatController::class);
Route::apiResource('/penyewaan', PenyewaanController::class);
Route::apiResource('/penyewaanDetail', PenyewaanDetailController::class);
