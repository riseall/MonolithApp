<?php

use App\Http\Controllers\Api\AbsenKeluarController;
use App\Http\Controllers\Api\AbsenMasukController;
use App\Http\Controllers\Api\PegawaiController;
use App\Http\Controllers\Api\MahasiswaController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MagangController;
use App\Http\Controllers\Api\PerusahaanController;
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

Route::apiResource('pegawai', PegawaiController::class);

Route::apiResource('user', UserController::class);
Route::apiResource('mahasiswa', MahasiswaController::class);
Route::apiResource('dosen', DosenController::class);
Route::apiResource('absenMasuk', AbsenMasukController::class);
Route::apiResource('absenKeluar', AbsenKeluarController::class);
Route::apiResource('perusahaan', PerusahaanController::class);
Route::apiResource('magang', MagangController::class);
Route::apiResource('laporan', LaporanController::class);

Route::middleware('auth:api')->get('masukk', [HistoryController::class, 'masuk']);
Route::middleware('auth:api')->get('keluarr', [HistoryController::class, 'keluar']);
