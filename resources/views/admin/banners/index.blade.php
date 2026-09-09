@extends('layouts.admin')

@section('title', 'Banner / Iklan')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Banner / Iklan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Banner</li>
    </ol>

    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="small text-uppercase">Total Banner</div>
                    <div class="fs-3 fw-bold">{{ $stats['total'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="small text-uppercase">Aktif</div>
                    <div class="fs-3 fw-bold">{{ $stats['active'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-secondary text-white h-100">
                <div class="card-body">
                    <div class="small text-uppercase">Nonaktif</div>
                    <div class="fs-3 fw-bold">{{ $stats['inactive'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-dark h-100">
                <div class="card-body">
                    <div class="small text-uppercase">CTR</div>
                    <div class="fs-3 fw-bold">{{ $stats['ctr'] }}%</div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div class="d-flex gap-2 flex-wrap">
            <form method="GET" class="d-flex gap-2 flex-wrap align-items-center">
                <input type="text" name="search" class="form-control" placeholder="Cari banner..." value="{{ request('search') }}">
                <select name="posisi" class="form-select">
                    <option value="">Semua Posisi</option>
                    @foreach (config('banner.positions') as $key => $value)
                        <option value="{{ $key }}" {{ request('posisi') === $key ? 'selected' : '' }}>{{ $value['label'] }}</option>
                    @endforeach
                </select>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                <button type="submit" class="btn btn-outline-dark">Filter</button>
            </form>
        </div>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-danger">
            <i class="fas fa-plus me-1"></i>Tambah Banner
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-images me-1"></i>
            Daftar Banner
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Preview</th>
                            <th>Judul</th>
                            <th>Posisi</th>
                            <th>Status</th>
                            <th>Mulai</th>
                            <th>Berakhir</th>
                            <th>Urutan</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($banners as $banner)
                            <tr>
                                <td>
                                    @if ($banner->gambar)
                                        <img src="{{ asset('storage/' . $banner->gambar) }}" alt="{{ $banner->alt_text ?? $banner->judul }}" style="width:100px; height:auto; max-height:70px; object-fit:cover; border-radius:6px;">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $banner->judul }}</strong><br>
                                    <small class="text-muted">{{ $banner->link }}</small>
                                </td>
                                <td>{{ config('banner.positions.' . $banner->posisi . '.label', ucfirst($banner->posisi)) }}</td>
                                <td>
                                    @if ($banner->status === 'active')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td>{{ $banner->tanggal_mulai ? \
Carbon\Carbon::parse($banner->tanggal_mulai)->format('d M Y') : '-' }}</td>
                                <td>{{ $banner->tanggal_selesai ? \
Carbon\Carbon::parse($banner->tanggal_selesai)->format('d M Y') : '-' }}</td>
                                <td>{{ $banner->urutan }}</td>
                                <td class="text-end">
                                    <form action="{{ route('admin.banners.toggle-status', $banner->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-{{ $banner->status === 'active' ? 'secondary' : 'success' }}">
                                            {{ $banner->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus banner ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Belum ada banner.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $banners->links() }}
        </div>
    </div>
</div>
@endsection
