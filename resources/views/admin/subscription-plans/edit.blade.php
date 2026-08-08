@extends('layouts.admin')

@section('title', 'Edit Paket Langganan')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Edit Paket Langganan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.subscription-plans.index') }}">Paket</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>

        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.subscription-plans.update', $subscriptionPlan->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Paket</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $subscriptionPlan->name) }}" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Durasi (hari)</label>
                        <input type="number" name="days" min="1" class="form-control @error('days') is-invalid @enderror"
                            value="{{ old('days', $subscriptionPlan->days) }}" required>
                        @error('days')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" name="price" min="0" step="0.01"
                            class="form-control @error('price') is-invalid @enderror"
                            value="{{ old('price', $subscriptionPlan->price) }}" required>
                        @error('price')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="2">{{ old('description', $subscriptionPlan->description) }}</textarea>
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" name="is_active" value="1"
                            {{ old('is_active', $subscriptionPlan->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label">Aktif</label>
                    </div>

                    <button type="submit" class="btn btn-danger">Simpan</button>
                    <a href="{{ route('admin.subscription-plans.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
