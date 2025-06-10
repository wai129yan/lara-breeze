<?php

namespace Database\Seeders;

use App\Models\Clap;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Clap::factory()->count(50)->create();
    }
}
