<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MemberProfileController extends Controller
{
    public function edit()
    {
        $member = Auth::guard('member')->user();

        return view('member.profile', compact('member'));
    }

    public function update(Request $request)
    {
        $member = Auth::guard('member')->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('members', 'email')->ignore($member->id)],
        ]);

        // Opsional ganti password (jika diisi)
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required', 'confirmed', 'min:8'],
            ]);
            $data['password'] = Hash::make($request->password);
        }

        // Upload foto profil (opsional)
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $file = $request->file('avatar');
            $mime = $file->getMimeType();
            $base64 = 'data:' . ($mime ?: 'image/png') . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
            $data['avatar_base64'] = $base64;
            $data['avatar'] = $file->getClientOriginalName();
        }

        $member->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}

