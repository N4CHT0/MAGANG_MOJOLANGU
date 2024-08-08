<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SKTMController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class);

    // Rute untuk SKTM yang mencakup index, create, store, show, edit, update, destroy
    Route::resource('sktms', SKTMController::class);

    Route::get('/sktms/view-pdf/{filename}', [SKTMController::class, 'viewPDF'])->name('sktm.viewPDF');

    // Route untuk halaman riwayat pengajuan
    Route::get('/history', [UserController::class, 'history'])->name('users.riwayat');

    // Rute untuk validasi dan penolakan SKTM
    Route::post('sktms/{id}/validate', [SKTMController::class, 'validateSKTM'])->name('sktm.validate');
    Route::post('sktms/{id}/final', [SKTMController::class, 'finalSKTM'])->name('sktm.final');
    Route::post('sktms/{id}/reject', [SKTMController::class, 'rejectSKTM'])->name('sktm.reject');

    // Rute untuk mengunduh SKTM
    Route::get('sktms/{id}/download', [SKTMController::class, 'downloadSKTM'])->name('sktms.download');
    Route::get('sktms/{id}/download-product', [SKTMController::class, 'downloadProduct'])->name('sktms.product');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
