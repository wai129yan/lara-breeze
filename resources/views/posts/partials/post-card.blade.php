<div class="bg-white rounded-lg shadow-md p-4">
    @if ($post->featured_image)
        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}"
            class="w-full h-80 object-cover rounded-t-lg mb-4">
    @else
        <img src="{{ asset('images/default-post.jpg') }}" alt="Default Image"
            class="w-full h-48 object-cover rounded-t-lg mb-4">
    @endif
    <h2 class="text-xl font-semibold mb-2">
        <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:underline">{{ $post->title }}</a>
    </h2>
    <p class="text-gray-600 mb-2">{{ $post->subtitle ? Str::limit($post->subtitle, 100) : '' }}</p>
    <div class="text-sm text-gray-500">
        By {{ $post->user->name }} | {{ $post->published_at->format('M d, Y') }}
    </div>
    <div class="mt-2">
        @if ($post->category)
            <span
                class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">{{ $post->category->name }}</span>
        @endif
        @foreach ($post->tags as $tag)
            <span
                class="inline-block bg-blue-200 rounded-full px-3 py-1 text-sm font-semibold text-blue-700 mr-2">{{ $tag->name }}</span>
        @endforeach
    </div>
</div>
