<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Kategori;
use App\Support\Base64Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
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

    public function index(Request $request)
    {
        $query = Berita::query();

        $status = $request->query('status');
        $kategoriId = $request->query('kategori');
        $penulisId = $request->query('penulis');

        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        } else {
            if (!empty($penulisId)) {
                $query->where('user_id', $penulisId);
            }

            if (!empty($kategoriId)) {
                $query->where('kategori_id', $kategoriId);
            }

            if (!empty($status)) {
                $query->where('status', $status);
            }
        }

        $berita = $query
            ->with(['user', 'kategori'])
            ->latest()
            ->paginate(10)
            ->appends([
                'penulis' => $penulisId,
                'kategori' => $kategoriId,
                'status' => $status,
            ]);

        $kategoris = Kategori::all(['id', 'nama']);
        $penulis = \App\Models\User::all(['id', 'name']);

        return view('admin.berita.index', compact('berita', 'kategoris', 'penulis'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('admin.berita.create', compact('kategori'));
    }

    /**
     * Store a new berita with image handling.
     * Saves uploaded file to storage/app/public/berita/ for better OG/Facebook/WhatsApp crawlability.
     * Base64 is also stored in DB as fallback for dynamic OG image route.
     */
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
            $uploadedFile = $request->file('gambar');
            $filename = time() . '_' . Str::random(16) . '.' . $uploadedFile->getClientOriginalExtension();
            $uploadedFile->storeAs('public/berita', $filename);
            $gambarName = $filename;

            $tmp = $uploadedFile->getRealPath();
            if ($tmp) {
                $gambarBase64 = Base64Image::fileToBase64($tmp, true);
            }
        }

        $status = $request->input('status', 'draft');
        $publishAt = $request->input('publish_at');

        if ($status === 'published' && empty($publishAt)) {
            $publishAt = now();
        }

        $publishedAt = null;
        if ($status === 'published') {
            $publishedAt = now();
        }

        Berita::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'isi' => $request->isi,
            'kategori_id' => $request->kategori_id,
            'user_id' => Auth::id(),
            'gambar' => $gambarName,
            'gambar_base64' => $gambarBase64,
            'status' => $status,
            'publish_at' => $publishAt,
            'published_at' => $publishedAt,
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

        $status = $request->input('status', 'draft');
        $publishAt = $request->input('publish_at');

        $publishedAt = null;
        if ($status === 'published') {
            $publishedAt = now();
        }

        $berita->update([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul),
            'isi' => $request->isi,
            'kategori_id' => $request->kategori_id,
            'gambar' => $gambarName,
            'gambar_base64' => $gambarBase64,
            'status' => $status,
            'publish_at' => $publishAt,
            'published_at' => $publishedAt,
        ]);

        return redirect()->route('berita.index')->with('success', 'Berita berhasil diupdate.');
    }

    public function destroy(Berita $berita)
    {
        if (Auth::user()->role !== 'admin' && Auth::id() !== $berita->user_id) {
            abort(403);
        }

        // Delete stored image file
        if ($berita->gambar && Storage::disk('public')->exists('berita/' . $berita->gambar)) {
            Storage::disk('public')->delete('berita/' . $berita->gambar);
        }

        $berita->delete();

        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus.');
    }
}
