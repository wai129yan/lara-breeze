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
                <img src="{{ asset('storage/images/' . $category->featured_image) }}" alt="Sarah Johnson"
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
                    <button id="gridView4" class="p-2 text-purple-600 bg-purple-100 rounded-lg">
                        <i class="fas fa-th-large"></i>
                    </button>
                    <button id="listView4" class="p-2 text-gray-400 hover:text-gray-600 rounded-lg">
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
            <div id="articlesGrid4" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
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

                            {{-- <div class="flex gap-2">
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
                            </div> --}}
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
                    title: card.dataset.title ? card.dataset.title.toLowerCase() : '',
                    author: card.dataset.author ? card.dataset.author.toLowerCase() : '',
                    date: card.dataset.date ? new Date(card.dataset.date) : new Date(),
                    views: parseInt(card.dataset.views) || 0,
                    difficulty: card.dataset.difficulty || 'beginner',
                    tags: card.dataset.tags ? card.dataset.tags.split(',') : []
                }));
                filteredArticles = [...allArticles];
                updateResultsCount();
            }

            function setupEventListeners() {
                // Search functionality
                const searchInput = document.getElementById('search');
                if (searchInput) {
                    searchInput.addEventListener('input', debounce(handleSearch, 300));
                }

                // Sort functionality
                const sortSelect = document.getElementById('sort');
                if (sortSelect) {
                    sortSelect.addEventListener('change', handleSort);
                }

                // Difficulty filter
                const difficultySelect = document.getElementById('difficulty');
                if (difficultySelect) {
                    difficultySelect.addEventListener('change', handleDifficultyFilter);
                }

                // Tag filters
                const tagFilters = document.querySelectorAll('.tag-filter');
                tagFilters.forEach(tag => {
                    tag.addEventListener('click', handleTagFilter);
                });

                // View toggle - Fixed the function names
                const gridViewBtn = document.getElementById('gridView4');
                const listViewBtn = document.getElementById('listView4');

                if (gridViewBtn) {
                    gridViewBtn.addEventListener('click', () => toggleView('grid'));
                }
                if (listViewBtn) {
                    listViewBtn.addEventListener('click', () => toggleView('list'));
                }

                // Clear filters
                const clearFiltersBtn = document.getElementById('clearFilters');
                if (clearFiltersBtn) {
                    clearFiltersBtn.addEventListener('click', clearAllFilters);
                }
            }

            function handleSearch(event) {
                const searchTerm = event.target.value.toLowerCase();
                showLoading();

                setTimeout(() => {
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
                    applyAllFilters();
                    hideLoading();
                }, 300);
            }

            function handleTagFilter(event) {
                const tagButtons = document.querySelectorAll('.tag-filter');

                // Update active state
                tagButtons.forEach(btn => {
                    btn.classList.remove('active', 'bg-purple-600', 'text-white');
                    btn.classList.add('bg-gray-200', 'text-gray-700');
                });

                event.target.classList.add('active', 'bg-purple-600', 'text-white');
                event.target.classList.remove('bg-gray-200', 'text-gray-700');

                showLoading();

                setTimeout(() => {
                    applyAllFilters();
                    hideLoading();
                }, 300);
            }

            function applyAllFilters() {
                const searchInput = document.getElementById('search');
                const difficultySelect = document.getElementById('difficulty');
                const activeTagElement = document.querySelector('.tag-filter.active');

                const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
                const difficulty = difficultySelect ? difficultySelect.value : 'all';
                const activeTag = activeTagElement ? activeTagElement.dataset.tag : 'all';

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
                const grid = document.getElementById('articlesGrid4');
                const noResults = document.getElementById('noResults');

                if (!grid) return;

                // Hide all articles first
                allArticles.forEach(article => {
                    article.element.style.display = 'none';
                });

                if (filteredArticles.length === 0) {
                    if (noResults) noResults.classList.remove('hidden');
                    grid.style.display = 'none';
                } else {
                    if (noResults) noResults.classList.add('hidden');
                    grid.style.display = 'grid';

                    // Show filtered articles
                    filteredArticles.forEach((article, index) => {
                        article.element.style.display = 'block';
                        article.element.style.animationDelay = `${index * 0.1}s`;
                    });
                }

                updateResultsCount();
            }

            // Fixed the toggle view function
            function toggleView(view) {
                const gridBtn = document.getElementById('gridView4');
                const listBtn = document.getElementById('listView4');
                const grid = document.getElementById('articlesGrid4');

                if (!gridBtn || !listBtn || !grid) return;

                currentView = view;

                if (view === 'grid') {
                    // Grid view styling
                    gridBtn.classList.add('text-purple-600', 'bg-purple-100');
                    gridBtn.classList.remove('text-gray-400');
                    listBtn.classList.add('text-gray-400');
                    listBtn.classList.remove('text-purple-600', 'bg-purple-100');

                    // Grid layout
                    grid.className = 'grid md:grid-cols-2 lg:grid-cols-3 gap-8';

                    // Reset article cards to normal grid style
                    const articleCards = grid.querySelectorAll('.article-card');
                    articleCards.forEach(card => {
                        card.className =
                            'article-card card-hover bg-white rounded-lg shadow-lg overflow-hidden fade-in';
                    });

                } else {
                    // List view styling
                    listBtn.classList.add('text-purple-600', 'bg-purple-100');
                    listBtn.classList.remove('text-gray-400');
                    gridBtn.classList.add('text-gray-400');
                    gridBtn.classList.remove('text-purple-600', 'bg-purple-100');

                    // List layout
                    grid.className = 'grid grid-cols-1 gap-6';

                    // Style article cards for list view
                    const articleCards = grid.querySelectorAll('.article-card');
                    articleCards.forEach(card => {
                        card.className =
                            'article-card card-hover bg-white rounded-lg shadow-lg overflow-hidden fade-in flex flex-col md:flex-row';

                        // Adjust image for list view
                        const img = card.querySelector('img');
                        if (img) {
                            img.className = 'w-full md:w-48 h-48 md:h-auto object-cover';
                        }

                        // Adjust content for list view
                        const content = card.querySelector('.p-6');
                        if (content) {
                            content.className = 'p-6 flex-1';
                        }
                    });
                }
            }

            function clearAllFilters() {
                // Reset search
                const searchInput = document.getElementById('search');
                if (searchInput) searchInput.value = '';

                // Reset sort
                const sortSelect = document.getElementById('sort');
                if (sortSelect) sortSelect.value = 'newest';

                // Reset difficulty
                const difficultySelect = document.getElementById('difficulty');
                if (difficultySelect) difficultySelect.value = 'all';

                // Reset tags
                const tagButtons = document.querySelectorAll('.tag-filter');
                tagButtons.forEach(btn => {
                    btn.classList.remove('active', 'bg-purple-600', 'text-white');
                    btn.classList.add('bg-gray-200', 'text-gray-700');
                });
                if (tagButtons[0]) {
                    tagButtons[0].classList.add('active', 'bg-purple-600', 'text-white');
                    tagButtons[0].classList.remove('bg-gray-200', 'text-gray-700');
                }

                // Reset articles
                filteredArticles = [...allArticles];
                renderArticles();
            }

            function updateResultsCount() {
                const resultCountEl = document.getElementById('resultCount');
                const totalCountEl = document.getElementById('totalCount');
                const articleCountEl = document.getElementById('articleCount');

                if (resultCountEl) resultCountEl.textContent = filteredArticles.length;
                if (totalCountEl) totalCountEl.textContent = allArticles.length;
                if (articleCountEl) articleCountEl.textContent = `${allArticles.length} Articles`;
            }

            function showLoading() {
                const loadingState = document.getElementById('loadingState');
                const articlesGrid = document.getElementById('articlesGrid4');

                if (loadingState) loadingState.classList.remove('hidden');
                if (articlesGrid) articlesGrid.style.opacity = '0.5';
            }

            function hideLoading() {
                const loadingState = document.getElementById('loadingState');
                const articlesGrid = document.getElementById('articlesGrid4');

                if (loadingState) loadingState.classList.add('hidden');
                if (articlesGrid) articlesGrid.style.opacity = '1';
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
