<?php

namespace Database\Factories;

use App\Models\Clap;
use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClapFactory extends Factory
{
    protected $model = Clap::class;

    public function definition()
    {
        return [
            'post_id' => Post::factory(),
            'user_id' => User::factory(),
            'clap_count' => $this->faker->numberBetween(1, 10),
        ];
    }
}
