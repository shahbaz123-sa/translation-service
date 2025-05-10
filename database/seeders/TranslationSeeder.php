<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Translation;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Translation::factory()->count(50)->create();
        foreach (range(1, 10) as $i) {
            Translation::factory()->count(5)->create();
        }
    }
}
