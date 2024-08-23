<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SKTMController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;

// Definisikan middleware role secara manual
Route::aliasMiddleware('role', RoleMiddleware::class);
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Group untuk role 'admin' dengan akses penuh
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
    // Tambahkan route lain khusus untuk admin jika diperlukan
});

// Group untuk role 'rt'
Route::middleware(['auth', 'role:rt'])->group(function () {
    Route::post('sktms/{id}/validate', [SKTMController::class, 'validateSKTM'])->name('sktm.validate');
    Route::post('sktms/{id}/reject', [SKTMController::class, 'rejectSKTM'])->name('sktm.reject');
});

// Group untuk role 'rw'
Route::middleware(['auth', 'role:rw'])->group(function () {
    // Rute khusus untuk 'rw'
});

// Group untuk role 'warga'
Route::middleware(['auth', 'role:warga'])->group(function () {
    Route::get('/history', [UserController::class, 'history'])->name('users.riwayat');
});

// Group untuk role 'kelurahan'
Route::middleware(['auth', 'role:kelurahan'])->group(function () {
    Route::post('sktms/{id}/final', [SKTMController::class, 'finalSKTM'])->name('sktm.final');
    Route::post('sktms/{id}/reject-final', [SKTMController::class, 'rejectFinalSKTM'])->name('sktm.rejectFinal');
    // Rute khusus untuk 'kelurahan'
});

// Route untuk semua yang sudah terautentikasi
Route::middleware(['auth'])->group(function () {
    Route::resource('sktms', SKTMController::class);
    Route::get('/sktms/view-pdf/{filename}', [SKTMController::class, 'viewPDF'])->name('sktm.viewPDF');
    Route::get('sktms/{id}/download', [SKTMController::class, 'downloadSKTM'])->name('sktms.download');
    Route::get('sktms/{id}/download-product', [SKTMController::class, 'downloadProduct'])->name('sktms.product');
    Route::get('/report_data_sktm_all', [SKTMController::class, 'reportAllData'])->name('sktms.all');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
