@extends('member.layouts.member')

@section('title', 'Komentar Saya')

@section('content')
    <h3 class="mb-4"><i class="fas fa-comments me-2"></i>Komentar Saya</h3>

    @if ($comments->isEmpty())
        <div class="alert alert-info">Belum ada komentar.</div>
    @else
        <div class="list-group">
            @foreach ($comments as $comment)
                <div class="list-group-item">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('web.show', $comment->post->slug) }}" class="fw-bold">
                            {{ Str::limit($comment->post->judul, 80) }}
                        </a>
                        <form method="POST" action="{{ route('member.comments.destroy', $comment->id) }}"
                            onsubmit="return confirm('Hapus komentar ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </div>
                    <p class="mb-1 mt-2">{{ $comment->isi }}</p>
                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $comments->links() }}
        </div>
    @endif
@endsection
