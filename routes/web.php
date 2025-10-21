<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\FakultasController;

// Saat buka root ("/"), langsung tampil daftar mahasiswa
Route::get('/', [MahasiswaController::class, 'index'])->name('mahasiswa.index');

// Resource route untuk CRUD
Route::resource('mahasiswa', MahasiswaController::class);
Route::resource('prodi', ProdiController::class);
Route::resource('fakultas', FakultasController::class);