@extends('layouts.app')
@section('title', 'Category')
@section('content')
    @push('style')
        <style>
            .gradient-bg {
                background: linear-gradient(135deg, #f093fb 0%, #f5576c 25%, #4facfe 50%, #00f2fe 75%, #667eea 100%);
                background-size: 300% 300%;
                animation: gradientShift 8s ease infinite;
            }

            @keyframes gradientShift {

                0%,
                100% {
                    background-position: 0% 50%;
                }

                50% {
                    background-position: 100% 50%;
                }
            }

            .card-hover {
                transition: all 0.3s ease;
            }

            .card-hover:hover {
                transform: translateY(-8px);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            }

            .filter-card {
                backdrop-filter: blur(10px);
                background: rgba(255, 255, 255, 0.95);
            }

            .search-focus:focus {
                box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            }

            .tag-hover {
                transition: all 0.2s ease;
            }

            .tag-hover:hover {
                transform: scale(1.05);
            }

            .fade-in {
                animation: fadeIn 0.6s ease-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .skeleton {
                background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
                background-size: 200% 100%;
                animation: loading 1.5s infinite;
            }

            @keyframes loading {
                0% {
                    background-position: 200% 0;
                }

                100% {
                    background-position: -200% 0;
                }
            }

            .breadcrumb-arrow::after {
                content: '>';
                margin: 0 8px;
                color: #9CA3AF;
            }

            .breadcrumb-arrow:last-child::after {
                display: none;
            }
        </style>
    @endpush

    <!-- Breadcrumb -->
    {{-- <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center text-sm">
                <a href="{{ route('home') }}" class="breadcrumb-arrow text-gray-500 hover:text-gray-700">Home</a>
                <a href="{{ route('categories.index') }}" class="breadcrumb-arrow text-gray-500 hover:text-gray-700">Categories</a>
                <span class="text-gray-900 font-medium">JavaScript</span>
            </nav>
        </div>
    </div> --}}

    <!-- Hero Section -->
    {{-- <section class="gradient-bg text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="max-w-3xl mx-auto">
                <div class="mb-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-white bg-opacity-20 rounded-full mb-4">
                        <i class="fab fa-js-square text-4xl text-yellow-300"></i>
                    </div>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Categories Articles</h1>
                <p class="text-xl text-purple-100 mb-6 max-w-2xl mx-auto">
                    Discover the latest insights, tutorials, and best practices in JavaScript development from our expert writers.
                </p>
                <div class="flex flex-wrap justify-center gap-4 text-sm">
                    <div class="bg-white bg-opacity-20 px-4 py-2 rounded-full">
                        <i class="fas fa-newspaper mr-2"></i>
                        <span id="articleCount">{{ $categories->flatMap->posts->pluck('title')->count() }} Articles</span>
                    </div>
                    <div class="bg-white bg-opacity-20 px-4 py-2 rounded-full">
                        <i class="fas fa-users mr-2"></i>
                        <span>{{ $categories->flatMap->posts->pluck('user_id')->count() }} Authors</span>
                    </div>
                    <div class="bg-white bg-opacity-20 px-4 py-2 rounded-full">
                        <i class="fas fa-eye mr-2"></i>
                        <span>2.3M Views</span>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Filters and Search -->
    {{-- <section class="py-8 -mt-8 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="filter-card rounded-lg shadow-lg p-6">
                <div class="grid lg:grid-cols-4 gap-6">
                    <!-- Search -->
                    <div class="lg:col-span-2">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Articles</label>
                        <div class="relative">
                            <input type="text" id="search" placeholder="Search by title, content, or author..."
                                class="search-focus w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Sort -->
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                        <select id="sort" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="newest">Newest First</option>
                            <option value="oldest">Oldest First</option>
                            <option value="popular">Most Popular</option>
                            <option value="views">Most Viewed</option>
                            <option value="title">Title A-Z</option>
                        </select>
                    </div>

                    <!-- Difficulty -->
                    <div>
                        <label for="difficulty" class="block text-sm font-medium text-gray-700 mb-2">Difficulty</label>
                        <select id="difficulty" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="all">All Levels</option>
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="advanced">Advanced</option>
                        </select>
                    </div>
                </div>

                <!-- Tags Filter -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Filter by Topics</label>
                    <div class="flex flex-wrap gap-2">
                        <button class="tag-filter tag-hover active bg-purple-600 text-white px-4 py-2 rounded-full text-sm font-medium transition-all" data-tag="all">
                            All Topics
                        </button>
                        <button class="tag-filter tag-hover bg-gray-200 text-gray-700 hover:bg-gray-300 px-4 py-2 rounded-full text-sm font-medium transition-all" data-tag="es6">
                            ES6+
                        </button>
                        <button class="tag-filter tag-hover bg-gray-200 text-gray-700 hover:bg-gray-300 px-4 py-2 rounded-full text-sm font-medium transition-all" data-tag="frameworks">
                            Frameworks
                        </button>
                        <button class="tag-filter tag-hover bg-gray-200 text-gray-700 hover:bg-gray-300 px-4 py-2 rounded-full text-sm font-medium transition-all" data-tag="nodejs">
                            Node.js
                        </button>
                        <button class="tag-filter tag-hover bg-gray-200 text-gray-700 hover:bg-gray-300 px-4 py-2 rounded-full text-sm font-medium transition-all" data-tag="performance">
                            Performance
                        </button>
                        <button class="tag-filter tag-hover bg-gray-200 text-gray-700 hover:bg-gray-300 px-4 py-2 rounded-full text-sm font-medium transition-all" data-tag="testing">
                            Testing
                        </button>
                        <button class="tag-filter tag-hover bg-gray-200 text-gray-700 hover:bg-gray-300 px-4 py-2 rounded-full text-sm font-medium transition-all" data-tag="async">
                            Async/Await
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Articles Grid -->
    <div class="py-16 bg-gray-50 flex justify-center items-center min-h-[400px]">
        <div class="max-w-xl w-full bg-white rounded-2xl shadow-xl p-8 fade-in">
            <div class="flex items-center justify-between mb-4">
                <span class="bg-yellow-100 text-yellow-800 text-xs px-3 py-1 rounded-full font-semibold">Intermediate</span>
                <span class="text-gray-400 text-xs">{{ $category->created_at->diffForHumans() }}</span>
            </div>
            <h3 class="text-2xl font-extrabold text-gray-900 mb-2 hover:text-purple-600 transition-colors text-center">
                <a href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a>
            </h3>
            <p class="text-gray-600 mb-6 text-center">
                {{ $category->description }}
            </p>
            <div class="flex items-center justify-center mb-6">
                <img src="/placeholder.svg?height=48&width=48" alt="Sarah Johnson"
                    class="w-12 h-12 rounded-full mr-3 border-2 border-purple-200 shadow">
                <a href="" class="text-base text-gray-900 font-bold hover:text-purple-600">{{ $category->name }}</a>
            </div>
            <div class="flex items-center justify-center text-gray-500 text-sm mb-6">
                <i class="far fa-eye mr-2"></i>
                <span>2.3K views</span>
            </div>
            <div class="flex flex-wrap justify-center gap-2">
                <span class="bg-purple-100 text-purple-800 text-xs px-3 py-1 rounded-full font-medium">ES6+</span>
                <span class="bg-purple-100 text-purple-800 text-xs px-3 py-1 rounded-full font-medium">Performance</span>
            </div>
        </div>
    </div>

    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Results Info -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $categories[0]->name }}</h2>
                    <p class="text-gray-600 mt-1">
                        Showing <span id="resultCount">12</span> of <span id="totalCount">127</span> articles
                    </p>
                </div>
                <div class="flex items-center space-x-4">
                    <button id="gridView" class="p-2 text-purple-600 bg-purple-100 rounded-lg">
                        <i class="fas fa-th-large"></i>
                    </button>
                    <button id="listView" class="p-2 text-gray-400 hover:text-gray-600 rounded-lg">
                        <i class="fas fa-list"></i>
                    </button>
                </div>
            </div>

            <!-- Loading State -->
            <div id="loadingState" class="hidden grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="skeleton h-48"></div>
                    <div class="p-6">
                        <div class="skeleton h-4 w-20 mb-3 rounded"></div>
                        <div class="skeleton h-6 w-full mb-3 rounded"></div>
                        <div class="skeleton h-4 w-full mb-2 rounded"></div>
                        <div class="skeleton h-4 w-3/4 rounded"></div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="skeleton h-48"></div>
                    <div class="p-6">
                        <div class="skeleton h-4 w-20 mb-3 rounded"></div>
                        <div class="skeleton h-6 w-full mb-3 rounded"></div>
                        <div class="skeleton h-4 w-full mb-2 rounded"></div>
                        <div class="skeleton h-4 w-3/4 rounded"></div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="skeleton h-48"></div>
                    <div class="p-6">
                        <div class="skeleton h-4 w-20 mb-3 rounded"></div>
                        <div class="skeleton h-6 w-full mb-3 rounded"></div>
                        <div class="skeleton h-4 w-full mb-2 rounded"></div>
                        <div class="skeleton h-4 w-3/4 rounded"></div>
                    </div>
                </div>
            </div>

            <!-- categories Grid -->
            <div id="articlesGrid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Article 1 -->
                @foreach ($categories as $category)
                    <article class="article-card card-hover bg-white rounded-lg shadow-lg overflow-hidden fade-in"
                        data-title="" data-author="Sarah Johnson" data-date="2024-12-15" data-views="2300"
                        data-difficulty="intermediate" data-tags="es6,performance">
                        <img src="/placeholder.svg?height=200&width=400" alt="JavaScript ES2024"
                            class="w-full h-48 object-cover">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <span
                                    class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">Intermediate</span>
                                <span class="text-gray-500 text-sm">{{ $category->created_at->diffForHumans() }}</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-purple-600 transition-colors">
                                <a href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a>
                            </h3>
                            <p class="text-gray-600 mb-4">
                                {{ $category->description }}
                            </p>
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <img src="/placeholder.svg?height=32&width=32" alt="Sarah Johnson"
                                        class="w-8 h-8 rounded-full mr-3">
                                    <a href=""><span
                                            class="text-sm text-gray-900 font-bold">{{ $category->name }}</span></a>
                                </div>
                                <div class="flex items-center text-gray-500 text-sm">
                                    <i class="far fa-eye mr-1"></i>
                                    <span>2.3K</span>
                                </div>
                            </div>
                            {{-- <div class="flex flex-wrap gap-2 mb-4">
                                <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full">ES6+</span>
                                <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full">Performance</span>
                            </div> --}}

                            <div class="flex gap-2">
                                <a href="{{ route('categories.edit', $category->id) }}"
                                    class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition">
                                        <i class="fas fa-trash mr-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach

            </div>

            <!-- No Results -->
            <div id="noResults" class="hidden text-center py-16">
                <div class="max-w-md mx-auto">
                    <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No articles found</h3>
                    <p class="text-gray-600 mb-6">Try adjusting your search criteria or browse all articles.</p>
                    <button id="clearFilters"
                        class="bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                        Clear All Filters
                    </button>
                </div>
            </div>
        </div>
    </section>
    <!-- Related Categories -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Explore Other Categories</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    // $iconMap;
                    $defaultIcon = 'fas fa-code';

                    function getCategoryIcon($categoryName, $iconMap, $defaultIcon)
                    {
                        $key = strtolower(trim($categoryName));
                        return $iconMap[$key] ?? $defaultIcon;
                    }
                @endphp

                @foreach ($relatedCategories as $category)
                    <a href="{{ route('categories.show', $category->id) }}"
                        class="group bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-all">
                        <div class="text-center">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4 group-hover:bg-blue-200 transition-colors">
                                <i
                                    class="{{ getCategoryIcon($category->name, $iconMap, $defaultIcon) }} text-2xl text-blue-600"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                {{ $category->name }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ $category->posts_count }} posts</p>
                            <span class="text-blue-600 font-medium group-hover:text-blue-700">Explore
                                {{ $category->name }} →</span>
                        </div>
                    </a>
                @endforeach

            </div>
        </div>
    </section>

    <!-- Newsletter -->
    {{-- <section class="py-16 bg-gray-900 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Stay Updated with JavaScript</h2>
            <p class="text-gray-300 mb-8 max-w-2xl mx-auto">
                Get the latest JavaScript articles, tutorials, and news delivered to your inbox weekly.
            </p>
            <form class="max-w-md mx-auto flex gap-4">
                <input type="email" placeholder="Enter your email"
                    class="flex-1 px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-purple-500">
                <button type="submit"
                    class="bg-purple-600 px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                    Subscribe
                </button>
            </form>
        </div>
    </section> --}}

    @push('script')
        <script>
            // Global variables
            let allArticles = [];
            let filteredArticles = [];
            let currentView = 'grid';

            // Initialize the page
            document.addEventListener('DOMContentLoaded', function() {
                loadArticles();
                setupEventListeners();
            });

            function loadArticles() {
                // Get all article cards and store their data
                const articleCards = document.querySelectorAll('.article-card');
                allArticles = Array.from(articleCards).map(card => ({
                    element: card,
                    title: card.dataset.title.toLowerCase(),
                    author: card.dataset.author.toLowerCase(),
                    date: new Date(card.dataset.date),
                    views: parseInt(card.dataset.views),
                    difficulty: card.dataset.difficulty,
                    tags: card.dataset.tags.split(',')
                }));
                filteredArticles = [...allArticles];
                updateResultsCount();
            }

            function setupEventListeners() {
                // Search functionality
                const searchInput = document.getElementById('search');
                searchInput.addEventListener('input', debounce(handleSearch, 300));

                // Sort functionality
                const sortSelect = document.getElementById('sort');
                sortSelect.addEventListener('change', handleSort);

                // Difficulty filter
                const difficultySelect = document.getElementById('difficulty');
                difficultySelect.addEventListener('change', handleDifficultyFilter);

                // Tag filters
                const tagFilters = document.querySelectorAll('.tag-filter');
                tagFilters.forEach(tag => {
                    tag.addEventListener('click', handleTagFilter);
                });

                // View toggle
                const gridViewBtn = document.getElementById('gridView');
                const listViewBtn = document.getElementById('listView');
                gridViewBtn.addEventListener('click', () => toggleView('grid'));
                listViewBtn.addEventListener('click', () => toggleView('list'));

                // Clear filters
                const clearFiltersBtn = document.getElementById('clearFilters');
                clearFiltersBtn.addEventListener('click', clearAllFilters);
            }

            function handleSearch(event) {
                const searchTerm = event.target.value.toLowerCase();
                showLoading();

                setTimeout(() => {
                    filteredArticles = allArticles.filter(article =>
                        article.title.includes(searchTerm) ||
                        article.author.includes(searchTerm)
                    );
                    applyAllFilters();
                    hideLoading();
                }, 500);
            }

            function handleSort(event) {
                const sortBy = event.target.value;
                showLoading();

                setTimeout(() => {
                    switch (sortBy) {
                        case 'newest':
                            filteredArticles.sort((a, b) => b.date - a.date);
                            break;
                        case 'oldest':
                            filteredArticles.sort((a, b) => a.date - b.date);
                            break;
                        case 'popular':
                        case 'views':
                            filteredArticles.sort((a, b) => b.views - a.views);
                            break;
                        case 'title':
                            filteredArticles.sort((a, b) => a.title.localeCompare(b.title));
                            break;
                    }
                    renderArticles();
                    hideLoading();
                }, 300);
            }

            function handleDifficultyFilter(event) {
                const difficulty = event.target.value;
                showLoading();

                setTimeout(() => {
                    if (difficulty === 'all') {
                        applyAllFilters();
                    } else {
                        filteredArticles = allArticles.filter(article =>
                            article.difficulty === difficulty
                        );
                        applyAllFilters();
                    }
                    hideLoading();
                }, 300);
            }

            function handleTagFilter(event) {
                const tagButtons = document.querySelectorAll('.tag-filter');
                const clickedTag = event.target.dataset.tag;

                // Update active state
                tagButtons.forEach(btn => {
                    btn.classList.remove('active', 'bg-purple-600', 'text-white');
                    btn.classList.add('bg-gray-200', 'text-gray-700');
                });

                event.target.classList.add('active', 'bg-purple-600', 'text-white');
                event.target.classList.remove('bg-gray-200', 'text-gray-700');

                showLoading();

                setTimeout(() => {
                    if (clickedTag === 'all') {
                        applyAllFilters();
                    } else {
                        filteredArticles = allArticles.filter(article =>
                            article.tags.includes(clickedTag)
                        );
                        applyAllFilters();
                    }
                    hideLoading();
                }, 300);
            }

            function applyAllFilters() {
                const searchTerm = document.getElementById('search').value.toLowerCase();
                const difficulty = document.getElementById('difficulty').value;
                const activeTag = document.querySelector('.tag-filter.active').dataset.tag;

                filteredArticles = allArticles.filter(article => {
                    const matchesSearch = !searchTerm ||
                        article.title.includes(searchTerm) ||
                        article.author.includes(searchTerm);

                    const matchesDifficulty = difficulty === 'all' ||
                        article.difficulty === difficulty;

                    const matchesTag = activeTag === 'all' ||
                        article.tags.includes(activeTag);

                    return matchesSearch && matchesDifficulty && matchesTag;
                });

                renderArticles();
            }

            function renderArticles() {
                const grid = document.getElementById('articlesGrid');
                const noResults = document.getElementById('noResults');

                // Hide all articles first
                allArticles.forEach(article => {
                    article.element.style.display = 'none';
                });

                if (filteredArticles.length === 0) {
                    noResults.classList.remove('hidden');
                    grid.style.display = 'none';
                } else {
                    noResults.classList.add('hidden');
                    grid.style.display = 'grid';

                    // Show filtered articles
                    filteredArticles.forEach((article, index) => {
                        article.element.style.display = 'block';
                        article.element.style.animationDelay = `${index * 0.1}s`;
                    });
                }

                updateResultsCount();
            }

            function toggleView(view) {
                const gridBtn = document.getElementById('gridView');
                const listBtn = document.getElementById('listView');
                const grid = document.getElementById('articlesGrid');

                currentView = view;

                if (view === 'grid') {
                    gridBtn.classList.add('text-purple-600', 'bg-purple-100');
                    gridBtn.classList.remove('text-gray-400');
                    listBtn.classList.add('text-gray-400');
                    listBtn.classList.remove('text-purple-600', 'bg-purple-100');

                    grid.classList.remove('grid-cols-1');
                    grid.classList.add('md:grid-cols-2', 'lg:grid-cols-3');
                } else {
                    listBtn.classList.add('text-purple-600', 'bg-purple-100');
                    listBtn.classList.remove('text-gray-400');
                    gridBtn.classList.add('text-gray-400');
                    gridBtn.classList.remove('text-purple-600', 'bg-purple-100');

                    grid.classList.add('grid-cols-1');
                    grid.classList.remove('md:grid-cols-2', 'lg:grid-cols-3');
                }
            }

            function clearAllFilters() {
                // Reset search
                document.getElementById('search').value = '';

                // Reset sort
                document.getElementById('sort').value = 'newest';

                // Reset difficulty
                document.getElementById('difficulty').value = 'all';

                // Reset tags
                const tagButtons = document.querySelectorAll('.tag-filter');
                tagButtons.forEach(btn => {
                    btn.classList.remove('active', 'bg-purple-600', 'text-white');
                    btn.classList.add('bg-gray-200', 'text-gray-700');
                });
                tagButtons[0].classList.add('active', 'bg-purple-600', 'text-white');
                tagButtons[0].classList.remove('bg-gray-200', 'text-gray-700');

                // Reset articles
                filteredArticles = [...allArticles];
                renderArticles();
            }

            function updateResultsCount() {
                document.getElementById('resultCount').textContent = filteredArticles.length;
                document.getElementById('totalCount').textContent = allArticles.length;
                document.getElementById('articleCount').textContent = `${allArticles.length} Articles`;
            }

            function showLoading() {
                document.getElementById('loadingState').classList.remove('hidden');
                document.getElementById('articlesGrid').style.opacity = '0.5';
            }

            function hideLoading() {
                document.getElementById('loadingState').classList.add('hidden');
                document.getElementById('articlesGrid').style.opacity = '1';
            }

            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

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
        </script>
    @endpush

@endsection
