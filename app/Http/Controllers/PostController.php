<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $postsQuery = Post::with('category', 'user')->latest();

        if ($user) {
            $postsQuery->where('user_id', $user->id);
        }

        $posts = $postsQuery->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to create a post.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|unique:posts,slug',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|image|max:2048',  // Max 2MB
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable',
        ]);

        $data = $request->except('tags');
        $data['user_id'] = Auth::id();

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('images/posts', 'public');
        }

        // Set published_at date if status is published and no date is provided
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        // Create the post
        $post = Post::create($data);

        // Handle tags (both existing and new ones)
        if ($request->has('tags')) {
            $tagIds = [];

            foreach ($request->tags as $tagId) {
                // If it's a numeric ID, it's an existing tag
                if (is_numeric($tagId)) {
                    $tagIds[] = $tagId;
                } else {
                    // It's a new tag, create it
                    $slug = Str::slug($tagId);
                    $tag = Tag::firstOrCreate(
                        ['slug' => $slug],
                        ['name' => $tagId, 'slug' => $slug]
                    );
                    $tagIds[] = $tag->id;
                }
            }

            // Attach tags to post
            $post->tags()->attach($tagIds);
        }

        return redirect()->route('authors.index')->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        // return $post;
        $post->load('tags');
        return view('posts.show', compact('post'));
        // return response()->json($post);
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|unique:posts,slug,' . $post->id,
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|image',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'tags' => 'nullable|array',
        ]);

        $data = $request->all();

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('images/posts', 'public');
        }

        // Set published_at if status is published and no date is provided
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        // Handle tags
        if ($request->has('tags')) {
            $tagIds = [];
            foreach ($request->tags as $tagId) {
                if (is_numeric($tagId)) {
                    $tagIds[] = $tagId;
                } else {
                    $slug = Str::slug($tagId);
                    $tag = Tag::firstOrCreate(['slug' => $slug], ['name' => $tagId, 'slug' => $slug]);
                    $tagIds[] = $tag->id;
                }
            }
            $post->tags()->sync($tagIds);
        }

        $post->update($data);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }

    /**
     * Update the status of a post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, Post $post)
    {
        // Validate the request
        $request->validate([
            'status' => 'required|in:draft,published',
        ]);

        // Check if the user is authorized to update this post
        if ($post->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to update this post.');
        }

        // Update the post status
        $updateData = [
            'status' => $request->status
        ];

        if ($request->status === 'published' && is_null($post->published_at)) {
            $updateData['published_at'] = now();
        }

        $post->update($updateData);

        return redirect()->back()->with('success', 'Post status updated successfully.');
    }
}
