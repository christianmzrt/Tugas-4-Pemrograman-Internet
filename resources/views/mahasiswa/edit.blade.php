<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Edit Mahasiswa</title>

    {{-- Aman dari error vite --}}
    @if (file_exists(public_path('build/manifest.json')))
        @vite('resources/css/app.css')
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold text-center mb-6 text-blue-600">Edit Data Mahasiswa</h1>

        {{-- Tampilkan error validasi --}}
        @if ($errors->any())
            <ul class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        {{-- Form Update --}}
        <form method="POST" action="{{ route('mahasiswa.update', $mahasiswa->id) }}" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Input NIM --}}
            <div>
                <label class="block font-medium text-gray-700">NIM</label>
                <input type="text" name="nim" 
                    value="{{ old('nim', $mahasiswa->nim) }}"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('nim') border-red-500 @enderror">
                @error('nim')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Nama --}}
            <div>
                <label class="block font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" 
                    value="{{ old('nama', $mahasiswa->nama) }}"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('nama') border-red-500 @enderror">
                @error('nama')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Prodi --}}
            <div>
                <label class="block font-medium text-gray-700">Program Studi</label>
                <input type="text" name="prodi" 
                    value="{{ old('prodi', $mahasiswa->prodi) }}"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('prodi') border-red-500 @enderror">
                @error('prodi')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition">
                Update
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('mahasiswa.index') }}" class="text-blue-500 hover:underline">← Kembali</a>
        </div>
    </div>

</body>
</html>
