<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\MemberComment;
use App\Models\MemberLike;
use App\Models\ReadingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $member = Auth::guard('member')->user();

        $bookmarkCount = Bookmark::where('member_id', $member->id)->count();
        $likeCount = MemberLike::where('member_id', $member->id)->count();
        $historyCount = ReadingHistory::where('member_id', $member->id)->count();
        $commentCount = MemberComment::where('member_id', $member->id)->count();

        $readingHistories = ReadingHistory::with('post')
            ->where('member_id', $member->id)
            ->orderByDesc('read_at')
            ->take(5)
            ->get();

        return view('member.dashboard', compact(
            'member',
            'bookmarkCount',
            'likeCount',
            'historyCount',
            'commentCount',
            'readingHistories'
        ));
    }
}

