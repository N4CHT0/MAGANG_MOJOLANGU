<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PembangunanController;
use App\Http\Controllers\SKTMController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;

// Definisikan middleware role secara manual
Route::aliasMiddleware('role', RoleMiddleware::class);
Route::get('/', function () {
    return view('auth.login');
});
Route::post('/update-data-warga', [UserController::class, 'update_data_warga'])->name('update_data_warga');

Auth::routes();

// Group untuk role 'admin' dengan akses penuh
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::get('export_data_excel', [UserController::class, 'export'])->name('users.export');
    Route::get('/users/export/all', [UserController::class, 'reportAllData'])->name('users.export.all');

    // Tambahkan route lain khusus untuk admin jika diperlukan
});

// Group untuk role 'rt'
Route::middleware(['auth', 'role:rt'])->group(function () {

    // Layanan SKTM
    Route::post('sktms/{id}/validate', [SKTMController::class, 'validateSKTM'])->name('sktm.validate');
    Route::post('sktms/{id}/reject', [SKTMController::class, 'rejectSKTM'])->name('sktm.reject');

    // Pembangunan
    Route::get('/pembangunan/create', [PembangunanController::class, 'create'])->name('pembangunan.create');
    Route::post('/pembangunan/', [PembangunanController::class, 'store'])->name('pembangunan.store');
    Route::get('/riwayat-pengajuan-rt', [PembangunanController::class, 'riwayatPengajuanRt'])->name('riwayat.pengajuan.rt');
    Route::get('/riwayat/{id}', [PembangunanController::class, 'detailPengajuan'])->name('riwayat.detail');
});

// Group untuk role 'rw'
Route::middleware(['auth', 'role:rw'])->group(function () {
    // Rute khusus untuk 'rw'
    Route::get('/verifikasi', [PembangunanController::class, 'verifikasi'])->name('pembangunan.verifikasi');
    Route::post('/approve', [PembangunanController::class, 'approve'])->name('pembangunan.approve');
    Route::post('/reject', [PembangunanController::class, 'reject'])->name('pembangunan.reject');
    Route::get('/riwayat-pengajuan-rw', [PembangunanController::class, 'riwayatPengajuanRw'])->name('riwayat.pengajuan.rw');
    Route::get('/riwayat/{id}', [PembangunanController::class, 'detailPengajuan'])->name('riwayat.detail');
});

// Group untuk role 'warga'
Route::middleware(['auth', 'role:warga'])->group(function () {
    Route::get('/history', [UserController::class, 'history'])->name('users.riwayat');
});

// Group untuk role 'lpmd'
Route::middleware(['auth', 'role:lpmd'])->group(function () {
    Route::get('/validate-process', [KriteriaController::class, 'validateProcess'])->name('validate.process');
    Route::post('/handle-validation', [KriteriaController::class, 'handleValidation'])->name('handle.validation');

    Route::get('/validasi', [PembangunanController::class, 'validasi'])->name('pembangunan.validasi');
    Route::post('/approveValidasi', [PembangunanController::class, 'approveValidasi'])->name('pembangunan.approveValidasi');
    Route::post('/rejectValidasi', [PembangunanController::class, 'rejectValidasi'])->name('pembangunan.rejectValidasi');
    Route::get('/riwayat/{id}', [PembangunanController::class, 'detailPengajuan'])->name('riwayat.detail');
    // Menampilkan semua kriteria
    Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');
    // Menyimpan kriteria baru
    Route::post('/kriteria', [KriteriaController::class, 'store'])->name('kriteria.store');
    // Menampilkan form untuk mengedit kriteria (opsional, jika ingin menggunakan method get)
    Route::get('/kriteria/{id}/edit', [KriteriaController::class, 'edit'])->name('kriteria.edit');
    // Memperbarui kriteria yang ada
    Route::put('/kriteria/{id}', [KriteriaController::class, 'update'])->name('kriteria.update');
    // Menghapus kriteria
    Route::delete('kriteria/{id}', [KriteriaController::class, 'destroy'])->name('kriteria.destroy');
    Route::get('/proses-data', [PembangunanController::class, 'proses'])->name('proses.data');

    // IMPLEMENTASI METODE
    Route::get('/alternatif', [PembangunanController::class, 'dataAlternatif'])->name('kriteria.alternatif');
    Route::get('/perbandingan-kriteria', [KriteriaController::class, 'compareCriteria'])->name('kriteria.perbandingan');
    Route::post('/compare/submit', [KriteriaController::class, 'storeComparison'])->name('compare.submit');
    Route::get('/perbandingan-nilai', [KriteriaController::class, 'compareValue'])->name('nilai.perbandingan');
    Route::post('/compare-nilai-submit', [KriteriaController::class, 'storeComparisonValue'])->name('nilai.submit');
    Route::get('/hasil-prioritas', [KriteriaController::class, 'calculateFinalScore'])->name('hasil.prioritas');
    Route::post('/save-ranking-pdf', [KriteriaController::class, 'saveRankingPdf'])->name('save-ranking-pdf');
    // Route untuk menampilkan data perankingan
    Route::get('/perbandingan', [KriteriaController::class, 'showRankingData'])->name('perbandingan.index');
    Route::delete('/perbandingan/{id}', [KriteriaController::class, 'hapusPerbandingan'])->name('perbandingan.destroy');


    // Route untuk mengunduh PDF
    Route::get('/perbandingan/{id}/download', [KriteriaController::class, 'downloadPdf'])->name('download.pdf');
    Route::get('/pembangunan/{id}/detail', [KriteriaController::class, 'showDetail'])->name('pembangunan.detail');
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
