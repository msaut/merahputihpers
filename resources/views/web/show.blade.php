<title>{{ $berita->judul }} | MENIT.COM</title>
@extends('layouts.web')
@section('content')
<div class="container mt-10">
    <p class="text-danger mt-10">{{ $berita->kategori ? $berita->kategori->nama : '-' }}</p>
    <h1 class="">{{ $berita->judul }}</h1>
    <p>{{ $berita->views }} x dibaca</p>
    <img src="{{ $berita->gambar_base64 ? $berita->gambar_base64 : asset('storage/' . $berita->gambar) }}" alt="" loading="lazy" style="width: 100%; max-width: 800px; height: 320px; object-fit: contain; border-radius: 8px; display:block; margin: 0 auto; background: #f7f7f7;">
    <p>{!! $berita->isi !!}</p>
    <p>Kategori: {{ $berita->kategori ? $berita->kategori->nama : '-' }}</p>
    
    <div class="card mb-4">
        <div class="card-header">
            <h3>Komentar</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('komentar.store', $berita->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" class="form-control" placeholder="Tulis Nama" required>
                </div>
                <div class="form-group">
                    <label for="isi">Komentar</label>
                    <textarea name="isi" class="form-control" rows="3" placeholder="Tulis komentar" required></textarea>
                </div>
                <button class="btn btn-primary">Kirim</button>
            </form>
        </div>
    </div>

    @if($berita->komentars->isEmpty())
        <p class="text-muted">Belum ada komentar.</p>
    @else
        <div class="card mb-4">
            <div class="card-header">
                <h3>Daftar Komentar</h3>
            </div>
            <div class="card-body">
                @foreach($berita->komentars as $komentar)
                    <div class="media mb-3">
                        <div class="media-body">
                            <h5 class="mt-0">{{ $komentar->nama }}</h5>
                            <small>{{ $komentar->created_at->format('d M Y H:i') }}</small>
                            <p>{{ $komentar->isi }}</p>
                        </div>
                    </div>
                @endforeach
                <div class="d-flex justify-content-center">
                    {{ $komentars->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection