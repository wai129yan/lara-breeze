<?php

// database/seeders/SeriesSeeder.php

namespace Database\Seeders;

use App\Models\Series;
use Illuminate\Database\Seeder;

class SeriesSeeder extends Seeder
{
    public function run(): void
    {
        Series::factory()->count(10)->create();
    }
}