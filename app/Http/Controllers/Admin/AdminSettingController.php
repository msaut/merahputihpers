<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    // Form setting email
    public function email()
    {
        return view('admin.settings.email');
    }

    // Simpan setting email
    public function emailUpdate(Request $request)
    {
        $request->validate([
            'mail_host'     => ['required', 'string', 'max:255'],
            'mail_port'     => ['required', 'numeric'],
            'mail_username' => ['nullable', 'string', 'max:255'],
            'mail_password' => ['nullable', 'string', 'max:255'],
            'mail_encryption'=> ['nullable', 'string', 'max:50'],
            'mail_from_address'=> ['required', 'email'],
            'mail_from_name' => ['required', 'string', 'max:255'],
        ]);

        Setting::set('mail_host', $request->mail_host);
        Setting::set('mail_port', $request->mail_port);
        Setting::set('mail_username', $request->mail_username);
        Setting::set('mail_password', $request->mail_password);
        Setting::set('mail_encryption', $request->mail_encryption);
Setting::set('mail_from_address', $request->mail_from_address);
        Setting::set('mail_from_name', $request->mail_from_name);
        Setting::set('qr_enabled', $request->boolean('qr_enabled') ? '1' : '0');

        // Sinkronkan ke config runtime (agar berlaku saat kirim email)
        config([
            'mail.mailers.smtp.host' => $request->mail_host,
            'mail.mailers.smtp.port' => $request->mail_port,
            'mail.mailers.smtp.username' => $request->mail_username,
            'mail.mailers.smtp.password' => $request->mail_password,
            'mail.mailers.smtp.encryption' => $request->mail_encryption,
            'mail.from.address' => $request->mail_from_address,
            'mail.from.name' => $request->mail_from_name,
        ]);

        return back()->with('success', 'Setting email berhasil disimpan.');
    }
}
