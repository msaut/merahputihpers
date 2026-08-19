@extends('layouts.admin')

@section('title', 'Rekanan')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Rekanan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Rekanan</li>
        </ol>

        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.rekanans.create') }}" class="btn btn-danger">
                <i class="fas fa-plus me-1"></i>Tambah Rekanan
            </a>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-handshake me-1"></i>
                Daftar Rekanan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>URL</th>
                                <th>Urutan</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rekanans as $index => $rekanan)
                                <tr>
                                    <td>{{ $rekanans->firstItem() + $index }}</td>
                                    <td>{{ $rekanan->name }}</td>
                                    <td><a href="{{ $rekanan->url }}" target="_blank" rel="noopener noreferrer">{{ $rekanan->url }}</a></td>
                                    <td>{{ $rekanan->sort_order }}</td>
                                    <td>
                                        @if ($rekanan->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.rekanans.edit', $rekanan->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.rekanans.destroy', $rekanan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus rekanan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada data rekanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $rekanans->links() }}
            </div>
        </div>
    </div>
@endsection
