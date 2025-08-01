<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            // UserSeeder::class,
            TagSeeder::class,
            PostSeeder::class,
            // CommentSeeder::class,
            ClapSeeder::class,
            // UserFollowSeeder::class,
            // SeriesPostSeeder::class,
            // CategorySeeder::class
        ]);
    }
}
