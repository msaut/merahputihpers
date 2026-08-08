@extends('layouts.admin')

@section('title', 'Tambah Paket Langganan')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Tambah Paket Langganan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.subscription-plans.index') }}">Paket</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>

        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.subscription-plans.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nama Paket</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Durasi (hari)</label>
                        <input type="number" name="days" min="1" class="form-control @error('days') is-invalid @enderror"
                            value="{{ old('days') }}" required>
                        @error('days')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" name="price" min="0" step="0.01"
                            class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
                        @error('price')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-danger">Simpan</button>
                    <a href="{{ route('admin.subscription-plans.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
