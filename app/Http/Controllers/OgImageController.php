<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class OgImageController extends Controller
{
    // /**
    //  * Dinamically serve an image from database Base64 with proper headers.
    //  * Route: GET /og-image/{id}
    //  * 
    //  * This is used as fallback when the stored image file doesn't exist,
    //  * so Facebook/WhatsApp can still crawl the Base64 image via a real HTTP URL.
    //  */
    public function show($id)
    {
        $berita = Berita::findOrFail($id);

        // Priority: stored file -> gambar_base64 -> fallback logo
        $imageData = null;
        $mime = 'image/png';

        // 1. Try stored file (gambar column = filename in storage)
        if ($berita->gambar && file_exists(storage_path('app/public/berita/' . $berita->gambar))) {
            $path = storage_path('app/public/berita/' . $berita->gambar);
            $imageData = file_get_contents($path);
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $path);
            finfo_close($finfo);
        }
        // 2. Try gambar_base64 (decode from database)
        elseif ($berita->gambar_base64) {
            $decoded = $this->decodeBase64Image($berita->gambar_base64, $detectedMime);
            if ($decoded) {
                $imageData = $decoded;
                $mime = $detectedMime ?: 'image/png';
            }
        }
        // 3. Fallback to logo
        if (!$imageData) {
            $logoPath = public_path('assets/img/logo/logo.png');
            if (file_exists($logoPath)) {
                $imageData = file_get_contents($logoPath);
                $mime = 'image/png';
            }
        }

        if (!$imageData) {
            abort(404);
        }

        // Cache for 1 hour (Facebook/WhatsApp crawlers respect this)
        return response($imageData, 200)
            ->header('Content-Type', $mime)
            ->header('Content-Length', strlen($imageData))
            ->header('Cache-Control', 'public, max-age=3600')
            ->header('Pragma', 'public')
            ->header('Expires', gmdate('D, d M Y H:i:s', time() + 3600) . ' GMT');
    }

    /**
     * Decode a Base64 image string (with or without data URI prefix)
     */
    private function decodeBase64Image(string $data, ?string &$mime = null): ?string
    {
        $mime = null;

        // With prefix: data:image/png;base64,XXXX
        if (preg_match('/^data:(image\/(png|jpeg|jpg|gif|webp));base64,(.+)$/i', $data, $matches)) {
            $mime = strtolower($matches[1]);
            $raw = $matches[3];
        } else {
            $raw = $data;
        }

        $decoded = base64_decode($raw, true);
        if ($decoded === false) {
            return null;
        }

        // Detect MIME from binary if not already set
        if (!$mime) {
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $detected = $finfo->buffer($decoded);
            $mime = $detected ?: 'image/png';
        }

        return $decoded;
    }
}
