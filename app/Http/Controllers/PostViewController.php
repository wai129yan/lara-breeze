<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostView;
use Illuminate\Http\Request;

class PostViewController extends Controller
{
    // public function index()
    // {
    //     return PostView::with('post', 'user')->get();
    //     // dd(PostView::with('post', 'user')->get());
    // }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'post_id' => 'required|exists:posts,post_id',
    //         'user_id' => 'nullable|exists:users,user_id',
    //         'viewed_at' => 'nullable|date',
    //         'ip_address' => 'nullable|ip',
    //     ]);

    //     return PostView::create($validated);
    // }

    public function show($id, Request $request)
    {
        $post = Post::findOrFail($id);

        // Log the view
        PostView::create([
            'post_id' => $post->id,
            // 'user_id' => auth()->id(),                  // nullable if guest
            'ip_address' => $request->ip(),
            'viewed_at' => now(),
        ]);

        // return $post;
        return view('posts.show', compact('post'));
    }

    public function destroy(PostView $postView)
    {
        $postView->delete();
        return response()->noContent();
    }
}
