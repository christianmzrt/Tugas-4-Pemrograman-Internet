<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Program Studi</title>
    
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
        .btn {
            border-radius: 6px;
            font-weight: 500;
        }
        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }
        .role-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
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
                        <a class="nav-link" href="{{ route('mahasiswa.index') }}">
                            <i class="bi bi-people-fill me-1"></i>
                            Mahasiswa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('prodi.index') }}">
                            <i class="bi bi-journal-bookmark-fill me-1"></i>
                            Program Studi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('fakultas.index') }}">
                            <i class="bi bi-building me-1"></i>
                            Fakultas
                        </a>
                    </li>
                    
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>
                            {{ Auth::user()->name }}
                            <span class="badge bg-warning text-dark role-badge ms-1">
                                {{ Auth::user()->role }}
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person-gear me-2"></i>
                                    Edit Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <div class="container mt-4 mb-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">
                <i class="bi bi-journal-bookmark-fill text-primary me-2"></i>
                Daftar Program Studi
            </h2>
            
            {{-- PROTEKSI: Tombol Tambah hanya untuk Admin --}}
            @if(Auth::check() && Auth::user()->isAdmin())
                <a href="{{ route('prodi.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>
                    Tambah Program Studi
                </a>
            @endif
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Info Role User --}}
        @auth
            @if(Auth::user()->isAdmin())
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="bi bi-shield-check me-2"></i>
                    Anda login sebagai <strong>Admin</strong>. Anda dapat mengelola semua data (Tambah, Edit, Hapus).
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @else
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="bi bi-eye me-2"></i>
                    Anda login sebagai <strong>User</strong>. Anda hanya dapat melihat data.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        @endauth

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3" style="width: 60px;">No</th>
                                <th class="px-4 py-3">Kode Prodi</th>
                                <th class="px-4 py-3">Nama Program Studi</th>
                                <th class="px-4 py-3">Fakultas</th>
                                
                                {{-- Kolom Aksi hanya untuk Admin --}}
                                @if(Auth::check() && Auth::user()->isAdmin())
                                    <th class="px-4 py-3 text-center" style="width: 180px;">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($prodi as $index => $p)
                            <tr>
                                <td class="px-4 py-3">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">
                                    <span class="badge bg-info">{{ $p->kode_prodi }}</span>
                                </td>
                                <td class="px-4 py-3 fw-medium">{{ $p->nama_prodi }}</td>
                                <td class="px-4 py-3">
                                    <i class="bi bi-building text-primary me-1"></i>
                                    {{ $p->fakultas->nama_fakultas ?? '-' }}
                                </td>
                                
                                {{-- Tombol Aksi hanya untuk Admin --}}
                                @if(Auth::check() && Auth::user()->isAdmin())
                                <td class="px-4 py-3 text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ route('prodi.edit', $p->id) }}" 
                                           class="btn btn-warning btn-sm"
                                           title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('prodi.destroy', $p->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus prodi {{ $p->nama_prodi }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-danger btn-sm"
                                                    title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ Auth::check() && Auth::user()->isAdmin() ? '5' : '4' }}" 
                                    class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Belum ada data program studi
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-3 text-muted small">
            <i class="bi bi-info-circle me-1"></i>
            Total: <strong>{{ $prodi->count() }}</strong> program studi
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>