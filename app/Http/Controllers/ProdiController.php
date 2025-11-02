<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Fakultas;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    public function index()
    {
        $prodi = Prodi::with('fakultas')->orderBy('id')->get();
        return view('prodi.index', compact('prodi'));
    }

    public function create()
    {
        // PROTEKSI: Hanya admin yang bisa akses
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $fakultas = Fakultas::all();
        return view('prodi.create', compact('fakultas'));
    }

    public function store(Request $request)
    {
        // PROTEKSI: Hanya admin yang bisa tambah data
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk menambah data.');
        }

        $request->validate([
            'kode_prodi' => 'required|unique:prodi,kode_prodi',
            'nama_prodi' => 'required',
            'fakultas_id' => 'required|exists:fakultas,id'
        ]);

        Prodi::create($request->only('kode_prodi', 'nama_prodi', 'fakultas_id'));

        return redirect()->route('prodi.index')->with('success', 'Prodi berhasil ditambahkan.');
    }

    public function edit(Prodi $prodi)
    {
        // PROTEKSI: Hanya admin yang bisa akses
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $fakultas = Fakultas::all();
        return view('prodi.edit', compact('prodi', 'fakultas'));
    }

    public function update(Request $request, Prodi $prodi)
    {
        // PROTEKSI: Hanya admin yang bisa update data
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah data.');
        }

        $request->validate([
            'kode_prodi' => 'required|unique:prodi,kode_prodi,' . $prodi->id,
            'nama_prodi' => 'required',
            'fakultas_id' => 'required|exists:fakultas,id'
        ]);

        $prodi->update($request->only('kode_prodi', 'nama_prodi', 'fakultas_id'));

        return redirect()->route('prodi.index')->with('success', 'Prodi berhasil diperbarui.');
    }

    public function destroy(Prodi $prodi)
    {
        // PROTEKSI: Hanya admin yang bisa hapus data
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus data.');
        }

        $prodi->delete();
        return redirect()->route('prodi.index')->with('success', 'Prodi berhasil dihapus.');
    }
}