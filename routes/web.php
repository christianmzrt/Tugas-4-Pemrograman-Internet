<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\ProfileController;

// Root URL redirect ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard (harus login)
Route::get('/dashboard', function () {
    return redirect()->route('mahasiswa.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes (harus login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================
// ROUTE UNTUK USER BIASA (hanya bisa LIHAT)
// ============================================
Route::middleware(['auth'])->group(function () {
    // User biasa bisa lihat daftar mahasiswa (READ only)
    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
    
    // User biasa bisa lihat daftar prodi (READ only)
    Route::get('/prodi', [ProdiController::class, 'index'])->name('prodi.index');
    
    // User biasa bisa lihat daftar fakultas (READ only)
    Route::get('/fakultas', [FakultasController::class, 'index'])->name('fakultas.index');
});

// ============================================
// ROUTE UNTUK ADMIN (bisa CRUD semua)
// ============================================
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin bisa CRUD Mahasiswa
    Route::resource('mahasiswa', MahasiswaController::class)
        ->except(['index']); // kecuali index, karena sudah ada di atas
    
    // Admin bisa CRUD Prodi
    Route::resource('prodi', ProdiController::class)
        ->except(['index']);
    
    // Admin bisa CRUD Fakultas
    Route::resource('fakultas', FakultasController::class)
        ->except(['index'])
        ->parameters(['fakultas' => 'fakultas']);
});

require __DIR__.'/auth.php';