<?php

// namespace App\Helpers;

function hello()
{
    return 'Hello World';
}

function generateExcerpt(string $content, int $length = 150): string
{
    $content = strip_tags($content);
    $content = preg_replace('/\s+/', ' ', $content);
    $content = trim($content);

    if (strlen($content) <= $length) {
        return $content;
    }

    return substr($content, 0, $length) . '...';
}

function timeToRead(string $content, int $wordsPerMinute = 200): string
{
    $wordCount = str_word_count(strip_tags($content));
    $minutes = ceil($wordCount / $wordsPerMinute);

    return $minutes . ' min read';
}
