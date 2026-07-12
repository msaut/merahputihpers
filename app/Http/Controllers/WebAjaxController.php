<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class WebAjaxController extends Controller
{
    public function whatsNew(Request $request)
    {
        $kategoriId = $request->integer('kategori_id', 0);
        $page = $request->integer('page', 1);

        $query = Berita::query()->latest();

        if ($kategoriId > 0) {
            $query->where('kategori_id', $kategoriId);
        }

        $berita = $query->paginate(4, ['*'], 'page', $page);

        return response()->json([
            'itemsHtml' => view('web.partials.whats-new-items', compact('berita'))->render(),
            'paginationHtml' => $berita->links('pagination::bootstrap-4')->toHtml(),
        ]);
    }
}

