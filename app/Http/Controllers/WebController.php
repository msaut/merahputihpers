<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Berita;

class WebController extends Controller
{
    public function index()
    {
        $headline   = Berita::latest()->first();
        $trendingOne = Berita::orderBy('views', 'desc')->first();
        $trending   = Berita::orderBy('views', 'desc')->take(1)->get();
        $latest     = Berita::latest()->take(1)->get();
        $kategoris  = Kategori::withCount('beritas')->get();
        $berita     = Berita::latest()->paginate(4);

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
