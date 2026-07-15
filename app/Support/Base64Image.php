<?php

namespace App\Support;

class Base64Image
{
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

        $mime = self::mimeType($absolutePath);
        $b64 = base64_encode($bytes);

        return $dataUri
            ? "data:{$mime};base64,{$b64}"
            : $b64;
    }

    private static function mimeType(string $absolutePath): string
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($absolutePath);
        return $mime ?: 'application/octet-stream';
    }
}

