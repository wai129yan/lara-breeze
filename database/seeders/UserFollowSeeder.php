<?php

namespace Database\Seeders;

use App\Models\UserFollow;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserFollowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserFollow::factory()->count(50)->create();
    }
}
