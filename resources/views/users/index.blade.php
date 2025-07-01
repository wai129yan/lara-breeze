@extends('layouts.app')
@section('title', 'Users')
@section('content')
    @push('style')
        <!-- Your existing CSS remains the same -->
    @endpush

    <section class="gradient-bg text-gray-500 py-20 relative">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>

        <div class="container mx-auto px-4">
            <div class="flex justify-center space-x-4 mb-12">
                <button
                    class="filter-btn px-6 py-2 bg-purple-600 text-white rounded-full hover:bg-purple-700 transition-all duration-300"
                    data-target="most-posts">Most Posts</button>
                <button
                    class="filter-btn px-6 py-2 bg-white text-purple-600 rounded-full hover:bg-purple-100 transition-all duration-300"
                    data-target="most-followers">Most Followers</button>
                <button
                    class="filter-btn px-6 py-2 bg-white text-purple-600 rounded-full hover:bg-purple-100 transition-all duration-300"
                    data-target="most-claps">Most Claps</button>
            </div>

            <div class="space-y-16">
                {{-- Most Posts Section --}}
                <div id="most-posts" class="author-section">
                    <h2 class="text-3xl font-bold text-center mb-12">Most Post Authors</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($mostPostUser as $mostPost)
                            <div
                                class="bg-white rounded-xl shadow-xl overflow-hidden transform hover:scale-105 transition-all duration-300">
                                <div class="p-6">
                                    <div class="flex items-center space-x-4">
                                        <img src="{{ $mostPost->avatar ?? '/placeholder.svg?height=150&width=150' }}"
                                            alt="{{ $mostPost->name }}"
                                            class="w-16 h-16 rounded-full object-cover ring-4 ring-purple-100">
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-900">
                                                <a href="{{ route('users.show', $mostPost->id) }}"
                                                    class="hover:text-purple-600 transition-colors duration-300">
                                                    {{ $mostPost->name }}
                                                </a>
                                            </h3>
                                            <p class="text-gray-600 text-sm mt-1">{{ $mostPost->post }} Posts</p>
                                        </div>
                                    </div>
                                    <p class="mt-4 text-gray-600 line-clamp-2">
                                        {{ Str::limit($mostPost->bio ?? '', 100) }}
                                    </p>
                                    <div class="mt-6 flex items-center justify-between">
                                        <div class="flex space-x-3">
                                            @if ($mostPost->twitter)
                                                <a href="{{ $mostPost->twitter }}" target="_blank"
                                                    class="social-icon text-blue-400">
                                                    <i class="fab fa-twitter fa-lg"></i>
                                                </a>
                                            @endif
                                            @if ($mostPost->linkedin)
                                                <a href="{{ $mostPost->linkedin }}" target="_blank"
                                                    class="social-icon text-blue-700">
                                                    <i class="fab fa-linkedin fa-lg"></i>
                                                </a>
                                            @endif
                                            @if ($mostPost->github)
                                                <a href="{{ $mostPost->github }}" target="_blank"
                                                    class="social-icon text-gray-900">
                                                    <i class="fab fa-github fa-lg"></i>
                                                </a>
                                            @endif
                                        </div>
                                        <button
                                            class="follow-btn px-6 py-2 bg-purple-600 text-white rounded-full hover:bg-purple-700 transition-all duration-300">
                                            Follow
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Most Followers Section --}}
                <div id="most-followers" class="author-section hidden">
                    <h2 class="text-3xl font-bold text-center mb-12">Most Followed Authors</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($mostFollowerUser as $mostFollower)
                            <div
                                class="bg-white rounded-xl shadow-xl overflow-hidden transform hover:scale-105 transition-all duration-300">
                                <div class="p-6">
                                    <div class="flex items-center space-x-4">
                                        <img src="{{ $mostFollower->avatar ?? '/placeholder.svg?height=150&width=150' }}"
                                            alt="{{ $mostFollower->name }}"
                                            class="w-16 h-16 rounded-full object-cover ring-4 ring-purple-100">
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-900">
                                                <a href="{{ route('users.show', $mostFollower->id) }}"
                                                    class="hover:text-purple-600 transition-colors duration-300">
                                                    {{ $mostFollower->name }}
                                                </a>
                                            </h3>
                                            <p class="text-gray-600 text-sm mt-1">{{ $mostFollower->followers_count }}
                                                Followers
                                            </p>
                                        </div>
                                    </div>
                                    <p class="mt-4 text-gray-600 line-clamp-2">
                                        {{ Str::limit($mostFollower->bio ?? '', 100) }}
                                    </p>
                                    <div class="mt-6 flex items-center justify-between">
                                        <div class="flex space-x-3">
                                            @if ($mostFollower->twitter)
                                                <a href="{{ $mostFollower->twitter }}" target="_blank"
                                                    class="social-icon text-blue-400">
                                                    <i class="fab fa-twitter fa-lg"></i>
                                                </a>
                                            @endif
                                            @if ($mostFollower->linkedin)
                                                <a href="{{ $mostFollower->linkedin }}" target="_blank"
                                                    class="social-icon text-blue-700">
                                                    <i class="fab fa-linkedin fa-lg"></i>
                                                </a>
                                            @endif
                                            @if ($mostFollower->github)
                                                <a href="{{ $mostFollower->github }}" target="_blank"
                                                    class="social-icon text-gray-900">
                                                    <i class="fab fa-github fa-lg"></i>
                                                </a>
                                            @endif
                                        </div>
                                        <button
                                            class="follow-btn px-6 py-2 bg-purple-600 text-white rounded-full hover:bg-purple-700 transition-all duration-300">
                                            Follow
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Most Claps Section --}}
                <div id="most-claps" class="author-section hidden">
                    <h2 class="text-3xl font-bold text-center mb-12">Most Appreciated Authors</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($mostClapUser as $mostClap)
                            <div
                                class="bg-white rounded-xl shadow-xl overflow-hidden transform hover:scale-105 transition-all duration-300">
                                <div class="p-6">
                                    <div class="flex items-center space-x-4">
                                        <img src="{{ $mostClap->avatar ?? '/placeholder.svg?height=150&width=150' }}"
                                            alt="{{ $mostClap->name }}"
                                            class="w-16 h-16 rounded-full object-cover ring-4 ring-purple-100">
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-900">
                                                <a href="{{ route('users.show', $mostClap->id) }}"
                                                    class="hover:text-purple-600 transition-colors duration-300">
                                                    {{ $mostClap->name }}
                                                </a>
                                            </h3>
                                            <p class="text-gray-600 text-sm mt-1">{{ $mostClap->received_claps_count }}
                                                Claps</p>
                                        </div>
                                    </div>
                                    <p class="mt-4 text-gray-600 line-clamp-2">
                                        {{ Str::limit($mostClap->bio ?? '', 100) }}
                                    </p>
                                    <div class="mt-6 flex items-center justify-between">
                                        <div class="flex space-x-3">
                                            @if ($mostClap->twitter)
                                                <a href="{{ $mostClap->twitter }}" target="_blank"
                                                    class="social-icon text-blue-400">
                                                    <i class="fab fa-twitter fa-lg"></i>
                                                </a>
                                            @endif
                                            @if ($mostClap->linkedin)
                                                <a href="{{ $mostClap->linkedin }}" target="_blank"
                                                    class="social-icon text-blue-700">
                                                    <i class="fab fa-linkedin fa-lg"></i>
                                                </a>
                                            @endif
                                            @if ($mostClap->github)
                                                <a href="{{ $mostClap->github }}" target="_blank"
                                                    class="social-icon text-gray-900">
                                                    <i class="fab fa-github fa-lg"></i>
                                                </a>
                                            @endif
                                        </div>
                                        <button
                                            class="follow-btn px-6 py-2 bg-purple-600 text-white rounded-full hover:bg-purple-700 transition-all duration-300">
                                            Follow
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Section Filtering
                const filterBtns = document.querySelectorAll('.filter-btn');
                const sections = document.querySelectorAll('.author-section');

                console.log("hello");
                // Initial setup to ensure only Most Posts is visible
                function resetSections() {
                    sections.forEach(section => {
                        section.classList.add('hidden');
                    });
                    document.getElementById('most-followers').classList.remove('hidden');

                    filterBtns.forEach(btn => {
                        btn.classList.remove('bg-purple-600', 'text-white');
                        btn.classList.add('bg-white', 'text-purple-600');

                        if (btn.getAttribute('data-target') === 'most-followers') {
                            btn.classList.remove('bg-white', 'text-purple-600');
                            btn.classList.add('bg-purple-600', 'text-white');
                        }

                    });
                }

                // Initial reset
                resetSections();

                // Filter button click handler
                filterBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const targetId = this.getAttribute('data-target');

                        // Reset all buttons
                        filterBtns.forEach(b => {
                            b.classList.remove('bg-purple-600', 'text-white');
                            b.classList.add('bg-white', 'text-purple-600');
                        });

                        // Style current button
                        this.classList.remove('bg-white', 'text-purple-600');
                        this.classList.add('bg-purple-600', 'text-white');

                        // Hide all sections
                        sections.forEach(section => {
                            section.classList.add('hidden');
                        });

                        // Show target section
                        document.getElementById(targetId).classList.remove('hidden');
                    });
                });

                // Follow button functionality
                function setupFollowButtons() {
                    const followBtns = document.querySelectorAll('.follow-btn');
                    followBtns.forEach(btn => {
                        btn.addEventListener('click', function() {
                            // Toggle button state
                            if (this.textContent.trim() === 'Follow') {
                                this.textContent = 'Following';
                                this.classList.remove('bg-purple-600', 'text-white');
                                this.classList.add('bg-purple-100', 'text-purple-600');
                            } else {
                                this.textContent = 'Follow';
                                this.classList.remove('bg-purple-100', 'text-purple-600');
                                this.classList.add('bg-purple-600', 'text-white');
                            }
                        });
                    });
                }

                // Initial setup of follow buttons
                setupFollowButtons();

                // Optional: If you're dynamically loading content,
                // you might want to call setupFollowButtons after content changes
            });
        </script>
    @endpush
@endsection
