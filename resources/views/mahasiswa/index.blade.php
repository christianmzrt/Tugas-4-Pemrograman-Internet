<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Mahasiswa</title>
    
    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        }
        .card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        }
        .table-container {
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        .btn {
            border-radius: 6px;
            font-weight: 500;
        }
        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-mortarboard-fill me-2"></i>
                Sistem Akademik
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/') }}">
                            <i class="bi bi-people-fill me-1"></i>
                            Mahasiswa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/prodi') }}">
                            <i class="bi bi-journal-bookmark-fill me-1"></i>
                            Program Studi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/fakultas') }}">
                            <i class="bi bi-building me-1"></i>
                            Fakultas
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <div class="container mt-4 mb-5">
        
        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">
                <i class="bi bi-people-fill text-primary me-2"></i>
                Daftar Mahasiswa
            </h2>
            <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>
                Tambah Mahasiswa
            </a>
        </div>

        {{-- Alert Success --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Alert Error --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Table Card --}}
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3" style="width: 60px;">No</th>
                                <th class="px-4 py-3">NIM</th>
                                <th class="px-4 py-3">Nama Mahasiswa</th>
                                <th class="px-4 py-3">Program Studi</th>
                                <th class="px-4 py-3 text-center" style="width: 180px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mahasiswa as $index => $m)
                            <tr>
                                <td class="px-4 py-3">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-secondary">{{ $m->nim }}</span>
                                </td>
                                <td class="px-4 py-3 fw-medium">{{ $m->nama }}</td>
                                <td class="px-4 py-3">
                                    <i class="bi bi-journal-bookmark text-primary me-1"></i>
                                    {{ $m->prodi->nama_prodi ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ route('mahasiswa.edit', $m->id) }}" 
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('mahasiswa.destroy', $m->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus mahasiswa ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Belum ada data mahasiswa
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Info Footer --}}
        <div class="mt-3 text-muted small">
            <i class="bi bi-info-circle me-1"></i>
            Total: <strong>{{ $mahasiswa->count() }}</strong> mahasiswa
        </div>

    </div>

    {{-- Bootstrap 5 JS Bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>