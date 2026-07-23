@extends('layouts.web')

@section('title', $berita->judul . ' | merahputihpers.com')

@section('og_meta')
@php
    // Resolusi URL Gambar absolut untuk OG Meta (WhatsApp, Facebook, Twitter)
    if ($berita->gambar) {
        $imgPath = Str::startsWith($berita->gambar, 'berita/') 
            ? $berita->gambar 
            : 'berita/' . $berita->gambar;
        $ogImage = asset('storage/' . $imgPath);
    } else {
        $ogImage = asset('assets/img/logo/logo.png');
    }

    // Clean description 300 karakter tanpa tag HTML & tanpa ekstra newline
    $rawText = strip_tags(html_entity_decode($berita->isi));
    $cleanText = trim(preg_replace('/\s+/', ' ', $rawText));
    $desc = Str::limit($cleanText, 300);

    // Judul & Meta info
    $ogTitle = $berita->judul;
    $publishTime = $berita->published_at
        ? $berita->published_at->toIso8601String()
        : $berita->created_at->toIso8601String();
    $kategoriNama = $berita->kategori->nama ?? 'Berita';
@endphp

<meta name="description" content="{{ $desc }}" />

{{-- Open Graph Meta (Facebook, WhatsApp, Telegram, Line) --}}
<meta property="og:type" content="article" />
<meta property="og:site_name" content="MerahPutihPers" />
<meta property="og:locale" content="id_ID" />
<meta property="og:title" content="{{ $ogTitle }}" />
<meta property="og:description" content="{{ $desc }}" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:image" content="{{ $ogImage }}" />
<meta property="og:image:secure_url" content="{{ $ogImage }}" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<meta property="og:image:alt" content="{{ $berita->judul }}" />

{{-- Metadata Artikel --}}
<meta property="article:published_time" content="{{ $publishTime }}" />
<meta property="article:section" content="{{ $kategoriNama }}" />

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ $ogTitle }}" />
<meta name="twitter:description" content="{{ $desc }}" />
<meta name="twitter:image" content="{{ $ogImage }}" />
<meta name="twitter:image:alt" content="{{ $berita->judul }}" />
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
    height: auto;
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
            height:auto;
            max-height:500px;
            object-fit:contain;
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
