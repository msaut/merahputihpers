@extends('layouts.admin')

@section('title', 'Upload Koran PDF')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Upload Koran PDF</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.koran.index') }}">Koran PDF</a></li>
            <li class="breadcrumb-item active">Upload</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-upload me-1"></i>
                Form Upload PDF
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.koran.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                            value="{{ old('judul') }}" required>
                        @error('judul')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                            value="{{ old('tanggal', now()->format('Y-m-d')) }}" required>
                        @error('tanggal')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">File PDF</label>
                        <input type="file" name="file" class="form-control @error('file') is-invalid @enderror"
                            accept="application/pdf" required>
                        @error('file')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <div class="form-text">Format: PDF. Maks 20MB.</div>
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" name="is_active" value="1"
                            {{ old('is_active', 1) ? 'checked' : '' }}>
                        <label class="form-check-label">Aktif (dapat diakses member)</label>
                    </div>

                    <button type="submit" class="btn btn-danger">Upload</button>
                    <a href="{{ route('admin.koran.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
