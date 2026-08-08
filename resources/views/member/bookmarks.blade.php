@extends('member.layouts.member')

@section('title', 'Bookmark Saya')

@section('content')
    <h3 class="mb-4"><i class="fas fa-bookmark me-2"></i>Bookmark Berita</h3>

    @if ($bookmarks->isEmpty())
        <div class="alert alert-info">Belum ada berita yang disimpan.</div>
    @else
        <div class="list-group">
            @foreach ($bookmarks as $berita)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('web.show', $berita->slug) }}" class="fw-bold">
                            {{ Str::limit($berita->judul, 80) }}
                        </a>
                        <div class="text-muted small">
                            {{ $berita->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $bookmarks->links() }}
        </div>
    @endif
@endsection
