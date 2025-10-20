<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Data Program Studi</title>

    {{-- Gunakan vite jika tersedia, fallback ke CDN --}}
    @if (file_exists(public_path('build/manifest.json')))
        @vite('resources/css/app.css')
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col items-center py-10">

    <div class="w-full max-w-5xl bg-white shadow-lg rounded-xl p-8">
        <h2 class="text-3xl font-bold text-center text-blue-700 mb-6">🏫 Daftar Program Studi</h2>

        {{-- Tombol tambah --}}
        <div class="flex justify-end mb-5">
            <a href="{{ route('prodi.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-150 ease-in-out">
                + Tambah Prodi
            </a>
        </div>

        {{-- Pesan sukses --}}
        @if(session('success'))
            <p class="text-green-600 text-center font-medium mb-4">{{ session('success') }}</p>
        @endif

        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Kode Prodi</th>
                        <th class="px-4 py-2 text-left">Nama Prodi</th>
                        <th class="px-4 py-2 text-left">Fakultas</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($prodi as $p)
                        <tr class="hover:bg-gray-100 transition">
                            <td class="px-4 py-2">{{ $p->id }}</td>
                            <td class="px-4 py-2">{{ $p->kode_prodi }}</td>
                            <td class="px-4 py-2">{{ $p->nama_prodi }}</td>
                            <td class="px-4 py-2">{{ $p->fakultas->nama_fakultas ?? '-' }}</td>
                            <td class="px-4 py-2 text-center space-x-2">
                                <a href="{{ route('prodi.edit', $p->id) }}"
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg shadow transition">
                                    Edit
                                </a>
                                <form action="{{ route('prodi.destroy', $p->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Yakin mau hapus data ini?')"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg shadow transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">Belum ada data prodi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
