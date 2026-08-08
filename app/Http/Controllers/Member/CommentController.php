<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\MemberComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
        $member = Auth::guard('member')->user();

        $comments = MemberComment::with('post')
            ->where('member_id', $member->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('member.comments.index', compact('comments'));
    }

    public function store(Request $request, $postId)
    {
        $member = Auth::guard('member')->user();

        $data = $request->validate([
            'isi' => ['required', 'string', 'max:1000'],
        ]);

        MemberComment::create([
            'member_id' => $member->id,
            'post_id' => $postId,
            'isi' => $data['isi'],
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $member = Auth::guard('member')->user();

        $comment = MemberComment::where('id', $id)->where('member_id', $member->id)->firstOrFail();
        $comment->delete();

        return back()->with('success', 'Komentar dihapus.');
    }
}

