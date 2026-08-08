<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        $member = Auth::guard('member')->user();

        $histories = $member->readingHistories()
            ->with('post')
            ->orderByDesc('read_at')
            ->paginate(10);

        return view('member.history', compact('histories'));
    }

    public function clear()
    {
        $member = Auth::guard('member')->user();
        $member->readingHistories()->delete();

        return back()->with('success', 'Riwayat baca telah dibersihkan.');
    }
}

