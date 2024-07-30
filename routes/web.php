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

    // Rute untuk validasi dan penolakan SKTM
    Route::post('sktms/{id}/validate', [SKTMController::class, 'validateSKTM'])->name('sktm.validate');
    Route::post('sktms/{id}/reject', [SKTMController::class, 'rejectSKTM'])->name('sktm.reject');

    // Rute untuk mengunduh SKTM
    Route::get('sktms/{id}/download', [SKTMController::class, 'downloadSKTM'])->name('sktms.download');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
