@extends('layouts.admin')

@section('title', 'Tambah Metode Pembayaran')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Tambah Metode Pembayaran</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.payment-methods.index') }}">Metode</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>

        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.payment-methods.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kode (contoh: qris, shopeepay)</label>
                        <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                            value="{{ old('code') }}" required>
                        @error('code')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor / Akun</label>
                        <input type="text" name="account_number" class="form-control"
                            value="{{ old('account_number') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Atas Nama</label>
                        <input type="text" name="account_name" class="form-control" value="{{ old('account_name') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="description" class="form-control" rows="3"
                            placeholder="Cara membayar / petunjuk transfer">{{ old('description') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-danger">Simpan</button>
                    <a href="{{ route('admin.payment-methods.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
