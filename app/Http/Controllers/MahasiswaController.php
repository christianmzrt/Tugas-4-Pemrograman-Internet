<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    // Tampilkan semua data
    public function index()
    {
        $mahasiswa = Mahasiswa::with('prodi')->orderBy('id')->get();
        return view('mahasiswa.index', compact('mahasiswa'));
    }

    // Form tambah data
    public function create()
    {
        // PROTEKSI: Hanya admin yang bisa akses
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $prodi = Prodi::orderBy('nama_prodi')->get();
        return view('mahasiswa.create', compact('prodi'));
    }

    // Simpan data baru
    public function store(Request $request)
    {
        // PROTEKSI: Hanya admin yang bisa tambah data
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk menambah data.');
        }

        $request->validate([
            'nim' => 'required|min:4|unique:mahasiswa,nim',
            'nama' => 'required',
            'prodi_id' => 'required|exists:prodi,id',
        ], [
            'nim.required' => 'NIM wajib diisi.',
            'nim.min' => 'NIM harus memiliki minimal 4 karakter.',
            'nim.unique' => 'NIM sudah terdaftar, silakan gunakan NIM lain.',
            'nama.required' => 'Nama wajib diisi.',
            'prodi_id.required' => 'Program studi wajib dipilih.',
            'prodi_id.exists' => 'Program studi tidak valid.',
        ]);

        Mahasiswa::create([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'prodi_id' => $request->prodi_id,
        ]);

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil disimpan.');
    }

    // Form edit data
    public function edit(Mahasiswa $mahasiswa)
    {
        // PROTEKSI: Hanya admin yang bisa akses
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $prodi = Prodi::orderBy('nama_prodi')->get();
        return view('mahasiswa.edit', compact('mahasiswa', 'prodi'));
    }

    // Update data
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        // PROTEKSI: Hanya admin yang bisa update data
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah data.');
        }

        $request->validate([
            'nim' => 'required|min:4|unique:mahasiswa,nim,' . $mahasiswa->id,
            'nama' => 'required',
            'prodi_id' => 'required|exists:prodi,id',
        ], [
            'nim.required' => 'NIM wajib diisi.',
            'nim.min' => 'NIM harus memiliki minimal 4 karakter.',
            'nim.unique' => 'NIM sudah terdaftar, silakan gunakan NIM lain.',
            'nama.required' => 'Nama wajib diisi.',
            'prodi_id.required' => 'Program studi wajib dipilih.',
            'prodi_id.exists' => 'Program studi tidak valid.',
        ]);

        $mahasiswa->update([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'prodi_id' => $request->prodi_id,
        ]);

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    // Hapus data
    public function destroy($id)
    {
        // PROTEKSI: Hanya admin yang bisa hapus data
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus data.');
        }

        try {
            $mahasiswa = Mahasiswa::findOrFail($id);
            $mahasiswa->delete();
            
            return redirect()->route('mahasiswa.index')
                ->with('success', 'Data mahasiswa berhasil dihapus.');
                
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('mahasiswa.index')
                ->with('error', 'Data mahasiswa tidak ditemukan.');
        } catch (\Exception $e) {
            return redirect()->route('mahasiswa.index')
                ->with('error', 'Gagal menghapus mahasiswa: ' . $e->getMessage());
        }
    }
}