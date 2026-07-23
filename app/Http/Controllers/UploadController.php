<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * Handle Summernote image upload via AJAX.
     * Saves image to storage/app/public/summernote/
     * Returns JSON with URL for Summernote to insert into editor.
     */
    public function summernoteImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // max 5MB
        ]);

        $file = $request->file('image');
        $filename = 'summernote_' . time() . '_' . Str::random(12) . '.' . $file->getClientOriginalExtension();
        
        // Store to public disk under summernote directory
        $file->storeAs('summernote', $filename, 'public');
        
        // Generate URL accessible via symlink
        $url = asset('storage/summernote/' . $filename);

        return response()->json([
            'url' => $url,
        ]);
    }
}
