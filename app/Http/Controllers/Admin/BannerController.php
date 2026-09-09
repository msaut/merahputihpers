<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $query = Banner::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%'.$request->search.'%')
                    ->orWhere('link', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->filled('posisi')) {
            $query->where('posisi', $request->posisi);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $banners = $query->orderBy('urutan')->orderBy('created_at', 'desc')->paginate(15)->appends($request->query());

        $stats = [
            'total' => Banner::count(),
            'active' => Banner::where('status', 'active')->count(),
            'inactive' => Banner::where('status', 'inactive')->count(),
            'views' => Banner::sum('views'),
            'clicks' => Banner::sum('clicks'),
        ];

        $stats['ctr'] = $stats['views'] > 0 ? round(($stats['clicks'] / $stats['views']) * 100, 2) : 0;

        return view('admin.banners.index', compact('banners', 'stats'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateBanner($request, null);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->storeImage($request->file('gambar'), $validated['posisi'], $validated['validation_mode'] ?? config('banner.default_validation_mode'));
        }

        Banner::create($validated);

        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil ditambahkan.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $this->validateBanner($request, $banner);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->storeImage($request->file('gambar'), $validated['posisi'], $validated['validation_mode'] ?? config('banner.default_validation_mode'));

            if ($banner->gambar && Storage::disk('public')->exists($banner->gambar)) {
                Storage::disk('public')->delete($banner->gambar);
            }
        }

        $banner->update($validated);

        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil diperbarui.');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->gambar && Storage::disk('public')->exists($banner->gambar)) {
            Storage::disk('public')->delete($banner->gambar);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil dihapus.');
    }

    public function toggleStatus(Banner $banner)
    {
        $banner->status = $banner->status === 'active' ? 'inactive' : 'active';
        $banner->save();

        return redirect()->route('admin.banners.index')->with('success', 'Status banner berhasil diubah.');
    }

    public function click(Banner $banner)
    {
        $banner->increment('clicks');

        $target = $banner->link ?: url('/');

        return redirect()->to($target);
    }

    protected function validateBanner(Request $request, ?Banner $banner): array
    {
        $position = $request->input('posisi');
        $defaultValidationMode = $request->input('validation_mode', config('banner.default_validation_mode'));

        $rules = [
            'judul' => ['required', 'string', 'max:255'],
            'link' => ['required', 'url', 'max:255'],
            'posisi' => ['required', 'in:'.implode(',', array_keys(config('banner.positions')))],
            'target' => ['required', 'in:'.implode(',', config('banner.allowed_targets'))],
            'status' => ['required', 'in:active,inactive'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'validation_mode' => ['nullable', 'in:strict,recommended'],
            'gambar' => $request->hasFile('gambar') || !$banner ? ['required', 'image', 'mimes:jpeg,png,webp', 'max:2048'] : ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
        ];

        $messageMax = config('banner.positions.' . $position . '.max_size_kb', 2048);
        $rules['gambar'][2] = 'max:' . $messageMax;

        if ($position === 'mobile') {
            $rules['gambar'][2] = 'max:1024';
        }

        $validated = $request->validate($rules);

        if ($request->hasFile('gambar')) {
            $this->validateImageDimensions($request->file('gambar'), $position, $defaultValidationMode);
        }

        $validated['alt_text'] = $validated['alt_text'] ?? $validated['judul'];
        $validated['status'] = $validated['status'];
        $validated['validation_mode'] = $defaultValidationMode;

        return $validated;
    }

    protected function validateImageDimensions($file, string $position, string $mode): void
    {
        if (!$file || !$file->isValid()) {
            throw ValidationException::withMessages(['gambar' => 'File gambar tidak valid.']);
        }

        $size = @getimagesize($file->getPathname());

        if ($size === false) {
            throw ValidationException::withMessages(['gambar' => 'File yang diupload bukan gambar valid.']);
        }

        [$width, $height] = $size;
        $expected = Banner::sizeFor($position);

        if (!$expected) {
            return;
        }

        $expectedWidth = (int) $expected['width'];
        $expectedHeight = (int) $expected['height'];
        $ratio = $expectedWidth / $expectedHeight;
        $actualRatio = $width / max($height, 1);
        $ratioDiff = abs($ratio - $actualRatio);

        if ($mode === 'strict') {
            if ($width !== $expectedWidth || $height !== $expectedHeight) {
                throw ValidationException::withMessages([
                    'gambar' => 'Ukuran gambar tidak sesuai dengan ukuran banner yang dipilih. Gunakan ukuran ' . $expectedWidth . ' × ' . $expectedHeight . ' px.',
                ]);
            }

            return;
        }

        $allowedRatioDelta = 0.25;
        $widthDelta = abs($width - $expectedWidth);
        $heightDelta = abs($height - $expectedHeight);

        if ($ratioDiff > $allowedRatioDelta && ($widthDelta > 120 || $heightDelta > 100)) {
            throw ValidationException::withMessages([
                'gambar' => 'Ukuran gambar tidak sesuai dengan ukuran banner yang dipilih. Gunakan ukuran ' . $expectedWidth . ' × ' . $expectedHeight . ' px.',
            ]);
        }
    }

    protected function storeImage($file, string $position, string $mode): string
    {
        $this->validateImageDimensions($file, $position, $mode);

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('banners', $filename, 'public');

        return $path;
    }
}
