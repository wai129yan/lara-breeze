@extends('layouts.app')

@section('title', 'All Posts')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">All Posts</h1>

        </div>

        <div id="posts-container" class="grid grid-cols-1 gap-6">
            @foreach ($posts as $post)
                @include('posts.partials.post-card', ['post' => $post])
            @endforeach
        </div>

        <div id="loading" class="text-center py-4 hidden">Loading more posts...</div>
    </div>
@endsection

@push('script')
    <script>
        let nextPageUrl = '{{ $posts->nextPageUrl() }}';
        let loading = false;

        window.addEventListener('scroll', () => {
            if (loading || !nextPageUrl) return;

            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100) {
                loading = true;
                document.getElementById('loading').classList.remove('hidden');
                fetchPosts();
            }
        });

        function fetchPosts() {
            fetch(nextPageUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    appendPosts(data.posts);
                    nextPageUrl = data.next_page_url;
                    loading = false;
                    document.getElementById('loading').classList.add('hidden');
                })
                .catch(error => {
                    console.error('Error fetching posts:', error);
                    loading = false;
                    document.getElementById('loading').classList.add('hidden');
                });
        }

        function appendPosts(posts) {
            const container = document.getElementById('posts-container');
            posts.forEach(post => {
                let tagsHtml = '';
                if (post.tags && post.tags.length > 0) {
                    post.tags.forEach(tag => {
                        tagsHtml +=
                            `<span class="inline-block bg-blue-200 rounded-full px-3 py-1 text-sm font-semibold text-blue-700 mr-2">${tag.name}</span>`;
                    });
                }

                let categoryHtml = '';
                if (post.category) {
                    categoryHtml =
                        `<span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">${post.category.name}</span>`;
                }

                const postElement = document.createElement('div');
                postElement.classList.add('bg-white', 'rounded-lg', 'shadow-md', 'p-4');
                postElement.innerHTML = `
                    <h2 class="text-xl font-semibold mb-2"><a href="${post.slug}" class="text-blue-600 hover:underline">${post.title}</a></h2>
                    <p class="text-gray-600 mb-2">${post.subtitle ? post.subtitle.substring(0, 100) + '...' : ''}</p>
                    <div class="text-sm text-gray-500">
                        By ${post.user.name} | ${new Date(post.published_at).toLocaleDateString()}
                    </div>
                    <div class="mt-2">
                        ${categoryHtml}
                        ${tagsHtml}
                    </div>
                `;
                container.appendChild(postElement);
            });
        }
    </script>
@endpush
