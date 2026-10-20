<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\File;
use Illuminate\Support\Arr;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::pluck('id');

        if ($users->isEmpty()) {
            throw new \RuntimeException(
                'Please seed at least one user before running ProductSeeder.'
            );
        }

        $faker = Faker::create('en_US');
        
        $descriptions = $this->descriptions();

        $priceRanges = $this->priceRanges();

        foreach (Category::all() as $category) {
            $key = Str::slug($category->name);

            $folder = database_path('seeders/images/' . $key);

            if (!is_dir($folder)) {
                $this->command?->warn(
                    "Image folder not found: {$folder}"
                );
                continue;
            }

            $texts = $descriptions[$key]
                ?? $descriptions['general'];

            [$min, $max] = $priceRanges[$key] ?? [10, 500];

            $files = glob(
                "$folder/*.{jpg,jpeg,png,webp}",
                GLOB_BRACE
            );

            foreach ($files as $file) {
                $name = Str::headline(
                    pathinfo($file, PATHINFO_FILENAME)
                );

                // Skip products that already exist in this category
                if (
                    Product::where('name', $name)
                        ->where('category_id', $category->id)
                        ->exists()
                ) {
                    $this->command?->info(
                        "Skipping existing product: {$name}"
                    );
                    continue;
                }

                $product = Product::create([
                    'name' => $name,
                    'description' => $name . ': ' . Arr::random($texts),
                    'price' => $faker->randomFloat(2, $min, $max),
                    'stock' => $faker->numberBetween(0, 200),
                    'category_id' => $category->id,
                    'user_id' => $users->random(),
                ]);

                $path = Storage::disk('public')->putFile(
                    'products',
                    new File($file)
                );

                if (!$path) {
                    throw new \RuntimeException(
                        "Failed to store image: {$file}"
                    );
                }

                $product->images()->create([
                    'path' => $path,
                    'sort_order' => 0,
                ]);
            }
        }
    }

    private function descriptions(): array
    {
        return [
            'electronics' => [
                'Reliable performance and a modern design, built for everyday use.',
                'A well-made device with a clear display and a long battery life.',
                'Compact, fast, and easy to use at home, at work, or on the go.',
                'Designed to provide a smooth and convenient everyday experience.',
                'A practical choice for users looking for quality and simplicity.',
                'Combines useful features with a clean and modern appearance.',
                'Built to fit easily into your daily routine.',
            ],

            'clothing' => [
                'Comfortable fabric and a relaxed fit, easy to wear every day.',
                'A versatile piece that works with most outfits.',
                'Designed for everyday comfort with a simple and timeless style.',
                'An easy choice for creating a clean and casual look.',
                'Made to offer a comfortable feel and a stylish appearance.',
                'A simple design that fits a variety of occasions.',
                'Easy to pair with other pieces for a complete outfit.',
            ],

            'furniture' => [
                'Solid construction and a clean design that suits most rooms.',
                'Comfortable, durable, and easy to place in any space.',
                'A practical addition that blends naturally with different interiors.',
                'Designed to balance everyday functionality with a modern look.',
                'A versatile piece that works well in a variety of spaces.',
                'Simple styling makes it easy to match with existing furniture.',
                'A useful choice for creating a comfortable and organized space.',
            ],

            'general' => [
                'Made to provide a convenient experience without unnecessary complexity.',
                'Carefully designed to fit different lifestyles and personal preferences.',
                'A straightforward choice for anyone who values convenience and simplicity.',
                'Suitable for different preferences thanks to its simple and versatile style.',
                'An appealing option for those who prefer practical and uncomplicated products.',
            ],
        ];
    }

    private function priceRanges(): array
    {
        return [
            'electronics' => [1000, 8999],
            'clothing'    => [150, 500],
            'furniture'   => [500, 3000],
        ];
    }
}