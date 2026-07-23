<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Base64Image
{
    /**
     * Convert a file on disk to a Base64 data URI string.
     */
    public static function fileToBase64(
        string $absolutePath,
        bool $dataUri = true
    ): ?string {
        if (!is_file($absolutePath) || !is_readable($absolutePath)) {
            return null;
        }

        $bytes = file_get_contents($absolutePath);
        if ($bytes === false) {
            return null;
        }

        $mime = self::detectMimeFromPath($absolutePath);
        $b64 = base64_encode($bytes);

        return $dataUri
            ? "data:{$mime};base64,{$b64}"
            : $b64;
    }

    // /**
    //  * Decode a Base64 image string and save as a file to storage.
    //  *
    //  * @param string|null $base64String  Raw Base64 string (with or without data URI prefix)
    //  * @param string      $storagePath   Relative path inside storage/app/public (e.g. 'berita')
    //  * @return array
    //  */
    public static function base64ToFile(?string $base64String, string $storagePath = 'berita'): array
    {
        $result = [
            'filename' => null,
            'url'      => null,
            'mime'     => null,
        ];

        if (empty($base64String)) {
            return $result;
        }

        // Strip data URI prefix: "data:image/png;base64,XXXX" -> "XXXX"
        $decoded = self::stripDataUriPrefix($base64String, $mime);

        if ($decoded === false || empty($decoded)) {
            return $result;
        }

        // Decode from base64
        $binaryData = base64_decode($decoded, true);
        if ($binaryData === false) {
            return $result;
        }

        // Detect extension
        $extension = self::mimeToExtension($mime);
        if (!$extension) {
            $extension = self::detectExtensionFromBinary($binaryData) ?? 'png';
        }

        // Generate unique filename: timestamp_random.extension
        $filename = time() . '_' . Str::random(16) . '.' . $extension;

        // Save to storage/app/public/{storagePath}/
        Storage::disk('public')->put($storagePath . '/' . $filename, $binaryData);

        $result['filename'] = $filename;
        $result['url']      = Storage::url($storagePath . '/' . $filename);
        $result['mime']     = $mime ?: 'image/png';

        return $result;
    }

    // /**
    //  * Strip "data:image/png;base64," prefix and return raw base64 + mime type
    //  */
    private static function stripDataUriPrefix(string $data, ?string &$mime = null): string|false
    {
        $mime = null;

        // Pattern: data:image/png;base64,<actual base64>
        if (preg_match('/^data:(image\/(png|jpeg|jpg|gif|webp));base64,(.+)$/i', $data, $matches)) {
            $mime = strtolower($matches[1]);
            return $matches[3];
        }

        // No prefix — treat as raw base64
        if (preg_match('/^[A-Za-z0-9+\/=]+$/', $data)) {
            $decoded = base64_decode($data, true);
            if ($decoded !== false) {
                $mime = self::detectMimeFromBinary($decoded) ?? 'image/png';
            } else {
                $mime = 'image/png';
            }
            return $data;
        }

        return false;
    }

    // /**
    //  * Validate that a string is a valid Base64 image
    //  */
    public static function isValidBase64Image(?string $data): bool
    {
        if (empty($data)) {
            return false;
        }

        // Check data URI prefix
        if (preg_match('/^data:image\/(png|jpeg|jpg|gif|webp);base64,(.+)$/i', $data, $matches)) {
            $raw = $matches[2];
        } else {
            $raw = $data;
        }

        // Basic Base64 check
        if (!preg_match('/^[A-Za-z0-9+\/=]+$/', $raw)) {
            return false;
        }

        // Try decoding
        $decoded = base64_decode($raw, true);
        if ($decoded === false) {
            return false;
        }

        // Check that it's actually an image
        $info = @getimagesizefromstring($decoded);
        if ($info === false) {
            return false;
        }

        return true;
    }

    // /**
    //  * Map MIME type to file extension
    //  */
    private static function mimeToExtension(?string $mime): ?string
    {
        $map = [
            'image/png'  => 'png',
            'image/jpeg' => 'jpg',
            'image/jpg'  => 'jpg',
            'image/gif'  => 'gif',
            'image/webp' => 'webp',
        ];

        return $map[strtolower($mime ?? '')] ?? null;
    }

    // /**
    //  * Detect MIME type from file path
    //  */
    private static function detectMimeFromPath(string $path): string
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($path);
        return $mime ?: 'application/octet-stream';
    }

    // /**
    //  * Detect MIME type from binary image data
    //  */
    private static function detectMimeFromBinary(string $binaryData): ?string
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->buffer($binaryData);
        return $mime ?: null;
    }

    // /**
    //  * Detect extension from binary signature (without MIME)
    //  */
    private static function detectExtensionFromBinary(string $binaryData): ?string
    {
        if (str_starts_with($binaryData, "\x89\x50\x4E\x47")) {
            return 'png';
        }
        if (str_starts_with($binaryData, "\xFF\xD8\xFF")) {
            return 'jpg';
        }
        if (str_starts_with($binaryData, "GIF87a") || str_starts_with($binaryData, "GIF89a")) {
            return 'gif';
        }
        if (str_starts_with($binaryData, "RIFF") && str_contains(substr($binaryData, 8, 4), "WEBP")) {
            return 'webp';
        }
        return null;
    }

    // /**
    //  * Get full public URL for a stored image
    //  */
    public static function getImageUrl(?string $filename, string $storagePath = 'berita'): ?string
    {
        if (empty($filename)) {
            return null;
        }

        $path = $storagePath . '/' . $filename;
        if (!Storage::disk('public')->exists($path)) {
            return null;
        }

        return Storage::url($path);
    }
}
