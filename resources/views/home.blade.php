@extends('layouts.app')
@section('title', 'Medium Blog')
@section('content')
    <!-- Header -->

    <!-- Category Navigation -->
    <div class="bg-white border-b">
        <div class="container mx-auto px-4 py-3 overflow-x-auto">
            <div class="flex space-x-6 whitespace-nowrap">
                <a href="#" class="text-primary border-b-2 border-primary px-1 font-medium">All</a>
                <a href="#" class="text-gray-600 hover:text-primary px-1 font-medium">Technology</a>
                <a href="#" class="text-gray-600 hover:text-primary px-1 font-medium">Travel</a>
                <a href="#" class="text-gray-600 hover:text-primary px-1 font-medium">Food</a>
                <a href="#" class="text-gray-600 hover:text-primary px-1 font-medium">Health</a>
                <a href="#" class="text-gray-600 hover:text-primary px-1 font-medium">Lifestyle</a>
                <a href="#" class="text-gray-600 hover:text-primary px-1 font-medium">Business</a>
                <a href="#" class="text-gray-600 hover:text-primary px-1 font-medium">Science</a>
                <a href="#" class="text-gray-600 hover:text-primary px-1 font-medium">Culture</a>
                <a href="#" class="text-gray-600 hover:text-primary px-1 font-medium">Politics</a>
            </div>
        </div>
    </div>
`
    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Featured Post -->
        @include('section.feature-posts')

        <!-- Latest Posts -->
        {{-- <h1>{{ hello() }}</h1> --}}
        <section class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Latest Articles</h2>
                <a href="#" class="text-primary hover:underline font-medium">View All</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Post 1 -->
                @foreach ($posts as $post)
                    <article class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                        <a href="#">
                            <img src="https://images.unsplash.com/photo-1551434678-e076c223a692" alt="Article"
                                class="w-full h-48 object-cover">
                        </a>
                        <div class="p-6">
                            <a href="{{ route('categories.show', $post->category->id) }}"
                                class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full mb-2">{{ $post->category->name }}</a>
                            <h3 class="text-xl font-bold mb-2">
                                <a href="{{ route('posts.show', $post) }}"
                                    class="hover:text-primary transition">{{ generateExcerpt($post->title, 20) }}</a>
                            </h3>
                            <p class="text-gray-600 mb-4">{{ generateExcerpt($post->content, 50) }}</p>
                            <div class="flex items-center">
                                <a href="{{ $post->user ? route('users.show', $post->user->id) : '#' }}">
                                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Author" class="w-8 h-8 rounded-full mr-2">
                                </a>
                                <div>
                                    <p class="text-sm font-medium">
                                        <a href="{{ $post->user ? route('users.show', $post->user->id) : '#' }}">
                                            {{ $post->user ? $post->user->name : 'Anonymous' }}
                                        </a>
                                    </p>
                                    <p class="text-xs text-gray-500">{{ timeToRead($post->content, 10) }}</p>
                                    <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach

            </div>
        </section>

        <!-- Editor's Picks -->
        @include('section.editor-picks')

        <!-- Popular Categories -->
        @include('section.popular-categories')

        <!-- Trending Now -->
        @include('section.trending-posts')

        <!-- Newsletter -->
        @include('section.newsletters')

        <!-- Most Popular Posts -->
        @include('section.popular-posts')

        <!-- Featured Authors -->
        @include('section.feature-authors')

    </main>
@endsection
<!-- Footer -->
