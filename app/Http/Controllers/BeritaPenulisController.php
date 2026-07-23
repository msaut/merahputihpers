<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use App\Support\Base64Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Store a new berita with image handling.
     * Saves uploaded file to storage/app/public/berita/ for OG/Facebook/WhatsApp crawlability.
     * Base64 is also stored in DB as fallback for dynamic OG image route.
     */
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
            $uploadedFile = $request->file('gambar');
            $filename = time() . '_' . Str::random(16) . '.' . $uploadedFile->getClientOriginalExtension();
            $uploadedFile->storeAs('public/berita', $filename);
            $gambarName = $filename;

            $tmp = $uploadedFile->getRealPath();
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
            $uploadedFile = $request->file('gambar');
            $filename = time() . '_' . Str::random(16) . '.' . $uploadedFile->getClientOriginalExtension();
            $uploadedFile->storeAs('public/berita', $filename);
            $gambarName = $filename;

            // Delete old file
            if ($berita->gambar && Storage::disk('public')->exists('berita/' . $berita->gambar)) {
                Storage::disk('public')->delete('berita/' . $berita->gambar);
            }

            $tmp = $uploadedFile->getRealPath();
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

        // Delete stored image file
        if ($berita->gambar && Storage::disk('public')->exists('berita/' . $berita->gambar)) {
            Storage::disk('public')->delete('berita/' . $berita->gambar);
        }

        $berita->delete();
        return redirect()->route('penulis.berita.index')->with('success', 'Berita dihapus.');
    }
}
