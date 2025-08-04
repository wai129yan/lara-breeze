@extends('layouts.app')
@section('title', 'Post Details')
@section('content')
    @push('style')
        <style>
            body {
                background: #f8f9fa;
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
                    <div class="flex gap-2">
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('posts.show', $post->slug)) }}&text={{ urlencode($post->title) }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-400 hover:bg-blue-500 text-white rounded-lg transition-colors"
                            target="_blank">
                            <i class="fab fa-twitter mr-2"></i>
                            Share on Twitter
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors"
                            target="_blank">
                            <i class="fab fa-facebook-f mr-2"></i>
                            Share on Facebook
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . url()->current()) }}"
                            class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors"
                            target="_blank">
                            <i class="fab fa-whatsapp mr-2"></i>
                            Share on WhatsApp
                        </a>
                    </div>
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
            // UI Controller Module
            const UIController = {
                elements: {
                    article: document.querySelector('.article-content'),
                    readingProgress: document.querySelector('.reading-progress'),
                    sections: document.querySelectorAll('section[id]'),
                    tocLinks: document.querySelectorAll('.toc-link'),
                    floatingToc: document.querySelector('.floating-toc'),
                    socialShare: document.querySelector('.social-share'),
                    copyButtons: document.querySelectorAll('.copy-button'),
                    likeBtn: document.getElementById('likeBtn'),
                    bookmarkBtn: document.getElementById('bookmarkBtn'),
                    zoomImages: document.querySelectorAll('.zoom-image'),
                    imageModal: document.getElementById('imageModal'),
                    closeModal: document.getElementById('closeModal'),
                    commentForm: document.getElementById('commentForm')
                },

                updateReadingProgress() {
                    try {
                        const { article, readingProgress } = this.elements;
                        if (!article || !readingProgress) return;

                        const scrollTop = window.pageYOffset;
                        const docHeight = article.offsetHeight;
                        const winHeight = window.innerHeight;
                        const scrollPercent = scrollTop / (docHeight - winHeight);
                        const scrollPercentRounded = Math.round(scrollPercent * 100);

                        readingProgress.style.width = Math.min(scrollPercentRounded, 100) + '%';
                    } catch (error) {
                        console.error('Error updating reading progress:', error);
                    }
                },

                updateTOC() {
                    try {
                        const { sections, tocLinks } = this.elements;
                        if (!sections.length || !tocLinks.length) return;

                        let current = '';
                        sections.forEach(section => {
                            const sectionTop = section.offsetTop;
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
                    } catch (error) {
                        console.error('Error updating TOC:', error);
                    }
                },

                toggleFloatingElements() {
                    try {
                        const { floatingToc, socialShare } = this.elements;
                        if (!floatingToc || !socialShare) return;

                        const scrollY = window.pageYOffset;
                        const shouldShow = scrollY > 500;

                        floatingToc.classList.toggle('hidden', !shouldShow);
                        socialShare.classList.toggle('hidden', !shouldShow);
                    } catch (error) {
                        console.error('Error toggling floating elements:', error);
                    }
                },

                showToast(message, type = 'info') {
                    const toast = document.createElement('div');
                    const bgColor = type === 'error' ? 'bg-red-500' : 'bg-gray-900';
                    toast.className = `fixed bottom-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-y-full opacity-0 transition-all duration-300`;
                    toast.textContent = message;
                    document.body.appendChild(toast);

                    requestAnimationFrame(() => {
                        toast.classList.remove('translate-y-full', 'opacity-0');
                    });

                    setTimeout(() => {
                        toast.classList.add('translate-y-full', 'opacity-0');
                        setTimeout(() => toast.remove(), 300);
                    }, 3000);
                }
            };

            // Event Handlers Module
            const EventHandlers = {
                handleCopyCode(button) {
                    const codeBlock = button.parentElement.querySelector('code');
                    if (!codeBlock) return;

                    navigator.clipboard.writeText(codeBlock.textContent)
                        .then(() => {
                            button.innerHTML = '<i class="fas fa-check mr-1"></i>Copied!';
                            setTimeout(() => {
                                button.innerHTML = '<i class="fas fa-copy mr-1"></i>Copy';
                            }, 2000);
                        })
                        .catch(error => {
                            console.error('Error copying code:', error);
                            UIController.showToast('Failed to copy code', 'error');
                        });
                },

                handleLikeClick() {
                    try {
                        const icon = this.querySelector('i');
                        const countSpan = document.getElementById('likeCount');
                        const count = parseInt(countSpan.textContent);

                        const isLiked = icon.classList.contains('far');
                        icon.classList.toggle('far', !isLiked);
                        icon.classList.toggle('fas', isLiked);
                        this.classList.toggle('text-red-500', isLiked);
                        countSpan.textContent = count + (isLiked ? 1 : -1);

                        if (isLiked) UIController.showToast('Thanks for liking!');
                    } catch (error) {
                        console.error('Error handling like click:', error);
                        UIController.showToast('Failed to update like status', 'error');
                    }
                },

                handleBookmarkClick() {
                    try {
                        const icon = this.querySelector('i');
                        const isBookmarked = icon.classList.contains('far');

                        icon.classList.toggle('far', !isBookmarked);
                        icon.classList.toggle('fas', isBookmarked);
                        this.classList.toggle('text-purple-600', isBookmarked);

                        UIController.showToast(isBookmarked ? 'Article bookmarked!' : 'Bookmark removed');
                    } catch (error) {
                        console.error('Error handling bookmark click:', error);
                        UIController.showToast('Failed to update bookmark status', 'error');
                    }
                },

                handleImageZoom(img) {
                    const { imageModal } = UIController.elements;
                    if (!imageModal) return;

                    const modalImg = imageModal.querySelector('#modalImage');
                    if (modalImg) {
                        modalImg.src = img.src;
                        imageModal.classList.add('active');
                    }
                },

                handleCommentSubmit(e) {
                    e.preventDefault();
                    const textarea = e.target.querySelector('textarea');
                    if (!textarea) return;

                    const comment = textarea.value.trim();
                    if (comment) {
                        // Here you would typically send the comment to your backend
                        UIController.showToast('Comment posted successfully!');
                        textarea.value = '';
                    }
                }
            };

            // Social Sharing Module
const SocialSharing = {
    shareUrls: {
        twitter: (url, title) => `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`,
        facebook: (url) => `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`,
        linkedin: (url) => `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`,
        whatsapp: (url, title) => `https://wa.me/?text=${encodeURIComponent(title + ' ' + url)}`
    },

    async copyToClipboard(button, text) {
        try {
            await navigator.clipboard.writeText(text);
            button.innerHTML = '<i class="fas fa-check text-xl"></i>';
            setTimeout(() => {
                button.innerHTML = '<i class="fas fa-link text-xl"></i>';
            }, 2000);
            UIController.showToast('Link copied to clipboard!');
        } catch (error) {
            console.error('Error copying to clipboard:', error);
            UIController.showToast('Failed to copy link', 'error');
        }
    },

    share(platform, button) {
        const url = window.location.href;
        const title = document.title;

        if (platform === 'copy') {
            this.copyToClipboard(button, url);
            return;
        }

        const shareUrl = this.shareUrls[platform]?.(url, title);
        if (shareUrl) {
            window.open(shareUrl, '_blank', 'width=600,height=400');
        }
    },

    init() {
        document.querySelectorAll('.social-btn').forEach(button => {
            button.addEventListener('click', () => {
                const platform = button.dataset.platform;
                this.share(platform, button);
            });
        });
    }
};

// Initialize Event Listeners
function initializeEventListeners() {
    const { elements } = UIController;

    // Initialize social sharing
    SocialSharing.init();

    // Scroll events with throttling
    let ticking = false;
    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                UIController.updateReadingProgress();
                UIController.updateTOC();
                UIController.toggleFloatingElements();
                ticking = false;
            });
            ticking = true;
        }
    });

                // Copy code buttons
                elements.copyButtons?.forEach(button => {
                    button.addEventListener('click', () => EventHandlers.handleCopyCode(button));
                });

                // Like button
                elements.likeBtn?.addEventListener('click', EventHandlers.handleLikeClick);

                // Bookmark button
                elements.bookmarkBtn?.addEventListener('click', EventHandlers.handleBookmarkClick);

                // Image zoom
                elements.zoomImages?.forEach(img => {
                    img.addEventListener('click', () => EventHandlers.handleImageZoom(img));
                });

                // Modal close
                elements.closeModal?.addEventListener('click', () => {
                    elements.imageModal?.classList.remove('active');
                });

                elements.imageModal?.addEventListener('click', (e) => {
                    if (e.target === e.currentTarget) {
                        e.currentTarget.classList.remove('active');
                    }
                });

                // Comment form
                elements.commentForm?.addEventListener('submit', EventHandlers.handleCommentSubmit);

                // Smooth scrolling for TOC links
                elements.tocLinks?.forEach(link => {
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        const targetId = link.getAttribute('href')?.substring(1);
                        const targetElement = targetId ? document.getElementById(targetId) : null;
                        targetElement?.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    });
                });
            }

            // Initialize on DOM load
            document.addEventListener('DOMContentLoaded', () => {
                initializeEventListeners();
                UIController.updateReadingProgress();
                UIController.updateTOC();
                UIController.toggleFloatingElements();
            });
        </script>
    @endpush
@endsection
