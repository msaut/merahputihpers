@extends('member.layouts.member')

@section('title', 'Langganan Member')

@section('content')
    <h3 class="mb-4">Langganan Koran Digital</h3>

    {{-- Status Langganan --}}
    <div class="card stat-card mb-4">
        <div class="card-body">
            @if ($member->isActive())
                <div class="d-flex align-items-center">
                    <span class="badge bg-success me-2">Aktif</span>
                    <div>
                        Berakhir:
                        <strong>{{ $member->subscription_end?->format('d M Y') }}</strong>
                    </div>
                </div>
            @else
                <div class="d-flex align-items-center">
                    <span class="badge bg-secondary me-2">Tidak Aktif</span>
                    <div>Anda belum memiliki langganan aktif. Pilih paket di bawah untuk mulai.</div>
                </div>
            @endif
        </div>
    </div>

    {{-- Pilih Paket --}}
    <div class="row mb-4">
        @forelse ($plans as $plan)
            <div class="col-md-4 mb-3">
                <div class="card stat-card h-100">
                    <div class="card-body text-center">
                        <h5 class="mb-1">{{ $plan->name }}</h5>
                        <p class="text-muted mb-2">{{ $plan->description }}</p>
                        <h3 class="text-danger mb-3">Rp {{ number_format($plan->price, 0, ',', '.') }}</h3>
                        <a href="{{ route('member.subscriptions.pay', $plan->id) }}"
                            class="btn btn-danger btn-sm">Langganan</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Belum ada paket tersedia.</div>
            </div>
        @endforelse
    </div>

    {{-- Riwayat Pembayaran --}}
    <div class="card stat-card">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Riwayat Pembayaran</h5>
        </div>
        <div class="card-body">
            @if ($payments->isEmpty())
                <p class="text-muted mb-0">Belum ada transaksi.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead>
                            <tr>
                                <th>Paket</th>
                                <th>Jumlah</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>{{ $payment->plan?->name ?? '-' }}</td>
                                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                    <td>{{ $payment->method?->name ?? '-' }}</td>
                                    <td>
                                        @if ($payment->status === 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif ($payment->status === 'approved')
                                            <span class="badge bg-success">Disetujui</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>{{ $payment->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
