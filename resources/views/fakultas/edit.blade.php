<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Fakultas</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
            padding: 40px 0;
        }
        .card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        }
        .card-header {
            background-color: #fff;
            border-bottom: 2px solid #e9ecef;
            padding: 1.25rem;
        }
        .form-label {
            color: #495057;
            margin-bottom: 0.5rem;
        }
        .form-control:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }
        .btn {
            padding: 0.5rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                {{-- Card Form --}}
                <div class="card">

                    {{-- Header --}}
                    <div class="card-header">
                        <h4 class="mb-0 text-dark">
                            <i class="bi bi-pencil-square me-2"></i>
                            Edit Fakultas
                        </h4>
                    </div>

                    {{-- Body --}}
                    <div class="card-body p-4">

                        {{-- Alert Error Validasi --}}
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <strong>Terjadi kesalahan:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        {{-- Alert Success --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        {{-- Form Edit --}}
                        <form action="{{ route('fakultas.update', $fakultas) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Input Kode Fakultas --}}
                            <div class="mb-3">
                                <label for="kode_fakultas" class="form-label">
                                    Kode Fakultas
                                </label>
                                <input 
                                    type="text" 
                                    name="kode_fakultas" 
                                    id="kode_fakultas"
                                    value="{{ old('kode_fakultas', $fakultas->kode_fakultas) }}"
                                    class="form-control @error('kode_fakultas') is-invalid @enderror" 
                                    required
                                >
                                @error('kode_fakultas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Input Nama Fakultas --}}
                            <div class="mb-4">
                                <label for="nama_fakultas" class="form-label">
                                    Nama Fakultas
                                </label>
                                <input 
                                    type="text" 
                                    name="nama_fakultas" 
                                    id="nama_fakultas"
                                    value="{{ old('nama_fakultas', $fakultas->nama_fakultas) }}"
                                    class="form-control @error('nama_fakultas') is-invalid @enderror"
                                    required
                                >
                                @error('nama_fakultas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Buttons --}}
                            <div class="d-flex justify-content-between align-items-center pt-3">
                                <a href="{{ route('fakultas.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-1"></i>
                                    Kembali
                                </a>

                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i>
                                    Update
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Bootstrap 5 JS Bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
