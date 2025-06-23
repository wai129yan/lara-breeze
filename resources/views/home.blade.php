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

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Featured Post -->
        <section class="mb-12">
            <div class="relative rounded-xl overflow-hidden">
                <img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643" alt="Featured Post"
                    class="w-full h-[500px] object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6 md:p-10">
                    <span
                        class="inline-block bg-primary text-white text-xs font-semibold px-3 py-1 rounded-full mb-3">Technology</span>
                    <h1 class="text-2xl md:text-4xl font-bold text-white mb-3">The Future of Remote Work: How
                        Technology
                        is Reshaping Our Workplaces</h1>
                    <p class="text-gray-200 mb-4 max-w-3xl">Explore how digital tools, virtual collaboration, and
                        flexible work arrangements are transforming traditional office environments and creating new
                        opportunities for businesses and employees alike.</p>
                    <div class="flex items-center">
                        <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Author"
                            class="w-10 h-10 rounded-full mr-3">
                        <div>
                            <p class="text-white font-medium">Emma Rodriguez</p>
                            <p class="text-gray-300 text-sm">May 12, 2023 · 8 min read</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Latest Posts -->
        <h1>{{ hello() }}</h1>
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
                                <a href="{{ route('users.show', $post->user->id) }}"><img
                                        src="https://randomuser.me/api/portraits/men/32.jpg" alt="Author"
                                        class="w-8 h-8 rounded-full mr-2"></a>
                                <div>
                                    <p class="text-sm font-medium">
                                        <a href="{{ route('users.show', $post->user->id) }}">
                                            {{ $post->user->name }}
                                        </a>
                                    </p>
                                    <p class="text-xs text-gray-500">{{ timeToRead($post->content, 10) }}</p>
                                    <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach


                {{-- <!-- Post 2 -->
                <article class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <a href="#">
                        <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1" alt="Article"
                            class="w-full h-48 object-cover">
                    </a>
                    <div class="p-6">
                        <a href="#"
                            class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full mb-2">Travel</a>
                        <h3 class="text-xl font-bold mb-2">
                            <a href="#" class="hover:text-primary transition">Hidden Gems: 5 Underrated
                                Destinations for
                                Your Next Adventure</a>
                        </h3>
                        <p class="text-gray-600 mb-4">Escape the tourist crowds and discover these breathtaking
                            locations that offer authentic experiences and unforgettable memories.</p>
                        <div class="flex items-center">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Author"
                                class="w-8 h-8 rounded-full mr-2">
                            <div>
                                <p class="text-sm font-medium">Sophia Martinez</p>
                                <p class="text-xs text-gray-500">May 8, 2023 · 7 min read</p>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Post 3 -->
                <article class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <a href="#">
                        <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd" alt="Article"
                            class="w-full h-48 object-cover">
                    </a>
                    <div class="p-6">
                        <a href="#"
                            class="inline-block bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded-full mb-2">Food</a>
                        <h3 class="text-xl font-bold mb-2">
                            <a href="#" class="hover:text-primary transition">Plant-Based Revolution: Simple
                                Recipes for
                                Beginners</a>
                        </h3>
                        <p class="text-gray-600 mb-4">Explore the world of plant-based cooking with these easy,
                            nutritious, and delicious recipes that will satisfy even the most dedicated meat-eaters.</p>
                        <div class="flex items-center">
                            <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Author"
                                class="w-8 h-8 rounded-full mr-2">
                            <div>
                                <p class="text-sm font-medium">Marcus Johnson</p>
                                <p class="text-xs text-gray-500">May 5, 2023 · 4 min read</p>
                            </div>
                        </div>
                    </div>
                </article> --}}
            </div>
        </section>

        <!-- Editor's Picks -->
        <section class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Editor's Picks</h2>
                <a href="#" class="text-primary hover:underline font-medium">View All</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Post 1 -->
                <article
                    class="flex flex-col md:flex-row bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <a href="#" class="md:w-2/5">
                        <img src="https://images.unsplash.com/photo-1507925921958-8a62f3d1a50d" alt="Article"
                            class="w-full h-48 md:h-full object-cover">
                    </a>
                    <div class="p-6 md:w-3/5">
                        <a href="#"
                            class="inline-block bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-0.5 rounded-full mb-2">Lifestyle</a>
                        <h3 class="text-xl font-bold mb-2">
                            <a href="#" class="hover:text-primary transition">Digital Minimalism: Finding
                                Balance in a
                                Connected World</a>
                        </h3>
                        <p class="text-gray-600 mb-4">Learn practical strategies to reduce digital clutter, minimize
                            distractions, and create healthier relationships with technology.</p>
                        <div class="flex items-center">
                            <img src="https://randomuser.me/api/portraits/women/42.jpg" alt="Author"
                                class="w-8 h-8 rounded-full mr-2">
                            <div>
                                <p class="text-sm font-medium">Olivia Taylor</p>
                                <p class="text-xs text-gray-500">May 3, 2023 · 6 min read</p>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Post 2 -->
                <article
                    class="flex flex-col md:flex-row bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <a href="#" class="md:w-2/5">
                        <img src="https://images.unsplash.com/photo-1434494878577-86c23bcb06b9" alt="Article"
                            class="w-full h-48 md:h-full object-cover">
                    </a>
                    <div class="p-6 md:w-3/5">
                        <a href="#"
                            class="inline-block bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded-full mb-2">Health</a>
                        <h3 class="text-xl font-bold mb-2">
                            <a href="#" class="hover:text-primary transition">The Science of Sleep: Why Quality
                                Rest
                                Matters More Than Quantity</a>
                        </h3>
                        <p class="text-gray-600 mb-4">Discover the latest research on sleep cycles, circadian rhythms,
                            and how to optimize your rest for better health and productivity.</p>
                        <div class="flex items-center">
                            <img src="https://randomuser.me/api/portraits/men/52.jpg" alt="Author"
                                class="w-8 h-8 rounded-full mr-2">
                            <div>
                                <p class="text-sm font-medium">Dr. James Wilson</p>
                                <p class="text-xs text-gray-500">April 28, 2023 · 8 min read</p>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <!-- Popular Categories -->
        <section class="mb-12">
            <h2 class="text-2xl font-bold mb-6">Explore Popular Categories</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="#" class="group">
                    <div class="relative rounded-xl overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1488590528505-98d2b5aba04b" alt="Technology"
                            class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h3 class="text-white font-bold text-lg">Technology</h3>
                            <p class="text-gray-200 text-sm">142 articles</p>
                        </div>
                    </div>
                </a>

                <a href="#" class="group">
                    <div class="relative rounded-xl overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1" alt="Travel"
                            class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h3 class="text-white font-bold text-lg">Travel</h3>
                            <p class="text-gray-200 text-sm">98 articles</p>
                        </div>
                    </div>
                </a>

                <a href="#" class="group">
                    <div class="relative rounded-xl overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd" alt="Food"
                            class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h3 class="text-white font-bold text-lg">Food</h3>
                            <p class="text-gray-200 text-sm">87 articles</p>
                        </div>
                    </div>
                </a>

                <a href="#" class="group">
                    <div class="relative rounded-xl overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1434494878577-86c23bcb06b9" alt="Health"
                            class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h3 class="text-white font-bold text-lg">Health</h3>
                            <p class="text-gray-200 text-sm">76 articles</p>
                        </div>
                    </div>
                </a>
            </div>
        </section>

        <!-- Trending Now -->
        <section class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Trending Now</h2>
                <a href="#" class="text-primary hover:underline font-medium">View All</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Post 1 -->
                <article class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <a href="#">
                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f" alt="Article"
                            class="w-full h-48 object-cover">
                    </a>
                    <div class="p-6">
                        <a href="#"
                            class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full mb-2">Business</a>
                        <h3 class="text-xl font-bold mb-2">
                            <a href="#" class="hover:text-primary transition">Sustainable Investing: How to
                                Build a
                                Green Portfolio</a>
                        </h3>
                        <p class="text-gray-600 mb-4">Learn how to align your investments with your values while still
                            achieving strong financial returns.</p>
                        <div class="flex items-center">
                            <img src="https://randomuser.me/api/portraits/women/28.jpg" alt="Author"
                                class="w-8 h-8 rounded-full mr-2">
                            <div>
                                <p class="text-sm font-medium">Rebecca Lee</p>
                                <p class="text-xs text-gray-500">May 1, 2023 · 6 min read</p>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Post 2 -->
                <article class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <a href="#">
                        <img src="https://images.unsplash.com/photo-1550745165-9bc0b252726f" alt="Article"
                            class="w-full h-48 object-cover">
                    </a>
                    <div class="p-6">
                        <a href="#"
                            class="inline-block bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-0.5 rounded-full mb-2">Technology</a>
                        <h3 class="text-xl font-bold mb-2">
                            <a href="#" class="hover:text-primary transition">The Rise of AI in Creative
                                Industries:
                                Threat or Opportunity?</a>
                        </h3>
                        <p class="text-gray-600 mb-4">Exploring how artificial intelligence is transforming art,
                            design,
                            writing, and other creative fields.</p>
                        <div class="flex items-center">
                            <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="Author"
                                class="w-8 h-8 rounded-full mr-2">
                            <div>
                                <p class="text-sm font-medium">Daniel Park</p>
                                <p class="text-xs text-gray-500">April 29, 2023 · 9 min read</p>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Post 3 -->
                <article class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <a href="#">
                        <img src="https://images.unsplash.com/photo-1517649763962-0c623066013b" alt="Article"
                            class="w-full h-48 object-cover">
                    </a>
                    <div class="p-6">
                        <a href="#"
                            class="inline-block bg-pink-100 text-pink-800 text-xs font-semibold px-2.5 py-0.5 rounded-full mb-2">Culture</a>
                        <h3 class="text-xl font-bold mb-2">
                            <a href="#" class="hover:text-primary transition">The Resurgence of Vinyl: Why
                                Analog Music
                                is Making a Comeback</a>
                        </h3>
                        <p class="text-gray-600 mb-4">Discover why vinyl records are experiencing a renaissance in our
                            digital age and what's driving their popularity.</p>
                        <div class="flex items-center">
                            <img src="https://randomuser.me/api/portraits/men/22.jpg" alt="Author"
                                class="w-8 h-8 rounded-full mr-2">
                            <div>
                                <p class="text-sm font-medium">Jason Miller</p>
                                <p class="text-xs text-gray-500">April 25, 2023 · 5 min read</p>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <!-- Newsletter -->
        <section class="mb-12 bg-gradient-to-r from-primary to-secondary rounded-xl overflow-hidden">
            <div class="flex flex-col md:flex-row">
                <div class="md:w-1/2 p-8 md:p-12">
                    <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">Subscribe to Our Newsletter</h2>
                    <p class="text-white/90 mb-6">Stay updated with our latest articles, tips, and insights delivered
                        straight to your inbox. No spam, just valuable content.</p>
                    <form class="space-y-4">
                        <div>
                            <input type="text" placeholder="Your name"
                                class="w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-white">
                        </div>
                        <div>
                            <input type="email" placeholder="Your email address"
                                class="w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-white">
                        </div>
                        <button type="submit"
                            class="w-full bg-white text-primary font-bold py-3 px-6 rounded-lg hover:bg-gray-100 transition">Subscribe
                            Now</button>
                    </form>
                </div>
                <div class="hidden md:block md:w-1/2 relative">
                    <img src="https://images.unsplash.com/photo-1499951360447-b19be8fe80f5" alt="Newsletter"
                        class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/20"></div>
                </div>
            </div>
        </section>

        <!-- Most Popular Posts -->
        <section class="mb-12">
            <h2 class="text-2xl font-bold mb-6">Most Popular This Month</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Post 1 -->
                <article
                    class="flex flex-col bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <a href="#" class="relative">
                        <img src="https://images.unsplash.com/photo-1504805572947-34fad45aed93" alt="Article"
                            class="w-full h-40 object-cover">
                        <div class="absolute top-2 left-2 bg-white text-primary text-xs font-bold px-2 py-1 rounded">01
                        </div>
                    </a>
                    <div class="p-4 flex-grow">
                        <a href="#"
                            class="inline-block bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-0.5 rounded-full mb-2">Science</a>
                        <h3 class="font-bold mb-2">
                            <a href="#" class="hover:text-primary transition">Climate Change: New Research
                                Reveals
                                Unexpected Impacts</a>
                        </h3>
                        <div class="flex items-center text-xs text-gray-500">
                            <span>April 20, 2023</span>
                            <span class="mx-2">•</span>
                            <span>4 min read</span>
                        </div>
                    </div>
                </article>

                <!-- Post 2 -->
                <article
                    class="flex flex-col bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <a href="#" class="relative">
                        <img src="https://images.unsplash.com/photo-1507208773393-40d9fc670acf" alt="Article"
                            class="w-full h-40 object-cover">
                        <div class="absolute top-2 left-2 bg-white text-primary text-xs font-bold px-2 py-1 rounded">02
                        </div>
                    </a>
                    <div class="p-4 flex-grow">
                        <a href="#"
                            class="inline-block bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-0.5 rounded-full mb-2">Health</a>
                        <h3 class="font-bold mb-2">
                            <a href="#" class="hover:text-primary transition">Mindfulness Meditation: A
                                Beginner's Guide
                                to Mental Clarity</a>
                        </h3>
                        <div class="flex items-center text-xs text-gray-500">
                            <span>April 18, 2023</span>
                            <span class="mx-2">•</span>
                            <span>6 min read</span>
                        </div>
                    </div>
                </article>

                <!-- Post 3 -->
                <article
                    class="flex flex-col bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <a href="#" class="relative">
                        <img src="https://images.unsplash.com/photo-1526948128573-703ee1aeb6fa" alt="Article"
                            class="w-full h-40 object-cover">
                        <div class="absolute top-2 left-2 bg-white text-primary text-xs font-bold px-2 py-1 rounded">03
                        </div>
                    </a>
                    <div class="p-4 flex-grow">
                        <a href="#"
                            class="inline-block bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-0.5 rounded-full mb-2">Technology</a>
                        <h3 class="font-bold mb-2">
                            <a href="#" class="hover:text-primary transition">Web3 Explained: Understanding the
                                Next
                                Internet Revolution</a>
                        </h3>
                        <div class="flex items-center text-xs text-gray-500">
                            <span>April 15, 2023</span>
                            <span class="mx-2">•</span>
                            <span>7 min read</span>
                        </div>
                    </div>
                </article>

                <!-- Post 4 -->
                <article
                    class="flex flex-col bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                    <a href="#" class="relative">
                        <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b" alt="Article"
                            class="w-full h-40 object-cover">
                        <div class="absolute top-2 left-2 bg-white text-primary text-xs font-bold px-2 py-1 rounded">04
                        </div>
                    </a>
                    <div class="p-4 flex-grow">
                        <a href="#"
                            class="inline-block bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-0.5 rounded-full mb-2">Lifestyle</a>
                        <h3 class="font-bold mb-2">
                            <a href="#" class="hover:text-primary transition">Sustainable Fashion: How to Build
                                an
                                Eco-Friendly Wardrobe</a>
                        </h3>
                        <div class="flex items-center text-xs text-gray-500">
                            <span>April 12, 2023</span>
                            <span class="mx-2">•</span>
                            <span>5 min read</span>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <!-- Featured Authors -->
        <section class="mb-12">
            <h2 class="text-2xl font-bold mb-6">Featured Authors</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <!-- Author 1 -->
                <div class="bg-white rounded-xl p-6 text-center shadow-md hover:shadow-lg transition-shadow">
                    <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Emma Rodriguez"
                        class="w-24 h-24 rounded-full mx-auto mb-4">
                    <h3 class="font-bold text-lg">Emma Rodriguez</h3>
                    <p class="text-gray-600 text-sm mb-3">Technology Writer</p>
                    <p class="text-gray-500 text-sm mb-4">42 articles</p>
                    <a href="#" class="text-primary hover:underline text-sm font-medium">View Profile</a>
                </div>

                <!-- Author 2 -->
                <div class="bg-white rounded-xl p-6 text-center shadow-md hover:shadow-lg transition-shadow">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Alex Chen"
                        class="w-24 h-24 rounded-full mx-auto mb-4">
                    <h3 class="font-bold text-lg">Alex Chen</h3>
                    <p class="text-gray-600 text-sm mb-3">Software Developer</p>
                    <p class="text-gray-500 text-sm mb-4">38 articles</p>
                    <a href="#" class="text-primary hover:underline text-sm font-medium">View Profile</a>
                </div>

                <!-- Author 3 -->
                <div class="bg-white rounded-xl p-6 text-center shadow-md hover:shadow-lg transition-shadow">
                    <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Sophia Martinez"
                        class="w-24 h-24 rounded-full mx-auto mb-4">
                    <h3 class="font-bold text-lg">Sophia Martinez</h3>
                    <p class="text-gray-600 text-sm mb-3">Travel Blogger</p>
                    <p class="text-gray-500 text-sm mb-4">27 articles</p>
                    <a href="#" class="text-primary hover:underline text-sm font-medium">View Profile</a>
                </div>

                <!-- Author 4 -->
                <div class="bg-white rounded-xl p-6 text-center shadow-md hover:shadow-lg transition-shadow">
                    <img src="https://randomuser.me/api/portraits/men/52.jpg" alt="Dr. James Wilson"
                        class="w-24 h-24 rounded-full mx-auto mb-4">
                    <h3 class="font-bold text-lg">Dr. James Wilson</h3>
                    <p class="text-gray-600 text-sm mb-3">Health Expert</p>
                    <p class="text-gray-500 text-sm mb-4">23 articles</p>
                    <a href="#" class="text-primary hover:underline text-sm font-medium">View Profile</a>
                </div>
            </div>
        </section>
    </main>
@endsection
<!-- Footer -->
