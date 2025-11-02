<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Menampilkan semua data mahasiswa
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::with('prodi.fakultas')->get();
        
        return response()->json([
            'success' => true,
            'data' => $mahasiswa
        ]);
    }

    /**
     * Menampilkan detail 1 mahasiswa
     */
    public function show($id)
    {
        $mahasiswa = Mahasiswa::with('prodi.fakultas')->find($id);
        
        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Mahasiswa tidak ditemukan'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $mahasiswa
        ]);
    }
}