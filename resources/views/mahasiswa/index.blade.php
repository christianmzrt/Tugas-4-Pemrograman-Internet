<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Daftar Mahasiswa</title>

    {{-- Aman dari error vite --}}
    @if (file_exists(public_path('build/manifest.json')))
        @vite('resources/css/app.css')
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col items-center py-10">

    <div class="w-full max-w-5xl bg-white shadow-lg rounded-xl p-8">
        <h1 class="text-3xl font-bold text-center text-blue-700 mb-6">Daftar Mahasiswa</h1>

        {{-- Pesan sukses atau error --}}
        @if(session('success'))
            <p class="text-green-600 text-center font-medium mb-4">{{ session('success') }}</p>
        @endif
        @if(session('error'))
            <p class="text-red-600 text-center font-medium mb-4">{{ session('error') }}</p>
        @endif

        {{-- Tombol tambah --}}
        <div class="flex justify-end mb-5">
            <a href="{{ route('mahasiswa.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-150 ease-in-out">
                + Tambah Mahasiswa
            </a>
        </div>

        {{-- Tabel daftar mahasiswa --}}
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-blue-100 text-blue-800">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">ID</th>
                        <th class="px-4 py-3 text-left font-semibold">NIM</th>
                        <th class="px-4 py-3 text-left font-semibold">Nama</th>
                        <th class="px-4 py-3 text-left font-semibold">Prodi</th>
                        <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($mahasiswa as $m)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $m->id }}</td>
                        <td class="px-4 py-3">{{ $m->nim }}</td>
                        <td class="px-4 py-3">{{ $m->nama }}</td>
                        <td class="px-4 py-3">{{ $m->prodi }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('mahasiswa.edit', $m->id) }}" 
                                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-md text-sm font-medium transition">
                                   Edit
                                </a>
                                <form action="{{ route('mahasiswa.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm font-medium transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">Belum ada data mahasiswa.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
