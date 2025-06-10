<?php

namespace App\Helpers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogHelper
{
    /**
     * Generate a unique slug for a post
     */
    public static function generateSlug(string $title, ?int $postId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (self::slugExists($slug, $postId)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Check if slug exists
     */
    private static function slugExists(string $slug, ?int $postId = null): bool
    {
        $query = Post::where('slug', $slug);

        if ($postId) {
            $query->where('id', '!=', $postId);
        }

        return $query->exists();
    }

    /**
     * Generate excerpt from content
     */
    public static function generateExcerpt(string $content, int $length = 150): string
    {
        $content = strip_tags($content);
        $content = preg_replace('/\s+/', ' ', $content);
        $content = trim($content);

        if (strlen($content) <= $length) {
            return $content;
        }

        return substr($content, 0, $length) . '...';
    }

    /**
     * Calculate reading time
     */
    public static function calculateReadingTime(string $content): int
    {
        $wordCount = str_word_count(strip_tags($content));
        $averageWordsPerMinute = 200;

        return max(1, ceil($wordCount / $averageWordsPerMinute));
    }

    /**
     * Get popular posts
     */
    public static function getPopularPosts(int $limit = 5): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember('popular_posts', 3600, function () use ($limit) {
            return Post::published()
                ->withCount(['comments', 'views'])
                ->orderByDesc('views_count')
                ->orderByDesc('comments_count')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get recent posts
     */
    public static function getRecentPosts(int $limit = 5): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember('recent_posts', 1800, function () use ($limit) {
            return Post::published()
                ->latest('published_at')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get related posts based on tags or categories
     */
    public static function getRelatedPosts(Post $post, int $limit = 4): \Illuminate\Database\Eloquent\Collection
    {
        $cacheKey = "related_posts_{$post->id}_{$limit}";

        return Cache::remember($cacheKey, 3600, function () use ($post, $limit) {
            $query = Post::published()
                ->where('id', '!=', $post->id);

            // If post has tags, find posts with similar tags
            if ($post->tags && $post->tags->count() > 0) {
                $tagIds = $post->tags->pluck('id');
                $query->whereHas('tags', function ($q) use ($tagIds) {
                    $q->whereIn('id', $tagIds);
                });
            }
            // If post has categories, find posts in same categories
            elseif ($post->categories && $post->categories->count() > 0) {
                $categoryIds = $post->categories->pluck('id');
                $query->whereHas('categories', function ($q) use ($categoryIds) {
                    $q->whereIn('id', $categoryIds);
                });
            }
            // Fallback to same author
            else {
                $query->where('user_id', $post->user_id);
            }

            return $query->inRandomOrder()->limit($limit)->get();
        });
    }

    /**
     * Get post statistics
     */
    public static function getPostStats(Post $post): array
    {
        return [
            'views' => $post->views_count ?? 0,
            'comments' => $post->comments_count ?? $post->comments()->count(),
            'likes' => $post->likes_count ?? 0,
            'shares' => $post->shares_count ?? 0,
            'reading_time' => self::calculateReadingTime($post->content),
            'word_count' => str_word_count(strip_tags($post->content)),
        ];
    }

    /**
     * Format publish date
     */
    public static function formatPublishDate(Carbon $date, string $format = null): string
    {
        if ($format) {
            return $date->format($format);
        }

        $now = Carbon::now();

        if ($date->isToday()) {
            return 'Today at ' . $date->format('g:i A');
        } elseif ($date->isYesterday()) {
            return 'Yesterday at ' . $date->format('g:i A');
        } elseif ($date->diffInDays($now) <= 7) {
            return $date->diffForHumans();
        } else {
            return $date->format('M j, Y');
        }
    }

    /**
     * Clean and sanitize content
     */
    public static function sanitizeContent(string $content): string
    {
        // Remove malicious scripts
        $content = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $content);

        // Allow only safe HTML tags
        $allowedTags = '<p><br><strong><b><em><i><u><a><ul><ol><li><h1><h2><h3><h4><h5><h6><blockquote><img><code><pre>';

        return strip_tags($content, $allowedTags);
    }

    /**
     * Generate meta description
     */
    public static function generateMetaDescription(Post $post): string
    {
        if ($post->meta_description) {
            return $post->meta_description;
        }

        return self::generateExcerpt($post->content, 160);
    }

    /**
     * Generate breadcrumbs
     */
    public static function generateBreadcrumbs(Post $post): array
    {
        $breadcrumbs = [
            ['title' => 'Home', 'url' => route('home')],
            ['title' => 'Blog', 'url' => route('blog.index')],
        ];

        if ($post->categories && $post->categories->count() > 0) {
            $category = $post->categories->first();
            $breadcrumbs[] = [
                'title' => $category->name,
                'url' => route('blog.category', $category->slug)
            ];
        }

        $breadcrumbs[] = [
            'title' => $post->title,
            'url' => route('blog.show', $post->slug)
        ];

        return $breadcrumbs;
    }

    /**
     * Get author statistics
     */
    public static function getAuthorStats(User $author): array
    {
        return Cache::remember("author_stats_{$author->id}", 3600, function () use ($author) {
            return [
                'total_posts' => $author->posts()->published()->count(),
                'total_comments' => Comment::whereHas('post', function ($q) use ($author) {
                    $q->where('user_id', $author->id);
                })->count(),
                'total_views' => $author->posts()->published()->sum('views_count'),
                'joined_date' => $author->created_at,
                'last_post_date' => $author->posts()->published()->latest('published_at')->value('published_at'),
            ];
        });
    }

    /**
     * Check if post is trending
     */
    public static function isTrending(Post $post): bool
    {
        $weekAgo = Carbon::now()->subWeek();

        return $post->created_at->gte($weekAgo) &&
            ($post->views_count > 100 || $post->comments_count > 5);
    }

    /**
     * Generate social sharing URLs
     */
    public static function getSocialSharingUrls(Post $post): array
    {
        $url = route('blog.show', $post->slug);
        $title = urlencode($post->title);
        $description = urlencode(self::generateExcerpt($post->content, 100));

        return [
            'facebook' => "https://www.facebook.com/sharer/sharer.php?u={$url}",
            'twitter' => "https://twitter.com/intent/tweet?url={$url}&text={$title}",
            'linkedin' => "https://www.linkedin.com/sharing/share-offsite/?url={$url}",
            'pinterest' => "https://pinterest.com/pin/create/button/?url={$url}&description={$description}",
            'reddit' => "https://reddit.com/submit?url={$url}&title={$title}",
            'telegram' => "https://t.me/share/url?url={$url}&text={$title}",
            'whatsapp' => "https://wa.me/?text={$title}%20{$url}",
        ];
    }

    /**
     * Process uploaded images
     */
    public static function processUploadedImage($file, string $folder = 'blog'): array
    {
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs("public/{$folder}", $filename);

        // Generate thumbnail
        $thumbnailPath = self::generateThumbnail($path, $folder);

        return [
            'original' => Storage::url($path),
            'thumbnail' => $thumbnailPath ? Storage::url($thumbnailPath) : null,
            'filename' => $filename,
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ];
    }

    /**
     * Generate thumbnail for image
     */
    private static function generateThumbnail(string $imagePath, string $folder): ?string
    {
        try {
            $image = imagecreatefromstring(Storage::get($imagePath));
            if (!$image)
                return null;

            $width = imagesx($image);
            $height = imagesy($image);

            // Calculate thumbnail dimensions
            $thumbWidth = 300;
            $thumbHeight = (int) ($height * ($thumbWidth / $width));

            $thumbnail = imagecreatetruecolor($thumbWidth, $thumbHeight);
            imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);

            $thumbnailPath = "public/{$folder}/thumbnails/" . basename($imagePath);

            ob_start();
            imagejpeg($thumbnail, null, 85);
            $thumbnailData = ob_get_clean();

            Storage::put($thumbnailPath, $thumbnailData);

            imagedestroy($image);
            imagedestroy($thumbnail);

            return $thumbnailPath;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get blog statistics
     */
    public static function getBlogStats(): array
    {
        return Cache::remember('blog_stats', 3600, function () {
            return [
                'total_posts' => Post::published()->count(),
                'total_authors' => User::whereHas('posts', function ($q) {
                    $q->where('status', 'published');
                })->count(),
                'total_comments' => Comment::count(),
                'total_views' => Post::sum('views_count'),
                'posts_this_month' => Post::published()
                    ->whereMonth('published_at', Carbon::now()->month)
                    ->count(),
                'most_popular_post' => Post::published()
                    ->orderByDesc('views_count')
                    ->first(),
            ];
        });
    }

    /**
     * Clear blog caches
     */
    public static function clearBlogCaches(): void
    {
        $cacheKeys = [
            'popular_posts',
            'recent_posts',
            'blog_stats',
        ];

        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }

        // Clear author stats cache
        User::whereHas('posts')->chunk(100, function ($users) {
            foreach ($users as $user) {
                Cache::forget("author_stats_{$user->id}");
            }
        });

        // Clear related posts cache
        Post::chunk(100, function ($posts) {
            foreach ($posts as $post) {
                Cache::forget("related_posts_{$post->id}_4");
            }
        });
    }

    /**
     * Search posts
     */
    public static function searchPosts(string $query, int $perPage = 10)
    {
        return Post::published()
            ->where(function ($q) use ($query) {
                $q
                    ->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('content', 'LIKE', "%{$query}%")
                    ->orWhere('excerpt', 'LIKE', "%{$query}%");
            })
            ->orWhereHas('tags', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->orWhereHas('categories', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->orderByDesc('published_at')
            ->paginate($perPage);
    }
}