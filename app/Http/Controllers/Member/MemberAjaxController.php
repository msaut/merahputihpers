<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberAjaxController extends Controller
{
    // Bookmark toggle lewat URL /member/bookmark/{id} (post_id dari route)
    public function bookmark($id)
    {
        $member = Auth::guard('member')->user();
        $postId = (int) $id;

        if (!$this->postExists($postId)) {
            return response()->json(['status' => 'error', 'message' => 'Berita tidak ditemukan.'], 404);
        }

        $existing = $member->bookmarks()->where('post_id', $postId)->first();

        if ($existing) {
            $existing->delete();
            $status = 'removed';
        } else {
            $member->bookmarks()->create(['post_id' => $postId]);
            $status = 'added';
        }

        return response()->json([
            'status' => $status,
            'message' => $status === 'added' ? 'Berita tersimpan.' : 'Bookmark dihapus.',
        ]);
    }

    // Like toggle lewat URL /member/like/{id} (post_id dari route)
    public function like($id)
    {
        $member = Auth::guard('member')->user();
        $postId = (int) $id;

        if (!$this->postExists($postId)) {
            return response()->json(['status' => 'error', 'message' => 'Berita tidak ditemukan.'], 404);
        }

        $existing = $member->likes()->where('post_id', $postId)->first();

        if ($existing) {
            $existing->delete();
            $status = 'unliked';
        } else {
            $member->likes()->create(['post_id' => $postId]);
            $status = 'liked';
        }

        return response()->json([
            'status' => $status,
            'message' => $status === 'liked' ? 'Berita disukai.' : 'Like dibatalkan.',
        ]);
    }

    private function postExists($id)
    {
        return \App\Models\Berita::where('id', $id)->exists();
    }

    // Toggle bookmark via AJAX
    public function toggleBookmark(Request $request)
    {
        $request->validate([
            'post_id' => ['required', 'integer', 'exists:beritas,id'],
        ]);

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

        return response()->json([
            'status' => $status,
            'message' => $status === 'added' ? 'Berita tersimpan.' : 'Bookmark dihapus.',
        ]);
    }

    // Toggle like via AJAX
    public function toggleLike(Request $request)
    {
        $request->validate([
            'post_id' => ['required', 'integer', 'exists:beritas,id'],
        ]);

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

        return response()->json([
            'status' => $status,
            'message' => $status === 'liked' ? 'Berita disukai.' : 'Like dibatalkan.',
        ]);
    }
}

