@extends('member.layouts.member')

@section('title', 'Favorit Saya')

@section('content')
    <h3 class="mb-4"><i class="fas fa-heart me-2"></i>Berita Favorit</h3>

    @if ($likes->isEmpty())
        <div class="alert alert-info">Belum ada berita favorit.</div>
    @else
        <div class="list-group">
            @foreach ($likes as $berita)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('web.show', $berita->slug) }}" class="fw-bold">
                            {{ Str::limit($berita->judul, 80) }}
                        </a>
                        <div class="text-muted small">{{ $berita->created_at->format('d M Y') }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $likes->links() }}
        </div>
    @endif
@endsection
