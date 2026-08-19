@extends('layouts.admin')

@section('title', 'Edit Rekanan')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Edit Rekanan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.rekanans.index') }}">Rekanan</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>

        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.rekanans.update', $rekanan->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Rekanan</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $rekanan->name) }}" required>
                        @error('name')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">URL</label>
                        <input type="url" name="url" class="form-control @error('url') is-invalid @enderror" value="{{ old('url', $rekanan->url) }}" required>
                        @error('url')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Urutan</label>
                        <input type="number" name="sort_order" min="0" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $rekanan->sort_order) }}">
                        @error('sort_order')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" name="is_active" value="1" {{ old('is_active', $rekanan->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label">Aktif</label>
                    </div>

                    <button type="submit" class="btn btn-danger">Simpan</button>
                    <a href="{{ route('admin.rekanans.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
