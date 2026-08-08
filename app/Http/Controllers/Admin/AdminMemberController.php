<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class AdminMemberController extends Controller
{
    // Daftar semua member
    public function index()
    {
        $members = Member::withCount('payments')->latest()->paginate(15);
        return view('admin.members.index', compact('members'));
    }

    // Ubah status aktif/nonaktif member
    public function toggleStatus(Member $member)
    {
        if ($member->status === 'active') {
            $member->status = 'inactive';
            $member->subscription_start = null;
            $member->subscription_end = null;
            $member->save();
        } else {
            $member->status = 'active';
            $member->subscription_start = now();
            $member->subscription_end = now()->addDays(30);
            $member->save();
        }

        return back()->with('success', 'Status member berhasil diubah.');
    }
}
