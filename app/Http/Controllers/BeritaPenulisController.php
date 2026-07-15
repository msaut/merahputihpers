<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Support\Base64Image;


class BeritaPenulisController extends Controller
{
    public function index()
    {
        $berita = Berita::where('user_id', Auth::id())->latest()->get();
        return view('penulis.berita.index', compact('berita'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('penulis.berita.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'gambar' => 'nullable|image|max:2048'
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


        return redirect()->route('penulis.berita.index')->with('success', 'Berita ditambahkan.');
    }

    public function edit(Berita $berita)
    {
        if ($berita->user_id !== Auth::id()) abort(403);
        $kategori = Kategori::all();
        return view('penulis.berita.edit', compact('berita', 'kategori'));
    }

    public function update(Request $request, Berita $berita)
    {
        if ($berita->user_id !== Auth::id()) abort(403);

        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required',
            'kategori_id' => 'required',
            'gambar' => 'nullable|image|max:2048'
        ]);


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
            'isi' => $request->isi,
            'kategori_id' => $request->kategori_id,
            'gambar' => $gambarName,
            'gambar_base64' => $gambarBase64,

        ]);



        return redirect()->route('penulis.berita.index')->with('success', 'Berita diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        if ($berita->user_id !== Auth::id()) abort(403);
        $berita->delete();
        return redirect()->route('penulis.berita.index')->with('success', 'Berita dihapus.');
    }
}