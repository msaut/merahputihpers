@foreach ($berita as $item)
    <div class="col-lg-6 col-md-6">
        <div class="single-what-news mb-100">
            <div class="what-img">
                <img class="square-img" src="{{ asset('storage/berita/' . basename($item->gambar)) }}" alt="">
            </div>
            <div class="what-cap">
                <span class="color1">{{ $item->kategori->nama }}</span>
                <h4><a href="{{ route('web.show', $item->slug) }}">{{ $item->judul }}</a></h4>
            </div>
        </div>
    </div>
@endforeach

