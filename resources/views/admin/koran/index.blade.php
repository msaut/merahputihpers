@extends('layouts.admin')

@section('title', 'Koran Digital (PDF)')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Koran Digital</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Koran PDF</li>
        </ol>

        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.koran.create') }}" class="btn btn-danger">
                <i class="fas fa-upload me-1"></i>Upload PDF
            </a>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-file-pdf me-1"></i>
                Daftar Koran Digital
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Judul</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pdfs as $index => $pdf)
                                <tr>
                                    <td>{{ $pdfs->firstItem() + $index }}</td>
                                    <td><i class="fas fa-file-pdf text-danger me-2"></i>{{ $pdf->judul }}</td>
                                    <td>{{ $pdf->tanggal?->format('d M Y') ?? '-' }}</td>
                                    <td>
                                        @if ($pdf->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ asset('storage/' . $pdf->file) }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.koran.destroy', $pdf->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Hapus PDF ini?')">
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
                                    <td colspan="5" class="text-center text-muted">Belum ada PDF.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $pdfs->links() }}
            </div>
        </div>
    </div>
@endsection
