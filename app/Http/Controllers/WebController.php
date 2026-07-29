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
        $berita = Berita::with(['kategori', 'user', 'komentars'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views
        $berita->increment('views');

        $komentars = $berita->komentars()->latest()->paginate(10);

        return view('web.show', compact('berita', 'komentars'));
    }

    public function kategori($id)
    {
        $berita = Berita::where('kategori_id', $id)->paginate(3);
        return view('web.kategori', compact('berita'));
    }

    public function search(Request $request)
    {
        $query = trim($request->input('q'));

        $berita = Berita::query()
            ->when($query, function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('judul', 'like', "%{$query}%")
                        ->orWhere('isi', 'like', "%{$query}%");
                });
            })
            ->where('status', 'published')
            ->where(function ($q) {
                $q->where('publish_at', '<=', now())
                  ->orWhereNull('publish_at');
            })
            ->with(['kategori', 'user'])
            ->latest()
            ->paginate(9)
            ->appends(['q' => $query]);

        return view('web.search', compact('berita', 'query'));
    }
}
