<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Tambah Program Studi</title>

    {{-- Aman dari error vite --}}
    @if (file_exists(public_path('build/manifest.json')))
        @vite('resources/css/app.css')
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col items-center py-10">

    <div class="w-full max-w-lg bg-white shadow-lg rounded-xl p-8">
        <h2 class="text-3xl font-bold text-center text-blue-700 mb-6">Tambah Program Studi</h2>

        {{-- Pesan sukses/error --}}
        @if(session('success'))
            <p class="text-green-600 text-center font-medium mb-4">{{ session('success') }}</p>
        @endif
        @if(session('error'))
            <p class="text-red-600 text-center font-medium mb-4">{{ session('error') }}</p>
        @endif

        {{-- Form tambah prodi --}}
        <form action="{{ route('prodi.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="kode_prodi" class="block font-semibold text-gray-700 mb-2">Kode Prodi</label>
                <input type="text" name="kode_prodi" id="kode_prodi"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                       required>
            </div>

            <div>
                <label for="nama_prodi" class="block font-semibold text-gray-700 mb-2">Nama Prodi</label>
                <input type="text" name="nama_prodi" id="nama_prodi"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                       required>
            </div>

            <div>
                <label for="fakultas_id" class="block font-semibold text-gray-700 mb-2">Fakultas</label>
                <select name="fakultas_id" id="fakultas_id"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required>
                    <option value="">-- Pilih Fakultas --</option>
                    @foreach($fakultas as $f)
                        <option value="{{ $f->id }}">{{ $f->nama_fakultas }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-between items-center pt-4">
                <a href="{{ route('prodi.index') }}"
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg shadow transition duration-150 ease-in-out">
                    ← Kembali
                </a>

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow transition duration-150 ease-in-out">
                    Simpan
                </button>
            </div>
        </form>
    </div>

</body>
</html>
