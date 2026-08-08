<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KoranPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminKoranPdfController extends Controller
{
    // Daftar PDF
    public function index()
    {
        $pdfs = KoranPdf::latest()->paginate(15);
        return view('admin.koran.index', compact('pdfs'));
    }

    // Form upload PDF baru
    public function create()
    {
        return view('admin.koran.create');
    }

    // Simpan PDF
    public function store(Request $request)
    {
        $request->validate([
            'judul'    => ['required', 'string', 'max:255'],
            'tanggal'  => ['required', 'date'],
            'file'     => ['required', 'mimes:pdf', 'max:20480'],
            'is_active'=> ['nullable', 'boolean'],
        ]);

        $path = $request->file('file')->store('koran', 'public');

        KoranPdf::create([
            'judul'    => $request->judul,
            'tanggal'  => $request->tanggal,
            'file'     => $path,
            'is_active'=> $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.koran.index')->with('success', 'PDF koran berhasil diupload.');
    }

    // Hapus PDF
    public function destroy(KoranPdf $koran)
    {
        if ($koran->file && Storage::disk('public')->exists($koran->file)) {
            Storage::disk('public')->delete($koran->file);
        }
        $koran->delete();

        return back()->with('success', 'PDF berhasil dihapus.');
    }
}
