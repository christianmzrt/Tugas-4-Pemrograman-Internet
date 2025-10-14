<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;

// Arahkan root "/" langsung ke halaman daftar mahasiswa
Route::get('/', function () {
    return redirect()->route('mahasiswa.index');
});

// Resource route otomatis untuk semua fitur CRUD Mahasiswa
Route::resource('mahasiswa', MahasiswaController::class);
