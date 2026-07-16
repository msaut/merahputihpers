<?php

namespace App\Http\Controllers;

use App\Models\TermsOfUse;
use App\Models\PrivacyPolicy;
use App\Models\Contact;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    public function termsOfUse()
    {
        $page = TermsOfUse::query()->latest()->first();

        if (!$page) {
            $page = new TermsOfUse();
            $page->title = 'Terms of Use';
            $page->content = 'Terms of Use belum diisi oleh admin.';
        }

        return view('web.terms-of-use', compact('page'));
    }

    public function privacyPolicy()
    {
        $page = PrivacyPolicy::query()->latest()->first();

        if (!$page) {
            $page = new PrivacyPolicy();
            $page->title = 'Privacy Policy';
            $page->content = 'Privacy Policy belum diisi oleh admin.';
        }

        return view('web.privacy-policy', compact('page'));
    }

    public function contact()
    {
        $page = Contact::query()->latest()->first();

        if (!$page) {
            $page = new Contact();
            $page->title = 'Contact';
            $page->email = null;
            $page->phone = null;
            $page->address = null;
            $page->content = 'Contact belum diisi oleh admin.';
        }

        // untuk kompatibilitas template
        $page->title = $page->title ?? 'Contact';

        return view('web.contact', compact('page'));
    }

    public function storeContactMessage(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'judul_pesan' => ['required', 'string', 'max:255'],
            'pesan' => ['required', 'string'],
        ]);

        ContactMessage::create($validated);

        return redirect()
            ->route('static.contact')
            ->with('success', 'Pesan berhasil dikirim. Terima kasih!');
    }
}
