@extends('layouts.web')

@section('title', $berita->judul . ' | merahputihpers.com')

@section('og_meta')
@php
    $ogImage = $berita->gambar
        ? asset('storage/berita/' . $berita->gambar)
        : asset('assets/img/logo/logo.png');

    $desc = Str::limit(strip_tags($berita->isi), 160);
@endphp

<meta property="og:title" content="{{ $berita->judul }}" />
<meta property="og:description" content="{{ $desc }}" />
<meta property="og:image" content="{{ $ogImage }}" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:type" content="article" />

<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:image" content="{{ $ogImage }}" />
@endsection

@section('content')
@php
    $cleanDesc = Str::limit(strip_tags($berita->isi), 300);
    $displayImage = $berita->gambar_base64 
        ? $berita->gambar_base64 
        : ($berita->gambar 
            ? asset('storage/berita/' . $berita->gambar) 
            : asset('assets/img/logo/logo.png'));
@endphp
<style>
    .article-content {
    font-size: 18px;
    line-height: 1.8;
    color: #222;
}

.article-content img {
    max-width: 100%;
    border-radius: 10px;
    margin: 20px 0;
}
</style>
<div class="container mt-10">
    <p class="text-danger mt-10">{{ $berita->kategori ? $berita->kategori->nama : '-' }}</p>
    <h1>{{ $berita->judul }}</h1>
    <p><i class="fas fa-eye"></i> {{ $berita->views }} x dibaca</p>
    
    <img 
        src="{{ $displayImage }}" 
        alt="{{ $berita->judul }}" 
        loading="lazy"
        style="
            width:100%;
            max-width:800px;
            height:400px;
            object-fit:cover;
            border-radius:10px;
            display:block;
            margin:20px auto;
        "
    >    
    {{-- Share Buttons --}}
    @include('web.partials.share-buttons', [
        'url' => url()->current(),
        'plainUrl' => url()->current(),
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
            <input type="text" name="nama" class="form-control mb-2" placeholder="Nama" required>
            <textarea name="isi" class="form-control mb-2" rows="3" placeholder="Komentar" required></textarea>
            <button class="btn btn-danger">Kirim</button>
        </form>
    </div>
</div>

    {{-- Daftar Komentar --}}
   @if($komentars->isEmpty())
    <p class="text-muted">Belum ada komentar.</p>
@else
<div class="card mb-4">
    <div class="card-header">
        <h3>Daftar Komentar</h3>
    </div>
    <div class="card-body">

        @foreach($komentars as $komentar)
            <div class="mb-3 border-bottom pb-2">
                <strong>{{ $komentar->nama }}</strong><br>
                <small class="text-muted">{{ $komentar->created_at->format('d M Y H:i') }}</small>
                <p>{{ $komentar->isi }}</p>
            </div>
        @endforeach

        <div class="text-center">
            {{ $komentars->links() }}
        </div>

    </div>
</div>
@endif
</div>
@endsection
