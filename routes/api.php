<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MahasiswaController;

// Route untuk login (mendapatkan token)
Route::post('/login', [AuthController::class, 'login']);

// Route yang diproteksi dengan token
Route::middleware('auth:sanctum')->group(function () {
    // Mendapatkan data user yang login
    Route::get('/user', [AuthController::class, 'user']);
    
    // Logout (hapus token)
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // API Mahasiswa (harus punya token)
    Route::get('/mahasiswa', [MahasiswaController::class, 'index']);
    Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'show']);
});