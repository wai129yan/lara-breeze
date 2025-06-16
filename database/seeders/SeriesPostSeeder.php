<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Series;
use Illuminate\Database\Seeder;

class SeriesPostSeeder extends Seeder
{
    public function run(): void
    {
        // $series = Series::inRandomOrder()->take(5)->get();
        // $posts = Post::inRandomOrder()->take(20)->get();

        // foreach ($series as $s) {
        //     $selectedPosts = $posts->random(rand(3, 7))->values();
        //     foreach ($selectedPosts as $index => $post) {
        //         $s->posts()->attach($post->id, ['position' => $index]);
        //     }
        // }
    }
}