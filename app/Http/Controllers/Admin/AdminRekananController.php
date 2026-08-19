<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rekanan;
use Illuminate\Http\Request;

class AdminRekananController extends Controller
{
    public function index()
    {
        $rekanans = Rekanan::ordered()->paginate(15);

        return view('admin.rekanans.index', compact('rekanans'));
    }

    public function create()
    {
        return view('admin.rekanans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'url' => ['required', 'url', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        Rekanan::create([
            'name' => $validated['name'],
            'url' => $validated['url'],
            'is_active' => $validated['is_active'] ?? true,
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.rekanans.index')->with('success', 'Rekanan berhasil ditambahkan.');
    }

    public function edit(Rekanan $rekanan)
    {
        return view('admin.rekanans.edit', compact('rekanan'));
    }

    public function update(Request $request, Rekanan $rekanan)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'url' => ['required', 'url', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $rekanan->update([
            'name' => $validated['name'],
            'url' => $validated['url'],
            'is_active' => $validated['is_active'] ?? false,
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.rekanans.index')->with('success', 'Rekanan berhasil diperbarui.');
    }

    public function destroy(Rekanan $rekanan)
    {
        $rekanan->delete();

        return redirect()->route('admin.rekanans.index')->with('success', 'Rekanan berhasil dihapus.');
    }
}
