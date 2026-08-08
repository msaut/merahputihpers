<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function index()
    {
        $member = Auth::guard('member')->user();

        $bookmarks = $member->bookmarkedPosts()
            ->orderBy('bookmarks.created_at', 'desc')
            ->paginate(10);

        return view('member.bookmarks', compact('bookmarks'));
    }

    public function toggle(Request $request)
    {
        $member = Auth::guard('member')->user();
        $postId = $request->input('post_id');

        $existing = $member->bookmarks()->where('post_id', $postId)->first();

        if ($existing) {
            $existing->delete();
            $status = 'removed';
        } else {
            $member->bookmarks()->create(['post_id' => $postId]);
            $status = 'added';
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => $status]);
        }

        return back();
    }
}

