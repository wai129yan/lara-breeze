@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Edit Post</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div class="mb-4">
                <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $post->slug) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                <select name="category_id" id="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="subtitle" class="block text-sm font-medium text-gray-700">Subtitle</label>
                <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $post->subtitle) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                <textarea name="content" id="content" rows="10" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('content', $post->content) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="draft" {{ $post->status == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ $post->status == 'published' ? 'selected' : '' }}>Published</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="published_at" class="block text-sm font-medium text-gray-700">Published At</label>
                <input type="date" name="published_at" id="published_at" value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d') : '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div class="mb-4">
                <label for="featured_image" class="block text-sm font-medium text-gray-700">Featured Image</label>
                <input type="file" name="featured_image" id="featured_image" class="mt-1 block w-full" onchange="previewImage(event)">
                @if ($post->featured_image)
                    <img id="image-preview" src="{{ asset('storage/' . $post->featured_image) }}" alt="Current Image" class="mt-2 w-32 h-32 object-cover">
                @else
                    <img id="image-preview" src="/placeholder.svg?height=150&width=250" alt="Image Preview" class="mt-2 w-32 h-32 object-cover">
                @endif
            </div>

            <div class="mb-4">
                <label for="tags" class="block text-sm font-medium text-gray-700">Tags (Select or Add New)</label>
                <select name="tags[]" id="tags" multiple class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}" {{ $post->tags->contains($tag->id) ? 'selected' : '' }}>{{ $tag->name }}</option>
                    @endforeach
                </select>
                <p class="text-sm text-gray-500">To add a new tag, type it in the select box and press enter.</p>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Post</button>
        </form>
    </div>

    @push('script')
        <script>
            function previewImage(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('image-preview').src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            }
        </script>
    @endpush
@endsection
