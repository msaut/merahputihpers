@extends('member.layouts.member')

@section('title', 'Koran Digital')

@section('content')
    <h3 class="mb-4">Koran Digital (PDF)</h3>

    <div class="card stat-card">
        <div class="card-body">
            @if ($pdfs->isEmpty())
                <p class="text-muted mb-0">Belum ada koran digital tersedia.</p>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Tanggal</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pdfs as $pdf)
                                <tr>
                                    <td>
                                        <i class="fas fa-file-pdf text-danger me-2"></i>{{ $pdf->judul }}
                                    </td>
                                    <td>{{ $pdf->tanggal?->format('d M Y') ?? '-' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('member.koran.download', $pdf->id) }}"
                                            class="btn btn-sm btn-danger">
                                            <i class="fas fa-download me-1"></i>Download
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
