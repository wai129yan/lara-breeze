@extends('layouts.app')

@section('title', 'My Posts')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">My Created Posts</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('posts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4 inline-block">Create New Post</a>

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">Image</th>
                    <th class="border px-4 py-2">Title</th>
                    <th class="border px-4 py-2">Category</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Published At</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                    <tr>
                        <td class="border px-4 py-2">
                            @if ($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-16 h-16 object-cover">
                            @else
                                <img src="/placeholder.svg?height=64&width=64" alt="No Image" class="w-16 h-16 object-cover">
                            @endif
                        </td>
                        <td class="border px-4 py-2"><a href="{{ route('posts.show', $post) }}" class="text-blue-500 hover:underline">{{ $post->title }}</a></td>
                        <td class="border px-4 py-2">{{ $post->category->name ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">{{ ucfirst($post->status) }}</td>
                        <td class="border px-4 py-2">{{ $post->published_at ? $post->published_at->format('Y-m-d') : 'N/A' }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('posts.edit', $post) }}" class="text-yellow-500 hover:underline">Edit</a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline ml-2" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="border px-4 py-2 text-center">No posts found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $posts->links() }}
    </div>
@endsection
