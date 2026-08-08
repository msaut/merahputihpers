@extends('layouts.admin')

@section('title', 'Paket Langganan')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Paket Langganan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Paket</li>
        </ol>

        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.subscription-plans.create') }}" class="btn btn-danger">
                <i class="fas fa-plus me-1"></i>Tambah Paket
            </a>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-crown me-1"></i>
                Master Paket Langganan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Durasi (hari)</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($plans as $index => $plan)
                                <tr>
                                    <td>{{ $plans->firstItem() + $index }}</td>
                                    <td>{{ $plan->name }}</td>
                                    <td>{{ $plan->days }} hari</td>
                                    <td>Rp {{ number_format($plan->price, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($plan->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.subscription-plans.edit', $plan->id) }}"
                                            class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.subscription-plans.destroy', $plan->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Hapus paket ini?')">
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
                                    <td colspan="6" class="text-center text-muted">Belum ada paket.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $plans->links() }}
            </div>
        </div>
    </div>
@endsection
