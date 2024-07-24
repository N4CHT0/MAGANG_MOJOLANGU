<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::resource('users', UserController::class);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/admin/home', [HomeController::class, 'index'])->middleware('role:admin')->name('admin.home');
Route::get('/warga/home', [HomeController::class, 'index'])->middleware('role:warga')->name('warga.home');
Route::get('/rt/home', [HomeController::class, 'index'])->middleware('role:rt')->name('rt.home');
Route::get('/rw/home', [HomeController::class, 'index'])->middleware('role:rw')->name('rw.home');
Route::get('/kelurahan/home', [HomeController::class, 'index'])->middleware('role:kelurahan')->name('kelurahan.home');
