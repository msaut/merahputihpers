@extends('layouts.web')

@section('content')
<style>
.square-img {
    width: 100%;
    aspect-ratio: 1 / 1;
    object-fit: cover;
    display: block;
}

@supports not (aspect-ratio: 1/1) {
    .square-img {
        width: 100%;
        height: 0;
        padding-bottom: 100%;
        object-fit: cover;
    }
    .square-img[style] { 
        padding-bottom: 100%;
    }
}

.single-what-news {
    border-radius: 8px;
    overflow: visible; 
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    padding: 0;
    max-width: 340px;
    margin: 0 auto;
    display: flex;
    flex-direction: column; 
}


.single-what-news .what-img {
    width: 100%;
    aspect-ratio: 1 / 1;   
    overflow: hidden;
    flex: 0 0 auto;
}
.single-what-news .what-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.single-what-news .what-cap:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.10);
    z-index: 3;
    cursor: pointer;
}

.news-meta { font-size: 0.82rem; margin-top: .5rem; }

.section-tittle h3 {
    display: inline-block;
    padding: 0.4rem 1rem;
    background: rgba(253, 13, 13, 1);
    border-radius: 3px;
    color: white;
    font-size: 1rem;
}
</style>
    
<main>
<section class="whats-news-area pt-50 pb-20">
    <div class="container">
        <!-- Section Title -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="section-tittle mb-30">
                    <h3>{{ $kategori->nama }}</h3>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="whats-news-caption">
                            <div class="row">
                                @if($berita->count())
                                    @foreach ($berita as $item)
                                        <div class="col-lg-4 col-md-6 mb-4">
                                            <div class="single-what-news" style="margin-top: 3rem; margin-bottom: 0; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                                                <div class="what-img">
                                                    <img
                                                        class="square-img"
                                                        src="{{ $item->gambar_base64 ? $item->gambar_base64 : ( $item->gambar ? asset('storage/' . $item->gambar) : 'https://via.placeholder.com/800x800?text=No+Image' ) }}"
                                                        alt="{{ $item->judul }}"
                                                        loading="lazy"
                                                    >
                                                </div>
                                                <div class="what-cap" style="background-color: #ffffff6b; backdrop-filter: blur(2px);">
                                                    <span class="color1" style="margin-left: 1rem;">{{ $item->kategori->nama }}</span>
                                                    <h4 style="margin-left: 1rem">
                                                        <a href="{{ route('web.show', $item->slug) }}">
                                                            {{ Str::limit($item->judul, 80) }}
                                                        </a>
                                                    </h4>
                                                    <div class="news-meta text-muted small">
                                                        <span><i class="far fa-user"></i> {{ $item->user->name ?? 'Admin' }}</span>
                                                        <span class="ms-3"><i class="far fa-calendar-alt"></i> {{ $item->created_at->format('d M Y') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12">
                                        <div class="alert alert-info text-center">Tidak ada berita pada kategori ini.</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Nav Card -->
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4 mb-5 w-100">
            {{ $berita->links('pagination::bootstrap-5') }}
        </div>
    </div>
</section>
</main>
@endsection
