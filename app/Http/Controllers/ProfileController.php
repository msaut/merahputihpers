<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.update', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    public function profile()
    {
        $user = User::findOrFail(Auth::id());
        return view('profile.show', compact('user'));
    }


    public function updateProfile(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');

            $avatarBase64 = null;
            $tmp = $avatar->getRealPath();
            if ($tmp) {
                $avatarBase64 = \App\Support\Base64Image::fileToBase64($tmp, true);
            }

            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $path = public_path('uploads/avatar/' . $filename);

            [$width, $height, $type] = getimagesize($avatar);
            switch ($type) {
                case IMAGETYPE_JPEG:
                    $srcImg = imagecreatefromjpeg($avatar);
                    break;
                case IMAGETYPE_PNG:
                    $srcImg = imagecreatefrompng($avatar);
                    break;
                case IMAGETYPE_GIF:
                    $srcImg = imagecreatefromgif($avatar);
                    break;
                case IMAGETYPE_WEBP:
                    $srcImg = imagecreatefromwebp($avatar);
                    break;
                default:
                    $srcImg = null;
            }

            if ($srcImg) {
                $min = min($width, $height);
                $srcX = ($width - $min) / 2;
                $srcY = ($height - $min) / 2;

                $dstImg = imagecreatetruecolor(500, 500);
                imagecopyresampled($dstImg, $srcImg, 0, 0, $srcX, $srcY, 500, 500, $min, $min);

                switch ($type) {
                    case IMAGETYPE_JPEG:
                        imagejpeg($dstImg, $path, 90);
                        break;
                    case IMAGETYPE_PNG:
                        imagepng($dstImg, $path, 9);
                        break;
                    case IMAGETYPE_GIF:
                        imagegif($dstImg, $path);
                        break;
                    case IMAGETYPE_WEBP:
                        imagewebp($dstImg, $path, 90);
                        break;
                }

                imagedestroy($srcImg);
                imagedestroy($dstImg);

                if ($user->avatar && file_exists(public_path('uploads/avatar/' . $user->avatar))) {
                    unlink(public_path('uploads/avatar/' . $user->avatar));
                }

                $data['avatar'] = $filename;
            }

            // also store base64 representation
            $data['avatar_base64'] = $avatarBase64;
        }  


            if ($request->filled('password')) {
                if (!Hash::check($request->current_password, $user->password)) {
                    return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
                }
                $data['password'] = Hash::make($request->password);
            }

            $user->fill($data);
            $user->save();

            return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui!');
    }       
    public function destroyAccount(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'password' => 'required|string',
        ]);

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password salah, akun tidak bisa dihapus.']);
        }

        if ($user->avatar && file_exists(public_path('uploads/avatar/' . $user->avatar))) {
            unlink(public_path('uploads/avatar/' . $user->avatar));
        }

        $user->delete();

        Auth::logout();

        return redirect('/')->with('status', 'Akun Anda berhasil dihapus.');
    }

}
