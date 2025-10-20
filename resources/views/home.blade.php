<!DOCTYPE html>
<html>
<head>
    <title>Menu Utama</title>
</head>
<body>
    <h1>Menu Utama</h1>

    <ul>
        <li><a href="{{ route('mahasiswa.index') }}">Daftar Mahasiswa</a></li>
        <li><a href="{{ route('prodi.index') }}">Daftar Program Studi</a></li>
        <li><a href="{{ route('fakultas.index') }}">Daftar Fakultas</a></li>
    </ul>
</body>
</html>
