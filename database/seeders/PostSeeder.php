<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = Tag::all();

        Post::factory(20)->create()->each(function ($post) use ($tags) {
            $randomTagCount = rand(1, min(5, $tags->count()));
            $randomTagIds = $tags->random($randomTagCount)->pluck('id');

            $post->tags()->sync($randomTagIds);  // sync instead of attach to avoid duplicates
        });
    }
}
