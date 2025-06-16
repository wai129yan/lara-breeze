<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostView;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostViewFactory extends Factory
{
    protected $model = PostView::class;

    public function definition(): array
    {
        return [
            'post_id' => Post::factory(),
            'user_id' => rand(0, 1) ? User::factory() : null,
            'viewed_at' => now(),
            'ip_address' => $this->faker->ipv4,
        ];
    }
}