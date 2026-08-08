@extends('layouts.admin')

@section('title', 'Member Management')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Member Management</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Members</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Daftar Member
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Status Langganan</th>
                                <th>Aktif Sejak</th>
                                <th>Expired</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($members as $index => $member)
                                <tr>
                                    <td>{{ $members->firstItem() + $index }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->email }}</td>
                                    <td>
                                        @if ($member->isActive())
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>{{ $member->subscription_start?->format('d M Y') ?? '-' }}</td>
                                    <td>{{ $member->subscription_end?->format('d M Y') ?? '-' }}</td>
                                    <td class="text-end">
                                        <form action="{{ route('admin.members.toggle', $member->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @if ($member->status === 'active')
                                                <button class="btn btn-sm btn-outline-danger" title="Nonaktifkan">
                                                    <i class="fas fa-ban"></i> Nonaktif
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-outline-success" title="Aktifkan">
                                                    <i class="fas fa-check"></i> Aktif
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Belum ada member.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $members->links() }}
            </div>
        </div>
    </div>
@endsection
