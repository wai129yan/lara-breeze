<?php
namespace Database\Seeders;

use App\Models\PostView;
use Illuminate\Database\Seeder;

class PostViewSeeder extends Seeder
{
    public function run(): void
    {
        PostView::factory()->count(50)->create();
    }
}