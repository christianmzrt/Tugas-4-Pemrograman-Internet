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
        // PROTEKSI: Hanya admin yang bisa akses
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('fakultas.create');
    }

    public function store(Request $request)
    {
        // PROTEKSI: Hanya admin yang bisa tambah data
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk menambah data.');
        }

        $request->validate([
            'kode_fakultas' => 'required|unique:fakultas,kode_fakultas',
            'nama_fakultas' => 'required'
        ]);

        Fakultas::create($request->only('kode_fakultas', 'nama_fakultas'));

        return redirect()->route('fakultas.index')->with('success', 'Fakultas berhasil ditambahkan.');
    }

    public function edit(Fakultas $fakultas)
    {
        // PROTEKSI: Hanya admin yang bisa akses
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('fakultas.edit', compact('fakultas'));
    }

    public function update(Request $request, Fakultas $fakultas)
    {
        // PROTEKSI: Hanya admin yang bisa update data
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah data.');
        }

        $request->validate([
            'kode_fakultas' => 'required|unique:fakultas,kode_fakultas,' . $fakultas->id,
            'nama_fakultas' => 'required'
        ]);

        $fakultas->update($request->only('kode_fakultas', 'nama_fakultas'));

        return redirect()->route('fakultas.index')->with('success', 'Fakultas berhasil diperbarui.');
    }

    public function destroy(Fakultas $fakultas)
    {
        // PROTEKSI: Hanya admin yang bisa hapus data
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus data.');
        }

        $fakultas->delete();
        return redirect()->route('fakultas.index')->with('success', 'Fakultas berhasil dihapus.');
    }
}