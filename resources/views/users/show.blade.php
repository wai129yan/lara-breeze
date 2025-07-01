@extends('layouts.app')
@section('title', 'Users')
@section('content')
    @push('style')
        <style>
            .gradient-bg {
                background: linear-gradient(-45deg, #6b6c6e, #454446, #4b484b, #28181a, #384149, #00f2fe);
                background-size: 400% 400%;
                animation: gradientShift 15s ease infinite;
                position: relative;
                overflow: hidden;
            }

            .gradient-bg::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" style="stop-color:rgba(255,255,255,0.1)"/><stop offset="100%" style="stop-color:rgba(255,255,255,0)"/></radialGradient></defs><circle cx="200" cy="200" r="100" fill="url(%23a)"><animate attributeName="cx" values="200;800;200" dur="20s" repeatCount="indefinite"/><animate attributeName="cy" values="200;600;200" dur="15s" repeatCount="indefinite"/></circle><circle cx="800" cy="300" r="150" fill="url(%23a)"><animate attributeName="cx" values="800;200;800" dur="25s" repeatCount="indefinite"/><animate attributeName="cy" values="300;700;300" dur="18s" repeatCount="indefinite"/></circle><circle cx="400" cy="600" r="80" fill="url(%23a)"><animate attributeName="cx" values="400;700;400" dur="22s" repeatCount="indefinite"/><animate attributeName="cy" values="600;200;600" dur="16s" repeatCount="indefinite"/></circle></svg>') no-repeat center center;
                background-size: cover;
                opacity: 0.3;
                animation: float 20s ease-in-out infinite;
            }

            .gradient-bg::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: radial-gradient(circle at 20% 80%, rgba(110, 110, 112, 0.3) 0%, transparent 50%),
                    radial-gradient(circle at 80% 20%, rgba(40, 39, 39, 0.39) 0%, transparent 50%),
                    radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.3) 0%, transparent 50%);
                animation: pulse 8s ease-in-out infinite alternate;
            }

            @keyframes gradientShift {
                0% {
                    background-position: 0% 50%;
                }

                50% {
                    background-position: 100% 50%;
                }

                100% {
                    background-position: 0% 50%;
                }
            }

            @keyframes float {

                0%,
                100% {
                    transform: translateY(0px) rotate(0deg);
                }

                33% {
                    transform: translateY(-30px) rotate(120deg);
                }

                66% {
                    transform: translateY(-60px) rotate(240deg);
                }
            }

            @keyframes pulse {
                0% {
                    opacity: 0.5;
                    transform: scale(1);
                }

                100% {
                    opacity: 0.8;
                    transform: scale(1.1);
                }
            }

            .hero-content {
                position: relative;
                z-index: 10;
            }

            .floating-shapes {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                overflow: hidden;
                z-index: 1;
            }

            .shape {
                position: absolute;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 50%;
                animation: floatUp 15s infinite linear;
            }

            .shape:nth-child(1) {
                width: 80px;
                height: 80px;
                left: 10%;
                animation-delay: 0s;
                animation-duration: 15s;
            }

            .shape:nth-child(2) {
                width: 120px;
                height: 120px;
                left: 20%;
                animation-delay: 2s;
                animation-duration: 18s;
            }

            .shape:nth-child(3) {
                width: 60px;
                height: 60px;
                left: 70%;
                animation-delay: 4s;
                animation-duration: 12s;
            }

            .shape:nth-child(4) {
                width: 100px;
                height: 100px;
                left: 80%;
                animation-delay: 6s;
                animation-duration: 20s;
            }

            .shape:nth-child(5) {
                width: 40px;
                height: 40px;
                left: 50%;
                animation-delay: 8s;
                animation-duration: 14s;
            }

            @keyframes floatUp {
                0% {
                    transform: translateY(100vh) rotate(0deg);
                    opacity: 0;
                }

                10% {
                    opacity: 1;
                }

                90% {
                    opacity: 1;
                }

                100% {
                    transform: translateY(-100px) rotate(360deg);
                    opacity: 0;
                }
            }

            .card-hover {
                transition: all 0.3s ease;
            }

            .card-hover:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }

            .social-icon {
                transition: all 0.3s ease;
            }

            .social-icon:hover {
                transform: scale(1.1);
            }

            .author-image {
                animation: profileFloat 6s ease-in-out infinite;
                box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.3), 0 0 0 8px rgba(255, 255, 255, 0.1);
            }

            @keyframes profileFloat {

                0%,
                100% {
                    transform: translateY(0px);
                }

                50% {
                    transform: translateY(-10px);
                }
            }
        </style>
    @endpush

    <!-- Hero Section -->
    <section class="gradient-bg text-gray-300  py-20 relative">
        <!-- Floating Shapes -->
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center hero-content">
            <div class="mb-8">
                <img src="/placeholder.svg?height=150&width=150" alt="Sarah Johnson"
                    class="author-image w-32 h-32 rounded-full mx-auto mb-6 border-4 border-white">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $user->name }}</h1>
                <p class="text-xl md:text-2xl text-purple-100 mb-6">{{ $user->bio }}</p>
                <div class="flex justify-center space-x-6 mb-8">
                    <a href="#" class="social-icon text-white hover:text-purple-200">
                        <i class="fab fa-twitter text-2xl"></i>
                    </a>
                    <a href="#" class="social-icon text-white hover:text-purple-200">
                        <i class="fab fa-linkedin text-2xl"></i>
                    </a>
                    <a href="#" class="social-icon text-white hover:text-purple-200">
                        <i class="fab fa-github text-2xl"></i>
                    </a>
                    <a href="#" class="social-icon text-white hover:text-purple-200">
                        <i class="fab fa-instagram text-2xl"></i>
                    </a>
                </div>
                <button id="followBtn"
                    class="bg-white text-purple-600 px-8 py-3 rounded-full font-semibold hover:bg-purple-50 transition-colors">
                    <i class="fas fa-plus mr-2"></i>Follow
                </button>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-white py-12 -mt-10 relative z-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="text-3xl font-bold text-gray-900 mb-2">127</div>
                        <div class="text-gray-600">Articles</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900 mb-2">45K</div>
                        <div class="text-gray-600">Followers</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900 mb-2">892K</div>
                        <div class="text-gray-600">Views</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-900 mb-2">4.8</div>
                        <div class="text-gray-600">Rating</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-8 mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">About {{ $user->name }}</h2>
                <div class="prose prose-lg max-w-none text-gray-700">
                    <p class="mb-4">
                        Sarah is a passionate tech writer and digital nomad with over 8 years of experience in the
                        technology industry.
                        She specializes in making complex technical concepts accessible to everyone, from beginners to
                        seasoned professionals.
                    </p>
                    <p class="mb-4">
                        Currently traveling the world while working remotely, Sarah shares her insights on web
                        development,
                        artificial intelligence, and the future of technology. Her articles have been featured in major
                        tech publications
                        and have helped thousands of developers advance their careers.
                    </p>
                    <p>
                        When she's not writing, you can find her exploring new cities, trying local cuisines,
                        or contributing to open-source projects on GitHub.
                    </p>
                </div>

                <div class="mt-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Expertise</h3>
                    <div class="flex flex-wrap gap-2">
                        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">JavaScript</span>
                        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">React</span>
                        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">Node.js</span>
                        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">AI/ML</span>
                        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">Cloud
                            Computing</span>
                        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">DevOps</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Posts Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Latest Articles</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Explore Sarah's latest insights on technology, development, and digital nomad lifestyle.
                </p>
            </div>

            <!-- Filter Buttons -->
            <div class="flex flex-wrap justify-center gap-4 mb-12">
                <button
                    class="filter-btn active bg-purple-600 text-white px-6 py-2 rounded-full font-medium transition-colors"
                    data-filter="all">
                    All Posts
                </button>
                <button
                    class="filter-btn bg-white text-gray-700 px-6 py-2 rounded-full font-medium hover:bg-gray-100 transition-colors"
                    data-filter="javascript">
                    JavaScript
                </button>
                <button
                    class="filter-btn bg-white text-gray-700 px-6 py-2 rounded-full font-medium hover:bg-gray-100 transition-colors"
                    data-filter="react">
                    React
                </button>
                <button
                    class="filter-btn bg-white text-gray-700 px-6 py-2 rounded-full font-medium hover:bg-gray-100 transition-colors"
                    data-filter="ai">
                    AI/ML
                </button>
                <button
                    class="filter-btn bg-white text-gray-700 px-6 py-2 rounded-full font-medium hover:bg-gray-100 transition-colors"
                    data-filter="lifestyle">
                    Lifestyle
                </button>
            </div>

            <!-- Blog Posts Grid -->
            <div id="postsGrid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Post 1 -->
                <article class="post-card card-hover bg-white rounded-lg shadow-lg overflow-hidden"
                    data-category="javascript">
                    <img src="/placeholder.svg?height=200&width=400" alt="JavaScript ES2024"
                        class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">JavaScript</span>
                            <span class="text-gray-500 text-sm ml-auto">Dec 15, 2024</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-purple-600 transition-colors">
                            <a href="#">JavaScript ES2024: New Features You Should Know</a>
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Explore the latest JavaScript features that will revolutionize how you write code in 2024.
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-gray-500 text-sm">
                                <i class="far fa-eye mr-1"></i>
                                <span>2.3K views</span>
                            </div>
                            <div class="flex items-center text-gray-500 text-sm">
                                <i class="far fa-heart mr-1"></i>
                                <span>156 likes</span>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Post 2 -->
                <article class="post-card card-hover bg-white rounded-lg shadow-lg overflow-hidden" data-category="react">
                    <img src="/placeholder.svg?height=200&width=400" alt="React Performance"
                        class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">React</span>
                            <span class="text-gray-500 text-sm ml-auto">Dec 12, 2024</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-purple-600 transition-colors">
                            <a href="#">Optimizing React Performance: Advanced Techniques</a>
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Learn advanced React optimization techniques to build lightning-fast applications.
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-gray-500 text-sm">
                                <i class="far fa-eye mr-1"></i>
                                <span>1.8K views</span>
                            </div>
                            <div class="flex items-center text-gray-500 text-sm">
                                <i class="far fa-heart mr-1"></i>
                                <span>203 likes</span>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Post 3 -->
                <article class="post-card card-hover bg-white rounded-lg shadow-lg overflow-hidden" data-category="ai">
                    <img src="/placeholder.svg?height=200&width=400" alt="AI Development"
                        class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">AI/ML</span>
                            <span class="text-gray-500 text-sm ml-auto">Dec 10, 2024</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-purple-600 transition-colors">
                            <a href="#">Building AI-Powered Web Applications</a>
                        </h3>
                        <p class="text-gray-600 mb-4">
                            A comprehensive guide to integrating AI capabilities into your web applications.
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-gray-500 text-sm">
                                <i class="far fa-eye mr-1"></i>
                                <span>3.1K views</span>
                            </div>
                            <div class="flex items-center text-gray-500 text-sm">
                                <i class="far fa-heart mr-1"></i>
                                <span>287 likes</span>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Post 4 -->
                <article class="post-card card-hover bg-white rounded-lg shadow-lg overflow-hidden"
                    data-category="lifestyle">
                    <img src="/placeholder.svg?height=200&width=400" alt="Digital Nomad"
                        class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-pink-100 text-pink-800 text-xs px-2 py-1 rounded-full">Lifestyle</span>
                            <span class="text-gray-500 text-sm ml-auto">Dec 8, 2024</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-purple-600 transition-colors">
                            <a href="#">Digital Nomad Setup: My Remote Work Essentials</a>
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Everything you need to know about setting up a productive remote work environment.
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-gray-500 text-sm">
                                <i class="far fa-eye mr-1"></i>
                                <span>1.5K views</span>
                            </div>
                            <div class="flex items-center text-gray-500 text-sm">
                                <i class="far fa-heart mr-1"></i>
                                <span>124 likes</span>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Post 5 -->
                <article class="post-card card-hover bg-white rounded-lg shadow-lg overflow-hidden"
                    data-category="javascript">
                    <img src="/placeholder.svg?height=200&width=400" alt="Node.js" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">JavaScript</span>
                            <span class="text-gray-500 text-sm ml-auto">Dec 5, 2024</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-purple-600 transition-colors">
                            <a href="#">Node.js Best Practices for 2024</a>
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Essential Node.js practices every developer should follow for scalable applications.
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-gray-500 text-sm">
                                <i class="far fa-eye mr-1"></i>
                                <span>2.7K views</span>
                            </div>
                            <div class="flex items-center text-gray-500 text-sm">
                                <i class="far fa-heart mr-1"></i>
                                <span>198 likes</span>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Post 6 -->
                <article class="post-card card-hover bg-white rounded-lg shadow-lg overflow-hidden" data-category="react">
                    <img src="/placeholder.svg?height=200&width=400" alt="React Hooks" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">React</span>
                            <span class="text-gray-500 text-sm ml-auto">Dec 3, 2024</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-purple-600 transition-colors">
                            <a href="#">Custom React Hooks: Building Reusable Logic</a>
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Master the art of creating custom React hooks for cleaner, more maintainable code.
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-gray-500 text-sm">
                                <i class="far fa-eye mr-1"></i>
                                <span>1.9K views</span>
                            </div>
                            <div class="flex items-center text-gray-500 text-sm">
                                <i class="far fa-heart mr-1"></i>
                                <span>167 likes</span>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Load More Button -->
            <div class="text-center mt-12">
                <button id="loadMoreBtn"
                    class="bg-purple-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-purple-700 transition-colors">
                    Load More Articles
                </button>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-16 bg-gray-900 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Stay Updated</h2>
            <p class="text-gray-300 mb-8 max-w-2xl mx-auto">
                Subscribe to Sarah's newsletter and get the latest articles, tips, and insights delivered directly to
                your inbox.
            </p>
            <form id="newsletterForm" class="max-w-md mx-auto flex gap-4">
                <input type="email" placeholder="Enter your email"
                    class="flex-1 px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-500">
                <button type="submit"
                    class="bg-purple-600 px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                    Subscribe
                </button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white py-12 border-t">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Sarah Johnson</h3>
                    <p class="text-gray-600 mb-4">
                        Tech writer and digital nomad sharing insights on web development, AI, and remote work
                        lifestyle.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-purple-600 transition-colors">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-purple-600 transition-colors">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-purple-600 transition-colors">
                            <i class="fab fa-github text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-purple-600 transition-colors">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-600 hover:text-purple-600 transition-colors">About</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-purple-600 transition-colors">Articles</a>
                        </li>
                        <li><a href="#" class="text-gray-600 hover:text-purple-600 transition-colors">Speaking</a>
                        </li>
                        <li><a href="#" class="text-gray-600 hover:text-purple-600 transition-colors">Contact</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4">Categories</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-600 hover:text-purple-600 transition-colors">JavaScript</a>
                        </li>
                        <li><a href="#" class="text-gray-600 hover:text-purple-600 transition-colors">React</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-purple-600 transition-colors">AI/ML</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-purple-600 transition-colors">Lifestyle</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t mt-8 pt-8 text-center text-gray-600">
                <p>&copy; 2024 Sarah Johnson. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @push('script')
        <script>
            // Follow button functionality
            const followBtn = document.getElementById('followBtn');
            let isFollowing = false;

            followBtn.addEventListener('click', function() {
                if (isFollowing) {
                    this.innerHTML = '<i class="fas fa-plus mr-2"></i>Follow';
                    this.classList.remove('bg-purple-100', 'text-purple-600');
                    this.classList.add('bg-white', 'text-purple-600');
                    isFollowing = false;
                } else {
                    this.innerHTML = '<i class="fas fa-check mr-2"></i>Following';
                    this.classList.remove('bg-white', 'text-purple-600');
                    this.classList.add('bg-purple-100', 'text-purple-600');
                    isFollowing = true;
                }
            });

            // Filter functionality
            const filterBtns = document.querySelectorAll('.filter-btn');
            const postCards = document.querySelectorAll('.post-card');

            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterBtns.forEach(b => {
                        b.classList.remove('active', 'bg-purple-600', 'text-white');
                        b.classList.add('bg-white', 'text-gray-700');
                    });

                    // Add active class to clicked button
                    this.classList.add('active', 'bg-purple-600', 'text-white');
                    this.classList.remove('bg-white', 'text-gray-700');

                    const filter = this.getAttribute('data-filter');

                    // Filter posts
                    postCards.forEach(card => {
                        if (filter === 'all' || card.getAttribute('data-category') === filter) {
                            card.style.display = 'block';
                            setTimeout(() => {
                                card.style.opacity = '1';
                                card.style.transform = 'translateY(0)';
                            }, 100);
                        } else {
                            card.style.opacity = '0';
                            card.style.transform = 'translateY(20px)';
                            setTimeout(() => {
                                card.style.display = 'none';
                            }, 300);
                        }
                    });
                });
            });

            // Newsletter form
            const newsletterForm = document.getElementById('newsletterForm');
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const email = this.querySelector('input[type="email"]').value;
                if (email) {
                    alert('Thank you for subscribing! You\'ll receive Sarah\'s latest articles in your inbox.');
                    this.reset();
                }
            });

            // Load more functionality
            const loadMoreBtn = document.getElementById('loadMoreBtn');
            loadMoreBtn.addEventListener('click', function() {
                // Simulate loading more posts
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Loading...';
                this.disabled = true;

                setTimeout(() => {
                    alert('More articles loaded! (This is a demo)');
                    this.innerHTML = 'Load More Articles';
                    this.disabled = false;
                }, 2000);
            });

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Add scroll effect to navigation
            window.addEventListener('scroll', function() {
                const nav = document.querySelector('nav');
                if (window.scrollY > 100) {
                    nav.classList.add('shadow-lg');
                } else {
                    nav.classList.remove('shadow-lg');
                }
            });

            // Animate stats on scroll
            const observerOptions = {
                threshold: 0.5,
                rootMargin: '0px 0px -100px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const stats = entry.target.querySelectorAll('.text-3xl');
                        stats.forEach(stat => {
                            const finalValue = parseInt(stat.textContent.replace(/[^\d]/g, ''));
                            animateValue(stat, 0, finalValue, 2000);
                        });
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            const statsSection = document.querySelector('.grid.grid-cols-2.md\\:grid-cols-4');
            if (statsSection) {
                observer.observe(statsSection);
            }

            function animateValue(element, start, end, duration) {
                const range = end - start;
                const increment = range / (duration / 16);
                let current = start;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= end) {
                        current = end;
                        clearInterval(timer);
                    }
                    const suffix = element.textContent.replace(/[\d.]/g, '');
                    element.textContent = Math.floor(current) + suffix;
                }, 16);
            }
        </script>
    @endpush

@endsection
