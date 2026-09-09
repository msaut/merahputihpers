@props(['position'])

@php
    $banners = \App\Models\Banner::active()
        ->where('posisi', $position)
        ->orderBy('urutan')
        ->orderBy('created_at', 'desc')
        ->get();
@endphp

@if ($banners->count())
    <div class="banner-wrapper mb-4" style="width:100%; overflow:hidden;">
        @foreach ($banners as $banner)
            <div class="text-center mb-3" style="width:100%;">
                <a href="{{ route('banner.click', $banner->id) }}"
                   target="{{ $banner->target === '_blank' ? '_blank' : '_self' }}"
                   rel="{{ $banner->target === '_blank' ? 'noopener noreferrer' : '' }}"
                   class="d-inline-block"
                   style="max-width:100%; display:inline-block; text-decoration:none;">
                    <img src="{{ asset('storage/' . $banner->gambar) }}"
                         alt="{{ $banner->alt_text ?? $banner->judul }}"
                         loading="lazy"
                         style="max-width:100%; height:auto; display:block; border-radius:8px; box-shadow:0 4px 14px rgba(0,0,0,.08); aspect-ratio: {{ $banner->posisi === 'square' ? '1 / 1' : ($banner->posisi === 'sidebar' ? '300 / 250' : ($banner->posisi === 'mobile' ? '320 / 100' : ($banner->posisi === 'leaderboard' ? '728 / 90' : '970 / 250')) ) }};">
                </a>
            </div>
        @endforeach
    </div>
@endif
