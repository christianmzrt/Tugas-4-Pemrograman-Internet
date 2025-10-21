<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Edit Fakultas</title>

    {{-- Aman dari error vite --}}
    @if (file_exists(public_path('build/manifest.json')))
        @vite('resources/css/app.css')
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold text-center mb-6 text-blue-600">Edit Data Fakultas</h1>

        {{-- Tampilkan error validasi --}}
        @if ($errors->any())
            <ul class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        {{-- Form Update --}}
        <form action="{{ route('fakultas.update', $fakultas) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Input Kode Fakultas --}}
            <div>
                <label for="kode_fakultas" class="block font-medium text-gray-700">Kode Fakultas</label>
                <input type="text" name="kode_fakultas" id="kode_fakultas"
                    value="{{ old('kode_fakultas', $fakultas->kode_fakultas) }}"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('kode_fakultas') border-red-500 @enderror">
                @error('kode_fakultas')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Nama Fakultas --}}
            <div>
                <label for="nama_fakultas" class="block font-medium text-gray-700">Nama Fakultas</label>
                <input type="text" name="nama_fakultas" id="nama_fakultas"
                    value="{{ old('nama_fakultas', $fakultas->nama_fakultas) }}"
                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('nama_fakultas') border-red-500 @enderror">
                @error('nama_fakultas')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition">
                Update
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('fakultas.index') }}" class="text-blue-500 hover:underline">← Kembali</a>
        </div>
    </div>

</body>
</html>