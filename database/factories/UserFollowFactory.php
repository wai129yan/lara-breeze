<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserFollow;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserFollow>
 */
class UserFollowFactory extends Factory
{
    protected $model = UserFollow::class;

    public function definition()
    {
        $follower = User::inRandomOrder()->first() ?? User::factory()->create();
        $followed = User::inRandomOrder()->where('id', '!=', $follower->id)->first() ?? User::factory()->create();

        return [
            'follower_id' => $follower->id,
            'followed_id' => $followed->id,
        ];
    }
}
