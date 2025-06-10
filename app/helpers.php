<?php

use App\Helpers\BlogHelper;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;

if (!function_exists('generate_slug')) {
    function generate_slug(string $title, ?int $postId = null): string
    {
        return BlogHelper::generateSlug($title, $postId);
    }
}

if (!function_exists('excerpt')) {
    function excerpt(string $content, int $length = 150): string
    {
        return BlogHelper::generateExcerpt($content, $length);
    }
}

if (!function_exists('reading_time')) {
    function reading_time(string $content): int
    {
        return BlogHelper::calculateReadingTime($content);
    }
}

if (!function_exists('format_date')) {
    function format_date($date): string
    {
        return BlogHelper::formatPublishDate($date);
    }
}

if (!function_exists('social_links')) {
    function social_links(Post $post): array
    {
        return BlogHelper::getSocialSharingUrls($post);
    }
}

if (!function_exists('is_trending')) {
    function is_trending(Post $post): bool
    {
        return BlogHelper::isTrending($post);
    }
}

if (!function_exists('author_stats')) {
    function author_stats(User $author): array
    {
        return BlogHelper::getAuthorStats($author);
    }
}

if (!function_exists('sanitize_html')) {
    function sanitize_html(string $content): string
    {
        return BlogHelper::sanitizeContent($content);
    }
}

if (!function_exists('blog_stats')) {
    function blog_stats(): array
    {
        return BlogHelper::getBlogStats();
    }
}

if (!function_exists('seo_title')) {
    function seo_title(?string $title = null): string
    {
        $siteTitle = config('app.name');
        return $title ? "{$title} - {$siteTitle}" : $siteTitle;
    }
}

if (!function_exists('meta_description')) {
    function meta_description(Post $post): string
    {
        return BlogHelper::generateMetaDescription($post);
    }
}

if (!function_exists('breadcrumbs')) {
    function breadcrumbs(Post $post): array
    {
        return BlogHelper::generateBreadcrumbs($post);
    }
}