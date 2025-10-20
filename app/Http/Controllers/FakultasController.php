<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FakultasController extends Controller
{
    public function index()
    {
        $fakultas = Fakultas::orderBy('id')->get();
        return view('fakultas.index', compact('fakultas'));
    }

    public function create()
    {
        return view('fakultas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_fakultas' => 'required|unique:fakultas,kode_fakultas',
            'nama_fakultas' => 'required'
        ]);

        Fakultas::create($request->only('kode_fakultas', 'nama_fakultas'));

        return redirect()->route('fakultas.index')->with('success', 'Fakultas berhasil ditambahkan.');
    }

    public function edit(Fakultas $fakultas)
    {
        return view('fakultas.edit', compact('fakultas'));
    }

    public function update(Request $request, Fakultas $fakultas)
    {
        $request->validate([
            'kode_fakultas' => 'required|unique:fakultas,kode_fakultas,' . $fakultas->id,
            'nama_fakultas' => 'required'
        ]);

        $fakultas->update($request->only('kode_fakultas', 'nama_fakultas'));

        return redirect()->route('fakultas.index')->with('success', 'Fakultas berhasil diperbarui.');
    }

    public function destroy(Fakultas $fakultas)
    {
        $fakultas->delete();

        // Reset auto increment kalau tabel kosong
        if (Fakultas::count() === 0) {
            DB::statement('ALTER TABLE fakultas AUTO_INCREMENT = 1');
        }

        return redirect()->route('fakultas.index')->with('success', 'Fakultas berhasil dihapus.');
    }

    // 🧹 Tambahan baru: hapus semua data fakultas sekaligus
    public function destroyAll()
    {
        try {
            Fakultas::truncate(); // hapus semua data + reset auto increment otomatis
            return redirect()->route('fakultas.index')
                ->with('success', 'Semua data fakultas berhasil dihapus dan ID direset!');
        } catch (\Exception $e) {
            return redirect()->route('fakultas.index')
                ->with('error', 'Terjadi kesalahan saat menghapus semua data.');
        }
    }
}
