<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\KoranPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KoranController extends Controller
{
    // Daftar koran digital (hanya untuk member aktif - middleware member.active)
    public function index()
    {
        $member = Auth::guard('member')->user();
        $pdfs = KoranPdf::where('is_active', true)
            ->orderByDesc('tanggal')
            ->get();

        return view('member.koran.index', compact('member', 'pdfs'));
    }

    // Download / lihat file PDF (hanya member aktif)
    public function show(KoranPdf $koran)
    {
        $member = Auth::guard('member')->user();

        if (!$member->isActive()) {
            return redirect()->route('member.subscriptions.index')
                ->with('error', 'Langganan Anda tidak aktif. Silakan perpanjang untuk mengakses koran.');
        }

        if (!Storage::disk('public')->exists($koran->file)) {
            abort(404, 'File PDF tidak ditemukan.');
        }

        return Storage::disk('public')->response($koran->file);
    }

    // Download dengan attachment
    public function download(KoranPdf $koran)
    {
        $member = Auth::guard('member')->user();

        if (!$member->isActive()) {
            return redirect()->route('member.subscriptions.index')
                ->with('error', 'Langganan Anda tidak aktif. Silakan perpanjang untuk mengakses koran.');
        }

        if (!Storage::disk('public')->exists($koran->file)) {
            abort(404, 'File PDF tidak ditemukan.');
        }

        $filename = Str::slug($koran->judul) . '.pdf';

        return Storage::disk('public')->download($koran->file, $filename);
    }
}
