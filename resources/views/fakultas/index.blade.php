<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Data Fakultas</title>

    {{-- Aman dari error vite --}}
    @if (file_exists(public_path('build/manifest.json')))
        @vite('resources/css/app.css')
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col items-center py-10">

    <div class="w-full max-w-5xl bg-white shadow-lg rounded-xl p-8">
        <h2 class="text-3xl font-bold text-center text-blue-700 mb-6">🎓 Daftar Fakultas</h2>

        {{-- Pesan sukses & error --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-800 border border-green-300 px-4 py-2 rounded mb-4 text-center font-medium">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-800 border border-red-300 px-4 py-2 rounded mb-4 text-center font-medium">
                {{ session('error') }}
            </div>
        @endif

        {{-- Tombol tambah --}}
        <div class="flex justify-end mb-5">
            <a href="{{ route('fakultas.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition">
                + Tambah Fakultas
            </a>
        </div>

        {{-- Tabel data fakultas --}}
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-blue-100 text-blue-800">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">No</th>
                        <th class="px-4 py-3 text-left font-semibold">Kode Fakultas</th>
                        <th class="px-4 py-3 text-left font-semibold">Nama Fakultas</th>
                        <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($fakultas as $index => $f)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">{{ $f->kode_fakultas }}</td>
                            <td class="px-4 py-3">{{ $f->nama_fakultas }}</td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('fakultas.edit', $f->id) }}" 
                                       class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-md text-sm font-medium transition">
                                       ✏️ Edit
                                    </a>

                                    <form action="{{ route('fakultas.destroy', $f->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Yakin mau hapus fakultas ini?')" 
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm font-medium transition">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">Belum ada data fakultas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>