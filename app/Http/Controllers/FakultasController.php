<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use Illuminate\Http\Request;

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

    public function destroy($id)
    {
        try {
            // Cari fakultas berdasarkan ID
            $fakultas = Fakultas::findOrFail($id);
            
            // Cek apakah fakultas punya relasi dengan prodi
            if ($fakultas->prodi()->count() > 0) {
                return redirect()->route('fakultas.index')
                    ->with('error', 'Tidak bisa hapus! Fakultas ini masih memiliki ' . $fakultas->prodi()->count() . ' prodi.');
            }
            
            // Hapus fakultas
            $fakultas->delete();
            
            return redirect()->route('fakultas.index')
                ->with('success', 'Fakultas berhasil dihapus.');
                
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('fakultas.index')
                ->with('error', 'Data fakultas tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect()->route('fakultas.index')
                ->with('error', 'Gagal menghapus fakultas: ' . $e->getMessage());
        }
    }
}