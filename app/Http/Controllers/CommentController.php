<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,post_id',
            'parent_comment_id' => 'nullable|exists:comments,comment_id',
            'content' => 'required|string|min:1|max:1000',
        ]);

        $comment = Comment::create([
            'post_id' => $validated['post_id'],
            'user_id' => Auth::id(),
            'parent_comment_id' => $validated['parent_comment_id'],
            'content' => $validated['content'],
        ]);

        return redirect()->back()->with('success', 'Comment posted successfully.');
    }

    /**
     * Update the specified comment in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        // $this->authorize('update', $comment);

        $validated = $request->validate([
            'content' => 'required|string|min:1|max:1000',
        ]);

        $comment->update([
            'content' => $validated['content'],
        ]);

        return redirect()->back()->with('success', 'Comment updated successfully.');
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy(Comment $comment)
    {
        // $this->authorize('delete', $comment);

        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}
