<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\MasyarakatDashboardController;
use App\Http\Controllers\MasyarakatPengajuanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\PersyaratanController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\LaporanController;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::get('/register', [LoginController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [LoginController::class, 'register'])->name('register.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Masyarakat Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::prefix('masyarakat')->name('masyarakat.')->group(function () {
        Route::get('/dashboard', [MasyarakatDashboardController::class, 'index'])->name('dashboard');
        
        // Pengajuan Routes
        Route::prefix('pengajuan')->name('pengajuan.')->group(function () {
            Route::get('/', [MasyarakatPengajuanController::class, 'index'])->name('index');
            Route::get('/create', [MasyarakatPengajuanController::class, 'create'])->name('create');
            Route::post('/', [MasyarakatPengajuanController::class, 'store'])->name('store');
            Route::get('/{pengajuan}', [MasyarakatPengajuanController::class, 'show'])->name('show');
            Route::get('/dokumen/{dokumen}/download', [MasyarakatPengajuanController::class, 'downloadDokumen'])->name('download-dokumen');
            Route::get('/get-persyaratan/{layananId}', [MasyarakatPengajuanController::class, 'getPersyaratanByLayanan'])->name('get-persyaratan');
        });
    });
});

// Admin Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // User Management Routes
    Route::prefix('admin/users')->name('admin.users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    // Penduduk Management Routes
    Route::prefix('admin/penduduks')->name('admin.penduduks.')->group(function () {
        Route::get('/', [PendudukController::class, 'index'])->name('index');
        Route::post('/', [PendudukController::class, 'store'])->name('store');
        Route::get('/create', [PendudukController::class, 'create'])->name('create');
        Route::get('/{id}/edit', [PendudukController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PendudukController::class, 'update'])->name('update');
        Route::delete('/{id}', [PendudukController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/create-user', [PendudukController::class, 'createUser'])->name('createUser');
        Route::post('/{id}/reset-password', [PendudukController::class, 'resetPassword'])->name('resetPassword');
    });

    // Layanan Management Routes
    Route::prefix('admin/layanans')->name('admin.layanans.')->group(function () {
        Route::get('/', [LayananController::class, 'index'])->name('index');
        Route::post('/', [LayananController::class, 'store'])->name('store');
        Route::get('/create', [LayananController::class, 'create'])->name('create');
        Route::get('/{layanan}/edit', [LayananController::class, 'edit'])->name('edit');
        Route::put('/{layanan}', [LayananController::class, 'update'])->name('update');
        Route::delete('/{layanan}', [LayananController::class, 'destroy'])->name('destroy');
        Route::post('/{layanan}/toggle-status', [LayananController::class, 'toggleStatus'])->name('toggle-status');
    });

    // Persyaratan Management Routes
    Route::prefix('admin/persyaratans')->name('admin.persyaratans.')->group(function () {
        Route::get('/{layanan}', [PersyaratanController::class, 'index'])->name('index');
        Route::get('/{layanan}/create', [PersyaratanController::class, 'create'])->name('create');
        Route::post('/{layanan}', [PersyaratanController::class, 'store'])->name('store');
        Route::get('/{layanan}/{persyaratan}/edit', [PersyaratanController::class, 'edit'])->name('edit');
        Route::put('/{layanan}/{persyaratan}', [PersyaratanController::class, 'update'])->name('update');
        Route::delete('/{layanan}/{persyaratan}', [PersyaratanController::class, 'destroy'])->name('destroy');
        Route::post('/{layanan}/reorder', [PersyaratanController::class, 'reorder'])->name('reorder');
    });

    // Pengajuan Management Routes
    Route::prefix('admin/pengajuans')->name('admin.pengajuans.')->group(function () {
        Route::get('/', [PengajuanController::class, 'index'])->name('index');
        Route::post('/', [PengajuanController::class, 'store'])->name('store');
        Route::get('/create', [PengajuanController::class, 'create'])->name('create');
        Route::get('/get-persyaratan/{layananId}', [PengajuanController::class, 'getPersyaratanByLayanan'])->name('getPersyaratan');
        Route::get('/{pengajuan}', [PengajuanController::class, 'show'])->name('show');
        Route::get('/{pengajuan}/edit', [PengajuanController::class, 'edit'])->name('edit');
        Route::put('/{pengajuan}', [PengajuanController::class, 'update'])->name('update');
        Route::delete('/{pengajuan}', [PengajuanController::class, 'destroy'])->name('destroy');
        Route::post('/{pengajuan}/update-status', [PengajuanController::class, 'updateStatus'])->name('updateStatus');
        Route::get('/dokumen/{dokumen}/download', [PengajuanController::class, 'downloadDokumen'])->name('downloadDokumen');
    });

    // Surat Management Routes
    Route::prefix('admin/surats')->name('admin.surats.')->group(function () {
        Route::get('/', [SuratController::class, 'index'])->name('index');
        Route::post('/', [SuratController::class, 'store'])->name('store');
        Route::get('/create', [SuratController::class, 'create'])->name('create');
        Route::get('/{surat}', [SuratController::class, 'show'])->name('show');
        Route::get('/{surat}/edit', [SuratController::class, 'edit'])->name('edit');
        Route::put('/{surat}', [SuratController::class, 'update'])->name('update');
        Route::delete('/{surat}', [SuratController::class, 'destroy'])->name('destroy');
        Route::get('/{surat}/download', [SuratController::class, 'download'])->name('download');
    });

    // Profil Desa Routes
    Route::prefix('admin/profil')->name('admin.profil.')->group(function () {
        Route::get('/edit', [ProfilController::class, 'edit'])->name('edit');
        Route::put('/', [ProfilController::class, 'update'])->name('update');
    });

    // Laporan Routes
    Route::prefix('admin/laporan')->name('admin.laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/cetak/user', [LaporanController::class, 'cetakUser'])->name('cetak.user');
        Route::get('/cetak/pengajuan', [LaporanController::class, 'cetakPengajuan'])->name('cetak.pengajuan');
        Route::get('/cetak/surat', [LaporanController::class, 'cetakSurat'])->name('cetak.surat');
    });
});
