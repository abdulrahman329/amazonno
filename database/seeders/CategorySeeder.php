<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['electronics', 'clothing', 'furniture',];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category]);
        }

        $this->command->info('Categories seeded!');
    }
}
