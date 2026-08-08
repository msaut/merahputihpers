<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function index()
    {
        $member = Auth::guard('member')->user();

        $likes = $member->likedPosts()
            ->orderBy('member_likes.created_at', 'desc')
            ->paginate(10);

        return view('member.likes', compact('likes'));
    }

    public function toggle(Request $request)
    {
        $member = Auth::guard('member')->user();
        $postId = $request->input('post_id');

        $existing = $member->likes()->where('post_id', $postId)->first();

        if ($existing) {
            $existing->delete();
            $status = 'unliked';
        } else {
            $member->likes()->create(['post_id' => $postId]);
            $status = 'liked';
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => $status]);
        }

        return back();
    }
}

