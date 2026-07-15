<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use App\Support\Base64Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show($slug)
    {
        $berita = Berita::where('slug', $slug)->first();
        if (!$berita) {
            abort(404);
        }

        $berita->increment('views');
        $komentars = $berita->komentars()->latest()->paginate(5);
        $kategori = $berita->kategori;
        $trending = Berita::orderBy('views', 'desc')->take(5)->get();
        $latest = Berita::latest()->take(5)->get();
        $kategoris = Kategori::withCount('beritas')->orderBy('beritas_count', 'desc')->take(5)->get();

        return view('web.show', compact('berita', 'komentars', 'kategori', 'trending', 'latest', 'kategoris'));
    }

    public function index()
    {
        $query = Berita::query();

        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        $berita = $query->latest()->paginate(10);

        return view('admin.berita.index', compact('berita'));
    }


    public function create()
    {
        $kategori = Kategori::all();
        return view('admin.berita.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $gambarName = null;
        $gambarBase64 = null;

        if ($request->file('gambar')) {
            $gambarName = $request->file('gambar')->getClientOriginalName();

            $tmp = $request->file('gambar')->getRealPath();
            if ($tmp) {
                $gambarBase64 = Base64Image::fileToBase64($tmp, true);
            }
        }

        Berita::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'isi' => $request->isi,
            'kategori_id' => $request->kategori_id,
            'user_id' => Auth::id(),
            'gambar' => $gambarName,
            'gambar_base64' => $gambarBase64,
        ]);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = Kategori::all();
        $berita = Berita::findOrFail($id);
        return view('admin.berita.edit', compact('berita', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $berita = Berita::findOrFail($id);

        $gambarName = $berita->gambar;
        $gambarBase64 = $berita->gambar_base64;

        if ($request->file('gambar')) {
            $gambarName = $request->file('gambar')->getClientOriginalName();

            $tmp = $request->file('gambar')->getRealPath();
            if ($tmp) {
                $gambarBase64 = Base64Image::fileToBase64($tmp, true);
            }
        }

        $berita->update([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'isi' => $request->isi,
            'kategori_id' => $request->kategori_id,
            'gambar' => $gambarName,
            'gambar_base64' => $gambarBase64,
        ]);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil diupdate.');
    }

    public function destroy(Berita $berita)
    {
        if (Auth::user()->role !== 'admin' && Auth::id() !== $berita->user_id) {
            abort(403);
        }

        $berita->delete();

        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus.');
    }
}

