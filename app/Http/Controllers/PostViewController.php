<?php
namespace App\Http\Controllers;

use App\Models\PostView;
use Illuminate\Http\Request;

class PostViewController extends Controller
{
    public function index()
    {
        return PostView::with('post', 'user')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,post_id',
            'user_id' => 'nullable|exists:users,user_id',
            'viewed_at' => 'nullable|date',
            'ip_address' => 'nullable|ip',
        ]);

        return PostView::create($validated);
    }

    public function show(PostView $postView)
    {
        return $postView->load('post', 'user');
    }

    public function destroy(PostView $postView)
    {
        $postView->delete();
        return response()->noContent();
    }
}