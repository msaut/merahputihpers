@extends('layouts.admin')

@section('title', 'Metode Pembayaran')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Metode Pembayaran</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Metode</li>
        </ol>

        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.payment-methods.create') }}" class="btn btn-danger">
                <i class="fas fa-plus me-1"></i>Tambah Metode
            </a>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-credit-card me-1"></i>
                Master Metode Pembayaran
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Kode</th>
                                <th>No. Rekening</th>
                                <th>Atas Nama</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($methods as $index => $method)
                                <tr>
                                    <td>{{ $methods->firstItem() + $index }}</td>
                                    <td>{{ $method->name }}</td>
                                    <td>{{ $method->code }}</td>
                                    <td>{{ $method->account_number ?? '-' }}</td>
                                    <td>{{ $method->account_name ?? '-' }}</td>
                                    <td>
                                        @if ($method->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.payment-methods.edit', $method->id) }}"
                                            class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.payment-methods.destroy', $method->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Hapus metode ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Belum ada metode pembayaran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $methods->links() }}
            </div>
        </div>
    </div>
@endsection
