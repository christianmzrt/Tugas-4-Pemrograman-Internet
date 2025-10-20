<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    // ========================
    // TAMPILKAN SEMUA DATA
    // ========================
    public function index()
    {
        // Ambil data mahasiswa beserta nama prodi-nya (relasi)
        $mahasiswa = Mahasiswa::with('prodi')->orderBy('id')->get();
        return view('mahasiswa.index', compact('mahasiswa'));
    }

    // ========================
    // FORM TAMBAH DATA
    // ========================
    public function create()
    {
        // Ambil semua data prodi untuk dropdown
        $prodi = Prodi::orderBy('nama_prodi')->get();
        return view('mahasiswa.create', compact('prodi'));
    }

    // ========================
    // SIMPAN DATA BARU
    // ========================
    public function store(Request $request)
    {
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

    // ========================
    // FORM EDIT DATA
    // ========================
    public function edit(Mahasiswa $mahasiswa)
    {
        $prodi = Prodi::orderBy('nama_prodi')->get();
        return view('mahasiswa.edit', compact('mahasiswa', 'prodi'));
    }

    // ========================
    // UPDATE DATA
    // ========================
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
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

    // ========================
    // HAPUS DATA
    // ========================
    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();

        // Urutkan ulang ID mahasiswa agar rapih
        $data = Mahasiswa::orderBy('id')->get();
        $counter = 1;

        foreach ($data as $row) {
            DB::table('mahasiswa')->where('id', $row->id)->update(['id' => $counter]);
            $counter++;
        }

        // Reset auto increment sesuai DB
        $connection = DB::getDriverName();
        if ($connection === 'sqlite') {
            DB::statement("DELETE FROM sqlite_sequence WHERE name='mahasiswa'");
        } elseif (in_array($connection, ['mysql', 'mariadb'])) {
            DB::statement("ALTER TABLE mahasiswa AUTO_INCREMENT = 1");
        }

        return redirect()
            ->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil dihapus dan ID diurutkan ulang.');
    }
}
