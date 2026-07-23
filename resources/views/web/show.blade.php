<title>{{ $berita->judul }} | merahputihpers.com</title>
@extends('layouts.web')

@section('og_meta')
    <meta property="og:title" content="{{ $berita->judul }}" />
    <meta property="og:description" content="{{ Str::limit(strip_tags($berita->isi), 300) }}" />
    @php
        // Gunakan gambar asli (storage), bukan base64 agar Facebook/WhatsApp bisa crawl
        $ogImage = $berita->gambar 
            ? asset('storage/' . $berita->gambar)
            : ($berita->gambar_base64 
                ? url($berita->gambar_base64) 
                : asset('assets/img/logo/logo.png'));
    @endphp
    <meta property="og:image" content="{{ $ogImage }}" />
    <meta property="og:image:width" content="800" />
    <meta property="og:image:height" content="450" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="MerahPutihPers" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $berita->judul }}" />
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($berita->isi), 300) }}" />
    <meta name="twitter:image" content="{{ $ogImage }}" />
@endsection

@section('content')
@php
    $cleanDesc = Str::limit(strip_tags($berita->isi), 300);
@endphp
<div class="container mt-10">
    <p class="text-danger mt-10">{{ $berita->kategori ? $berita->kategori->nama : '-' }}</p>
    <h1 class="">{{ $berita->judul }}</h1>
    <p><i class="fas fa-eye"></i> {{ $berita->views }} x dibaca</p>
    <img src="{{ $berita->gambar_base64 ? $berita->gambar_base64 : asset('storage/' . $berita->gambar) }}" alt="" loading="lazy" style="width: 100%; max-width: 800px; height: 320px; object-fit: contain; border-radius: 8px; display:block; margin: 0 auto; background: #f7f7f7;">
    
    {{-- Share Buttons --}}
    @include('web.partials.share-buttons', [
        'url' => url()->current(),
        'title' => $berita->judul,
        'description' => $cleanDesc,
        'image' => $ogImage,
    ])
    
    <div class="article-content">
        {!! $berita->isi !!}
    </div>
    <p class="mt-3">Kategori: <span class="badge bg-danger">{{ $berita->kategori ? $berita->kategori->nama : '-' }}</span></p>
    
    {{-- Komentar Form --}}
    <div class="card mb-4 mt-5">
        <div class="card-header">
            <h3>Tulis Komentar</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('komentar.store', $berita->id) }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" class="form-control" placeholder="Tulis Nama" required>
                </div>
                <div class="form-group mb-3">
                    <label for="isi">Komentar</label>
                    <textarea name="isi" class="form-control" rows="3" placeholder="Tulis komentar" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Kirim</button>
            </form>
        </div>

    {{-- Daftar Komentar --}}
    @if($berita->komentars->isEmpty())
        <p class="text-muted">Belum ada komentar.</p>
    @else
        <div class="card mb-4">
            <div class="card-header">
                <h3>Daftar Komentar</h3>
            </div>
            <div class="card-body">
                @foreach($berita->komentars as $komentar)
                    <div class="media mb-3 border-bottom pb-3">
                        <div class="media-body">
                            <h5 class="mt-0">{{ $komentar->nama }}</h5>
                            <small class="text-muted">{{ $komentar->created_at->format('d M Y H:i') }}</small>
                            <p class="mt-2">{{ $komentar->isi }}</p>
                        </div>
                @endforeach
                <div class="d-flex justify-content-center mt-3">
                    {{ $komentars->links('pagination::bootstrap-4') }}
                </div>
    @endif
</div>
@endsection
