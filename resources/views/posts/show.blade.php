@extends('layouts.app')
@section('title', 'Post Details')
@section('content')
    @push('style')
        <style>
            body {
                background: #a17979;
            }

            .reading-progress {
                position: fixed;
                top: 0;
                left: 0;
                width: 0%;
                height: 3px;
                background: linear-gradient(90deg, #667eea, #764ba2);
                z-index: 1000;
                transition: width 0.1s ease;
            }

            .floating-toc {
                position: fixed;
                right: 2rem;
                top: 50%;
                transform: translateY(-50%);
                max-height: 60vh;
                overflow-y: auto;
                backdrop-filter: blur(10px);
                background: rgba(255, 255, 255, 0.95);
                border: 1px solid rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
            }

            .floating-toc.hidden {
                opacity: 0;
                pointer-events: none;
                transform: translateY(-50%) translateX(100%);
            }

            .toc-link {
                transition: all 0.2s ease;
            }

            .toc-link.active {
                background: #f3f4f6;
                border-left: 3px solid #667eea;
            }

            .social-share {
                position: fixed;
                left: 2rem;
                top: 50%;
                transform: translateY(-50%);
                z-index: 1000;
                backdrop-filter: blur(10px);
                background: rgba(255, 255, 255, 0.95);
                border: 1px solid rgba(0, 0, 0, 0.1);
            }

            /* .social-share.hidden {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        opacity: 0;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        pointer-events: none;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        transform: translateY(-50%) translateX(-100%);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } */

            .highlight-selection {
                background: linear-gradient(120deg, #a8edea 0%, #fed6e3 100%);
                padding: 2px 4px;
                border-radius: 3px;
            }

            .code-block {
                position: relative;
            }

            .copy-button {
                position: absolute;
                top: 0.5rem;
                right: 0.5rem;
                opacity: 0;
                transition: opacity 0.2s ease;
            }

            .code-block:hover .copy-button {
                opacity: 1;
            }

            .article-content h2,
            .article-content h3,
            .article-content h4 {
                scroll-margin-top: 100px;
            }

            .zoom-image {
                cursor: zoom-in;
                transition: transform 0.3s ease;
            }

            .zoom-image:hover {
                transform: scale(1.02);
            }

            .modal-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.9);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 1000;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.3s ease;
            }

            .modal-overlay.active {
                opacity: 1;
                pointer-events: all;
            }

            .modal-image {
                max-width: 90%;
                max-height: 90%;
                object-fit: contain;
            }

            .breadcrumb-arrow::after {
                content: '>';
                margin: 0 8px;
                color: #9CA3AF;
            }

            .breadcrumb-arrow:last-child::after {
                display: none;
            }

            @media (max-width: 1024px) {

                .floating-toc,
                .social-share {
                    display: none;
                }
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

            .pulse-animation {
                animation: pulse 2s infinite;
            }

            @keyframes pulse {

                0%,
                100% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.5;
                }
            }
        </style>
    @endpush

    {{-- <h1 class="text-3xl font-bold text-center my-6">Post Details</h1> --}}
    {{-- social share --}}
    @include('section.social-shares')

    <!-- Article Header -->
    <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <header class="mb-12 fade-in">
            <div class="mb-6">
                <div class="flex flex-wrap items-center gap-3 mb-4">
                    @foreach ($post->tags as $tag)
                        <span
                            class="bg-yellow-100 text-yellow-800 text-sm px-3 py-1 rounded-full font-medium">{{ $tag->name }}
                        </span>
                    @endforeach
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight mb-6">
                    {{ $post->title }}
                </h1>
                <p class="text-xl text-gray-600 leading-relaxed">
                    {{ $post->content }}
                </p>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-4 py-6 border-t border-b border-gray-200">
                <div class="flex items-center space-x-4">
                    <img src="/placeholder.svg?height=48&width=48" alt="Sarah Johnson" class="w-12 h-12 rounded-full">
                    <div>
                        <div class="flex items-center space-x-2">
                            <a href="#"
                                class="font-semibold text-gray-900 hover:text-purple-600">{{ $post->user->name }}</a>
                            <span class="text-blue-500">
                                <i class="fas fa-check-circle text-sm"></i>
                            </span>
                        </div>
                        {{-- <p class="text-sm text-gray-600">Senior JavaScript Developer</p> --}}
                    </div>
                </div>

                <div class="flex items-center space-x-6 text-sm text-gray-600">
                    <div class="flex items-center space-x-1">
                        <i class="far fa-calendar"></i>
                        <span>{{ $post->created_at->format('F j, Y') }}</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <i class="far fa-clock"></i>
                        <span>{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <i class="far fa-eye"></i>
                        <span>{{ $post->view_counts }}</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Article Content -->
        {{-- <div class="article-content prose prose-lg max-w-none">
            <div class="mb-8">
                <img src="/placeholder.svg?height=400&width=800" alt="JavaScript ES2024 Features"
                    class="zoom-image w-full rounded-lg shadow-lg">
            </div>

            <section id="introduction" class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Introduction</h2>
                <p class="text-gray-700 leading-relaxed mb-6">
                    JavaScript continues to evolve at a rapid pace, and ES2024 brings some exciting new features that
                    will
                    make our code more expressive, performant, and maintainable. In this comprehensive guide, we'll
                    explore
                    the most significant additions to the language and how they can improve your development workflow.
                </p>
                <p class="text-gray-700 leading-relaxed mb-6">
                    Whether you're a seasoned JavaScript developer or just getting started with modern ES features,
                    this article will help you understand and implement these new capabilities in your projects.
                </p>

                <div class="bg-blue-50 border-l-4 border-blue-400 p-6 my-8 rounded-r-lg">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-400 mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-semibold text-blue-900 mb-2">What's New in ES2024?</h4>
                            <p class="text-blue-800">
                                ES2024 introduces several groundbreaking features including improved array methods,
                                better async handling, and enhanced developer tooling support.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </div> --}}

        <!-- Article Footer -->
        <footer class="border-t border-gray-200 pt-8 mt-12">
            <div class="flex flex-wrap items-center justify-between mb-8">
                <div class="w-[300px] flex gap-2">
                    @foreach ($post->tags as $tag)
                        <div class="flex">
                            <span
                                class="bg-purple-100 text-purple-800 text-sm px-3 py-1 rounded-full ">{{ $tag->name }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="flex items-center space-x-4">
                    <button id="likeBtn"
                        class="flex items-center space-x-2 text-gray-600 hover:text-red-500 transition-colors">
                        <i class="fa-solid fa-hands-clapping"></i>
                        <span id="likeCount">{{ $post->clapCounts() }}</span>
                    </button>
                    <button class="flex items-center space-x-2 text-gray-600 hover:text-blue-500 transition-colors">
                        <i class="far fa-comment"></i>
                        <span>23</span>
                    </button>
                    <button class="flex items-center space-x-2 text-gray-600 hover:text-green-500 transition-colors">
                        <i class="fas fa-share"></i>
                        <span>Share</span>
                    </button>
                </div>
            </div>

            <!-- Author Bio -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <div class="flex items-start space-x-4">
                    <img src="/placeholder.svg?height=80&width=80" alt="Sarah Johnson" class="w-20 h-20 rounded-full">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-2">
                            <h3 class="text-xl font-semibold text-gray-900">{{ $post->user->name }}</h3>
                            <span class="text-blue-500">
                                <i class="fas fa-check-circle"></i>
                            </span>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Senior JavaScript Developer with 8+ years of experience in web development.
                            Passionate about modern JavaScript, performance optimization, and developer education.
                        </p>
                        <div class="flex items-center space-x-4">
                            <a href="#" class="text-purple-600 hover:text-purple-700 font-medium">View Profile</a>
                            <button
                                class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                                Follow
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </article>

    <!-- Comments List -->
    @include('posts.section.comments-section')

    {{-- related articles --}}
    @include('posts.section.related-articles')

    @push('script')
        <script>
            // Reading progress bar
            function updateReadingProgress() {
                const article = document.querySelector('.article-content');
                const scrollTop = window.pageYOffset;
                const docHeight = article.offsetHeight;
                const winHeight = window.innerHeight;
                const scrollPercent = scrollTop / (docHeight - winHeight);
                const scrollPercentRounded = Math.round(scrollPercent * 100);

                document.querySelector('.reading-progress').style.width = Math.min(scrollPercentRounded, 100) + '%';
            }

            // Table of contents active link
            function updateTOC() {
                const sections = document.querySelectorAll('section[id]');
                const tocLinks = document.querySelectorAll('.toc-link');

                let current = '';
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.clientHeight;
                    if (window.pageYOffset >= sectionTop - 200) {
                        current = section.getAttribute('id');
                    }
                });

                tocLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === '#' + current) {
                        link.classList.add('active');
                    }
                });
            }

            // Show/hide floating elements
            function toggleFloatingElements() {
                const toc = document.querySelector('.floating-toc');
                const socialShare = document.querySelector('.social-share');
                const scrollY = window.pageYOffset;

                if (scrollY > 500) {
                    toc.classList.remove('hidden');
                    socialShare.classList.remove('hidden');
                } else {
                    toc.classList.add('hidden');
                    socialShare.classList.add('hidden');
                }
            }

            // Scroll event listener
            window.addEventListener('scroll', () => {
                updateReadingProgress();
                updateTOC();
                toggleFloatingElements();
            });

            // Copy code functionality
            document.querySelectorAll('.copy-button').forEach(button => {
                button.addEventListener('click', () => {
                    const codeBlock = button.parentElement.querySelector('code');
                    const text = codeBlock.textContent;

                    navigator.clipboard.writeText(text).then(() => {
                        button.innerHTML = '<i class="fas fa-check mr-1"></i>Copied!';
                        setTimeout(() => {
                            button.innerHTML = '<i class="fas fa-copy mr-1"></i>Copy';
                        }, 2000);
                    });
                });
            });

            // Social sharing
            document.querySelectorAll('.social-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const platform = button.dataset.platform;
                    const url = window.location.href;
                    const title = document.title;

                    let shareUrl = '';
                    switch (platform) {
                        case 'twitter':
                            shareUrl =
                                `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`;
                            break;
                        case 'facebook':
                            shareUrl =
                                `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
                            break;
                        case 'linkedin':
                            shareUrl =
                                `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`;
                            break;
                        case 'whatsapp':
                            shareUrl = `https://wa.me/?text=${encodeURIComponent(title + ' ' + url)}`;
                            break;
                        case 'copy':
                            navigator.clipboard.writeText(url).then(() => {
                                button.innerHTML = '<i class="fas fa-check text-xl"></i>';
                                setTimeout(() => {
                                    button.innerHTML = '<i class="fas fa-link text-xl"></i>';
                                }, 2000);
                            });
                            return;
                    }

                    if (shareUrl) {
                        window.open(shareUrl, '_blank', 'width=600,height=400');
                    }
                });
            });

            // Bookmark functionality
            document.getElementById('bookmarkBtn').addEventListener('click', function() {
                const icon = this.querySelector('i');
                if (icon.classList.contains('far')) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    this.classList.add('text-purple-600');
                    // Show toast notification
                    showToast('Article bookmarked!');
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    this.classList.remove('text-purple-600');
                    showToast('Bookmark removed');
                }
            });

            // Like functionality
            document.getElementById('likeBtn').addEventListener('click', function() {
                const icon = this.querySelector('i');
                const countSpan = document.getElementById('likeCount');
                let count = parseInt(countSpan.textContent);

                if (icon.classList.contains('far')) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    this.classList.add('text-red-500');
                    countSpan.textContent = count + 1;
                    showToast('Thanks for liking!');
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    this.classList.remove('text-red-500');
                    countSpan.textContent = count - 1;
                }
            });

            // Image zoom functionality
            document.querySelectorAll('.zoom-image').forEach(img => {
                img.addEventListener('click', () => {
                    const modal = document.getElementById('imageModal');
                    const modalImg = document.getElementById('modalImage');
                    modalImg.src = img.src;
                    modal.classList.add('active');
                });
            });

            document.getElementById('closeModal').addEventListener('click', () => {
                document.getElementById('imageModal').classList.remove('active');
            });

            document.getElementById('imageModal').addEventListener('click', (e) => {
                if (e.target === e.currentTarget) {
                    e.currentTarget.classList.remove('active');
                }
            });

            // Comment form
            document.getElementById('commentForm').addEventListener('submit', (e) => {
                e.preventDefault();
                const textarea = e.target.querySelector('textarea');
                if (textarea.value.trim()) {
                    showToast('Comment posted successfully!');
                    textarea.value = '';
                }
            });

            // Toast notification
            function showToast(message) {
                const toast = document.createElement('div');
                toast.className =
                    'fixed bottom-4 right-4 bg-gray-900 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-y-full opacity-0 transition-all duration-300';
                toast.textContent = message;
                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.classList.remove('translate-y-full', 'opacity-0');
                }, 100);

                setTimeout(() => {
                    toast.classList.add('translate-y-full', 'opacity-0');
                    setTimeout(() => {
                        document.body.removeChild(toast);
                    }, 300);
                }, 3000);
            }

            // Smooth scrolling for TOC links
            document.querySelectorAll('.toc-link').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const targetId = link.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Initialize
            document.addEventListener('DOMContentLoaded', () => {
                updateReadingProgress();
                updateTOC();
                toggleFloatingElements();
            });
        </script>
    @endpush
@endsection
