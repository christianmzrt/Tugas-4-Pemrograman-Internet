<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::orderBy('id')->get();
        return view('mahasiswa.index', compact('mahasiswa'));
    }

    public function create()
    {
        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|min:4|unique:mahasiswa,nim',
            'nama' => 'required',
            'prodi' => 'required'
        ], [
            'nim.required' => 'NIM wajib diisi.',
            'nim.min' => 'NIM harus memiliki minimal 4 karakter.',
            'nim.unique' => 'NIM sudah terdaftar, silakan gunakan NIM lain.',
            'nama.required' => 'Nama wajib diisi.',
            'prodi.required' => 'Program studi wajib diisi.',
        ]);

        Mahasiswa::create($request->only('nim', 'nama', 'prodi'));

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil disimpan.');
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'nim' => 'required|min:4|unique:mahasiswa,nim,' . $mahasiswa->id,
            'nama' => 'required',
            'prodi' => 'required'
        ], [
            'nim.required' => 'NIM wajib diisi.',
            'nim.min' => 'NIM harus memiliki minimal 4 karakter.',
            'nim.unique' => 'NIM sudah terdaftar, silakan gunakan NIM lain.',
            'nama.required' => 'Nama wajib diisi.',
            'prodi.required' => 'Program studi wajib diisi.',
        ]);

        $mahasiswa->update($request->only('nim', 'nama', 'prodi'));

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        // Hapus data mahasiswa
        $mahasiswa->delete();

        // Reindex ulang ID agar urut kembali mulai dari 1
        $data = Mahasiswa::orderBy('id')->get();
        $counter = 1;

        foreach ($data as $row) {
            DB::table('mahasiswa')->where('id', $row->id)->update(['id' => $counter]);
            $counter++;
        }

        // 🔧 Deteksi database dan reset autoincrement sesuai tipe DB
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
