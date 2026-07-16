<?php

namespace App\Http\Controllers;

use App\Models\TermsOfUse;
use App\Models\PrivacyPolicy;
use App\Models\Contact;
use Illuminate\Http\Request;

class AdminStaticPagesController extends Controller
{
    protected function resolveModel(string $type)
    {
        return match ($type) {
            'terms-of-use' => TermsOfUse::class,
            'privacy-policy' => PrivacyPolicy::class,
            'contact' => Contact::class,
            default => null,
        };
    }

    protected function modelFromType(string $type)
    {
        $modelClass = $this->resolveModel($type);

        abort_if(!$modelClass, 404);

        return $modelClass;
    }

    public function index(Request $request, string $type)
    {
        $modelClass = $this->modelFromType($type);
        $items = $modelClass::latest()->paginate(10);

        return view('admin.static-pages.index', [
            'items' => $items,
            'type' => $type,
        ]);
    }

    public function create(Request $request, string $type)
    {
        $modelClass = $this->modelFromType($type);

        return view('admin.static-pages.edit', [
            'item' => new $modelClass(),
            'type' => $type,
        ]);
    }

    public function edit(Request $request, string $type)
    {
        $modelClass = $this->modelFromType($type);

        $item = $modelClass::query()->latest()->first() ?? new $modelClass();

        return view('admin.static-pages.edit', [
            'item' => $item,
            'type' => $type,
        ]);
    }

    public function store(Request $request, string $type)
    {
        $modelClass = $this->modelFromType($type);

        $data = $this->validateData($request, $type);

        $item = $modelClass::query()->latest()->first();

        if ($item) {
            $item->update($data);
        } else {
            $item = $modelClass::create($data);
        }

        return redirect()->route('admin.static-pages.edit', ['type' => $type])
            ->with('success', 'Konten berhasil disimpan.');
    }

    public function update(Request $request, string $type)
    {
        return $this->store($request, $type);
    }

    public function destroy(Request $request, string $type)
    {
        $modelClass = $this->modelFromType($type);

        $modelClass::query()->latest()->first()?->delete();

        return redirect()->route('admin.static-pages.edit', ['type' => $type])
            ->with('success', 'Konten berhasil dihapus.');
    }

    protected function validateData(Request $request, string $type): array
    {
        if ($type === 'terms-of-use') {
            return $request->validate([
                'title' => 'nullable|string|max:255',
                'content' => 'required|string',
            ]);
        }

        if ($type === 'privacy-policy') {
            return $request->validate([
                'title' => 'nullable|string|max:255',
                'content' => 'required|string',
            ]);
        }

        if ($type === 'contact') {
            return $request->validate([
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:1000',
                'content' => 'nullable|string',
            ]);
        }

        abort(404);
    }
}
