@extends('member.layouts.member')

@section('title', 'Riwayat Baca')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Baca</h3>
        @if (!$histories->isEmpty())
            <form method="POST" action="{{ route('member.history.clear') }}"
                onsubmit="return confirm('Hapus semua riwayat baca?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger btn-sm">Bersihkan Riwayat</button>
            </form>
        @endif
    </div>

    @if ($histories->isEmpty())
        <div class="alert alert-info">Belum ada riwayat baca.</div>
    @else
        <div class="list-group">
            @foreach ($histories as $history)
                <div class="list-group-item">
                    <a href="{{ route('web.show', $history->post->slug) }}" class="fw-bold">
                        {{ Str::limit($history->post->judul, 100) }}
                    </a>
                    <div class="text-muted small">
                        Dibaca {{ $history->read_at?->diffForHumans() }}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $histories->links() }}
        </div>
    @endif
@endsection
