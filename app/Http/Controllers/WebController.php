<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Berita;
use carbon\Carbon;

class WebController extends Controller
{
    public function index()
    {
        // $headline   = Berita::latest()->first();
        // $trendingOne = Berita::orderBy('views', 'desc')->first();
        // // tampilkan beberapa berita terpopuler
        // $trending   = Berita::orderBy('views', 'desc')->take(4)->get();
        // $latest     = Berita::latest()->take(1)->get();

        $kategoris  = Kategori::withCount('beritas')->get();
        // $berita     = Berita::latest()->paginate(4);
        $headline = Berita::where('status', 'published')
                ->where('publish_at', '<=', now())
                ->orwhereNull('publish_at')
                ->latest()
                ->first();

            $trendingOne = Berita::where('status', 'published')
                ->where('publish_at', '<=', now())
                ->orwhereNull('publish_at')
                ->orderBy('views', 'desc')
                ->first();

            $trending = Berita::where('status', 'published')
                ->where('publish_at', '<=', now())
                ->orwhereNull('publish_at')
                ->orderBy('views', 'desc')
                ->take(4)
                ->get();

            $latest = Berita::where('status', 'published')
                ->where('publish_at', '<=', now())
                ->orwhereNull('publish_at')
                ->latest()
                ->take(1)
                ->get();

            $berita = Berita::where('status', 'published')
                ->where('publish_at', '<=', now())
                ->orwhereNull('publish_at')
                ->latest()
                ->paginate(4);

        return view('web.home', compact(
            'berita',
            'headline',
            'trendingOne',
            'trending',
            'latest',
            'kategoris'
        ));
    }

    public function show($slug)
    {
        $berita = Berita::where('slug', $slug)->first();
        return view('web.show', compact('berita'));
    }

    public function kategori($id)
    {
        $berita = Berita::where('kategori_id', $id)->paginate(3);
        return view('web.kategori', compact('berita'));
    }
}
