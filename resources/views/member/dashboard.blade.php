@extends('member.layouts.member')

@section('title', 'Dashboard Member')

@section('content')
    <h3 class="mb-4">Dashboard Member</h3>

    {{-- Stat Cards --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card stat-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small">Bookmark</div>
                        <h3 class="mb-0">{{ $bookmarkCount }}</h3>
                    </div>
                    <div class="icon text-danger"><i class="fas fa-bookmark"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small">Favorit</div>
                        <h3 class="mb-0">{{ $likeCount }}</h3>
                    </div>
                    <div class="icon text-danger"><i class="fas fa-heart"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small">Riwayat Baca</div>
                        <h3 class="mb-0">{{ $historyCount }}</h3>
                    </div>
                    <div class="icon text-primary"><i class="fas fa-history"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small">Komentar</div>
                        <h3 class="mb-0">{{ $commentCount }}</h3>
                    </div>
                    <div class="icon text-success"><i class="fas fa-comments"></i></div>
                </div>
            </div>
        </div>
    </div>

{{-- Info Profil --}}
    <div class="card stat-card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Info Profil</h5>
                @if ($member->isActive())
                    <a href="{{ route('member.koran.index') }}" class="btn btn-sm btn-danger">
                        <i class="fas fa-download me-1"></i>Download PDF
                    </a>
                @else
                    <a href="{{ route('member.subscriptions.index') }}" class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-crown me-1"></i>Langganan Sekarang
                    </a>
                @endif
            </div>
            <dl class="row mb-0">
                <dt class="col-sm-3">Nama</dt>
                <dd class="col-sm-9">{{ $member->name }}</dd>
                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{ $member->email }}</dd>
                <dt class="col-sm-3">Member sejak</dt>
                <dd class="col-sm-9">{{ $member->created_at->format('d M Y') }}</dd>
                <dt class="col-sm-3">Status Langganan</dt>
                <dd class="col-sm-9">
                    @if ($member->isActive())
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-secondary">Tidak Aktif</span>
                    @endif
                </dd>
                @if ($member->subscription_start)
                    <dt class="col-sm-3">Tanggal Aktif</dt>
                    <dd class="col-sm-9">{{ $member->subscription_start?->format('d M Y') }}</dd>
                @endif
                @if ($member->subscription_end)
                    <dt class="col-sm-3">Tanggal Expired</dt>
                    <dd class="col-sm-9">{{ $member->subscription_end?->format('d M Y') }}</dd>
                @endif
            </dl>
        </div>
    </div>

    {{-- Riwayat Baca Terakhir --}}
    <div class="card stat-card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-history me-2"></i>Baru Saja Dibaca</h5>
            <a href="{{ route('member.history') }}" class="btn btn-sm btn-outline-danger">Lihat Semua</a>
        </div>
        <div class="card-body">
            @if ($readingHistories->isEmpty())
                <p class="text-muted mb-0">Belum ada riwayat baca.</p>
            @else
                <ul class="list-group">
                    @foreach ($readingHistories as $history)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ route('web.show', $history->post->slug) }}">
                                {{ Str::limit($history->post->judul, 60) }}
                            </a>
                            <small class="text-muted">{{ $history->read_at?->diffForHumans() }}</small>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection
