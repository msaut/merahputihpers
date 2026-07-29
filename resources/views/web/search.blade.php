@extends('layouts.web')

@section('title', $query ? 'Hasil pencarian: ' . e($query) . ' | MerahPutihPers' : 'Pencarian Berita | MerahPutihPers')

@section('og_meta')
<meta name="description" content="{{ $query ? 'Hasil pencarian berita untuk kata kunci: ' . e($query) . ' di MerahPutihPers.' : 'Cari berita terkini, terpercaya, dan faktual di MerahPutihPers.' }}" />
<meta name="robots" content="noindex, follow" />
<meta property="og:title" content="{{ $query ? 'Hasil pencarian: ' . e($query) : 'Pencarian Berita' }} | MerahPutihPers" />
<meta property="og:description" content="{{ $query ? 'Hasil pencarian berita untuk: ' . e($query) : 'Cari berita terkini di MerahPutihPers.' }}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:site_name" content="MerahPutihPers" />
<meta name="twitter:card" content="summary" />
@endsection

@section('content')
<style>
.search-results-header {
    background: linear-gradient(135deg, #d90429 0%, #a50020 100%);
    padding: 40px 0 30px;
    margin-bottom: 0;
}
.search-results-header h1 {
    color: #fff;
    font-size: 1.6rem;
    font-weight: 700;
    margin-bottom: 5px;
}
.search-results-header p {
    color: rgba(255,255,255,0.85);
    font-size: 0.95rem;
    margin: 0;
}
.search-form-inline {
    display: flex;
    max-width: 550px;
    margin: 20px 0 0;
    border-radius: 30px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.25);
}
.search-form-inline input {
    flex: 1;
    border: none;
    padding: 12px 20px;
    font-size: 15px;
    outline: none;
}
.search-form-inline button {
    background: #111;
    color: #fff;
    border: none;
    padding: 12px 22px;
    cursor: pointer;
    font-size: 15px;
    transition: background 0.2s;
}
.search-form-inline button:hover { background: #333; }

.result-count {
    font-size: 0.92rem;
    color: #666;
    margin-bottom: 20px;
}

.news-card {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
    transition: transform 0.2s, box-shadow 0.2s;
    background: #fff;
    height: 100%;
    display: flex;
    flex-direction: column;
}
.news-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.13);
}
.news-card .card-img-wrapper {
    aspect-ratio: 16/9;
    overflow: hidden;
}
.news-card .card-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.3s;
}
.news-card:hover .card-img-wrapper img { transform: scale(1.05); }
.news-card .card-body {
    padding: 16px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.news-card .card-category {
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    color: #d90429;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}
.news-card .card-title a {
    color: #111;
    text-decoration: none;
    font-size: 1rem;
    font-weight: 700;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.news-card .card-title a:hover { color: #d90429; }
.news-card .card-meta {
    font-size: 0.78rem;
    color: #888;
    margin-top: auto;
    padding-top: 12px;
}
.no-result-area {
    text-align: center;
    padding: 60px 20px;
}
.no-result-area .icon { font-size: 4rem; color: #ddd; margin-bottom: 20px; }
.no-result-area h2 { font-size: 1.4rem; color: #555; }
.no-result-area p { color: #999; }
</style>

<div class="search-results-header">
    <div class="container">
        <h1>
            @if($query)
                Hasil pencarian: "<em>{{ $query }}</em>"
            @else
                Pencarian Berita
            @endif
        </h1>
        @if($query)
            <p>Ditemukan {{ $berita->total() }} berita</p>
        @endif
        <form action="{{ route('web.search') }}" method="GET" class="search-form-inline" role="search">
            <input type="search" name="q" value="{{ $query }}" placeholder="Cari berita lain..." aria-label="Cari berita">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>
</div>

<main>
<section class="pt-40 pb-60">
    <div class="container">

        @if($berita->count())
            <p class="result-count mt-3">
                Menampilkan {{ $berita->firstItem() }}–{{ $berita->lastItem() }} dari {{ $berita->total() }} hasil
                @if($query) untuk <strong>"{{ $query }}"</strong>@endif
            </p>

            <div class="row g-4" id="search-results-container">
                @foreach($berita as $item)
                    <article class="col-lg-4 col-md-6">
                        <div class="news-card">
                            <div class="card-img-wrapper">
                                <a href="{{ route('web.show', $item->slug) }}" tabindex="-1" aria-hidden="true">
                                    <img
                                        src="{{ $item->gambar_base64 ? $item->gambar_base64 : ($item->gambar ? asset('storage/berita/' . $item->gambar) : 'https://via.placeholder.com/800x450?text=No+Image') }}"
                                        alt="{{ $item->judul }}"
                                        loading="lazy"
                                    >
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="card-category">{{ $item->kategori->nama ?? 'Berita' }}</div>
                                <h2 class="card-title">
                                    <a href="{{ route('web.show', $item->slug) }}">
                                        {{ Str::limit($item->judul, 90) }}
                                    </a>
                                </h2>
                                <p class="card-text text-muted" style="font-size:0.875rem; margin-top:8px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                                    {{ Str::limit(strip_tags($item->isi), 120) }}
                                </p>
                                <div class="card-meta">
                                    <i class="far fa-user"></i> {{ $item->user->name ?? 'Admin' }}
                                    &nbsp;&bull;&nbsp;
                                    <i class="far fa-calendar-alt"></i> {{ $item->created_at->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $berita->links('pagination::bootstrap-5') }}
            </div>

        @elseif($query)
            <div class="no-result-area">
                <div class="icon"><i class="fas fa-search"></i></div>
                <h2>Tidak ada hasil untuk "<em>{{ $query }}</em>"</h2>
                <p>Coba gunakan kata kunci yang berbeda atau lebih umum.</p>
                <a href="{{ url('/') }}" class="btn btn-danger mt-3">Kembali ke Beranda</a>
            </div>
        @else
            <div class="no-result-area">
                <div class="icon"><i class="fas fa-search"></i></div>
                <h2>Masukkan kata kunci pencarian</h2>
                <p>Ketik kata kunci di kotak pencarian di atas untuk menemukan berita.</p>
            </div>
        @endif

    </div>
</section>
</main>
@endsection
