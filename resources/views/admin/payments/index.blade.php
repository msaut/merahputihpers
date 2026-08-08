@extends('layouts.admin')

@section('title', 'Verifikasi Pembayaran')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Verifikasi Pembayaran</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Pembayaran</li>
        </ol>

        {{-- Filter Status --}}
        <div class="card mb-4">
            <div class="card-body py-2">
                <form method="GET" action="{{ route('admin.payments.index') }}" class="d-flex align-items-center gap-2">
                    <label class="mb-0">Status:</label>
                    <select name="status" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                        <option value="">Semua</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-credit-card me-1"></i>
                Daftar Pembayaran Masuk
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Member</th>
                                <th>Paket</th>
                                <th>Jumlah</th>
                                <th>Metode</th>
                                <th>Bukti</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payments as $index => $payment)
                                <tr class="{{ $payment->status === 'pending' ? 'table-warning' : '' }}">
                                    <td>{{ $payments->firstItem() + $index }}</td>
                                    <td>{{ $payment->member?->name ?? '-' }}<br>
                                        <small class="text-muted">{{ $payment->member?->email ?? '-' }}</small>
                                    </td>
                                    <td>{{ $payment->plan?->name ?? '-' }}</td>
                                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                    <td>{{ $payment->method?->name ?? '-' }}</td>
                                    <td>
                                        @if ($payment->payment_proof)
                                            <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($payment->status === 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif ($payment->status === 'approved')
                                            <span class="badge bg-success">Disetujui</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if ($payment->status === 'pending')
                                            <form action="{{ route('admin.payments.approve', $payment->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-success" title="Setujui">
                                                    <i class="fas fa-check"></i> Approve
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-outline-danger" title="Tolak"
                                                data-bs-toggle="modal"
                                                data-bs-target="#rejectModal{{ $payment->id }}">
                                                <i class="fas fa-times"></i> Reject
                                            </button>

                                            {{-- Modal Reject --}}
                                            <div class="modal fade" id="rejectModal{{ $payment->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered text-start">
                                                    <div class="modal-content">
                                                        <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Tolak Pembayaran</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <label class="form-label">Alasan Penolakan (opsional)</label>
                                                                <textarea name="admin_note" class="form-control" rows="3"></textarea>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-danger">Tolak</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted small">
                                                {{ $payment->status === 'approved' ? ($payment->approved_at?->format('d M Y') ?? '') : ($payment->admin_note ?? '') }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Belum ada pembayaran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $payments->links() }}
            </div>
        </div>
    </div>
@endsection
