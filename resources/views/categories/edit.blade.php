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
    @if (session('success'))
        <div class="mb-6">
            <div
                class="bg-blue-500 border border-blue-700 text-white px-6 py-4 rounded-lg text-center font-semibold shadow">
                {{ session('success') }}
            </div>
        </div>
    @endif
    <section class="py-12 flex items-center justify-center min-h-[60vh]">
        <div class="w-full max-w-2xl">
            <!-- Add hidden placeholders for JS selectors to prevent errors -->
            <div class="hidden">
                <span id="resultCount">1</span>
                <span id="totalCount">1</span>
                <span id="articleCount">1 Articles</span>
                <div id="loadingState" class="hidden"></div>
                <div id="noResults" class="hidden"></div>
            </div>
            <div id="articlesGrid" class="flex justify-center">
                <article
                    class="article-card card-hover bg-white rounded-2xl shadow-2xl overflow-hidden fade-in w-full max-w-xl">
                    <form action="{{ route('categories.update', $category->id) }}" method="POST" class="p-8 space-y-6">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-semibold mb-2">Category Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                required>
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
                            <textarea id="description" name="description" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                required>{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('categories.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm rounded-lg hover:bg-gray-300 transition font-semibold shadow">
                                <i class="fas fa-arrow-left mr-2"></i> Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition font-semibold shadow">
                                <i class="fas fa-save mr-2"></i> Update Category
                            </button>
                        </div>
                    </form>
                </article>
            </div>
        </div>

    </section>

    <!-- Related Categories -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Explore Other Categories</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="#" class="group bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-all">
                    <div class="text-center">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4 group-hover:bg-blue-200 transition-colors">
                            <i class="fab fa-react text-2xl text-blue-600"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">React</h3>
                        <p class="text-gray-600 text-sm mb-4">89 Articles</p>
                        <span class="text-blue-600 font-medium group-hover:text-blue-700">Explore React →</span>
                    </div>
                </a>

                <a href="#" class="group bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-all">
                    <div class="text-center">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4 group-hover:bg-green-200 transition-colors">
                            <i class="fab fa-node-js text-2xl text-green-600"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Node.js</h3>
                        <p class="text-gray-600 text-sm mb-4">67 Articles</p>
                        <span class="text-green-600 font-medium group-hover:text-green-700">Explore Node.js →</span>
                    </div>
                </a>

                <a href="#" class="group bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-all">
                    <div class="text-center">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 bg-purple-100 rounded-full mb-4 group-hover:bg-purple-200 transition-colors">
                            <i class="fas fa-robot text-2xl text-purple-600"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">AI/ML</h3>
                        <p class="text-gray-600 text-sm mb-4">43 Articles</p>
                        <span class="text-purple-600 font-medium group-hover:text-purple-700">Explore AI/ML →</span>
                    </div>
                </a>

                <a href="#" class="group bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-all">
                    <div class="text-center">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 bg-pink-100 rounded-full mb-4 group-hover:bg-pink-200 transition-colors">
                            <i class="fas fa-paint-brush text-2xl text-pink-600"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">CSS</h3>
                        <p class="text-gray-600 text-sm mb-4">78 Articles</p>
                        <span class="text-pink-600 font-medium group-hover:text-pink-700">Explore CSS →</span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-16 bg-gray-900 text-white">
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
