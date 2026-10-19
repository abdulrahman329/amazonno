<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        $users = User::pluck('id')->all();

        if ($categories->isEmpty() || empty($users)) {
            $this->command->error(
                'Please seed users and categories first.'
            );
            return;
        }

        $catalog = $this->catalog();
        $available = [];
        $disk = Storage::disk('public');

        foreach ($categories as $category) {
            $slug = Str::slug($category->name);
            $folder = "products/{$slug}";

            $images = $disk->exists($folder)
                ? collect($disk->files($folder))
                    ->filter(fn ($path) => preg_match(
                        '/\.(jpg|jpeg|png|webp)$/i',
                        $path
                    ))
                    ->values()
                    ->all()
                : [];

            if (empty($images)) {
                $this->command->warn(
                    "No images found for category: {$category->name}"
                );
                continue;
            }

            $available[] = [
                'category' => $category,
                'images' => $images,
                'profile' => $this->profileFor(
                    $category->name,
                    $catalog
                ),
            ];
        }

        if (empty($available)) {
            $this->command->error(
                'No category images found. Please add images to storage/app/public/products/{category-slug}.'
            );
            return;
        }

        DB::transaction(function () use ($available, $users) {
            for ($i = 0; $i < 50; $i++) {
                $item = $available[$i % count($available)];

                $category = $item['category'];
                $profile = $item['profile'];

                $productData = $profile['products'][
                    intdiv($i, count($available))
                    % count($profile['products'])
                ];

                $imagePath = $item['images'][
                    intdiv($i, count($available))
                    % count($item['images'])
                ];

                $product = Product::create([
                    'name' => $productData['name'],
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'stock' => fake()->numberBetween(0, 999),
                    'category_id' => $category->id,
                    'user_id' => $users[$i % count($users)],
                ]);

                $product->images()->create([
                    'path' => $imagePath,
                    'sort_order' => 0,
                ]);
            }
        });

        $this->command->info(
            '50 products created successfully!'
        );
    }

    private function profileFor(
        string $categoryName,
        array $catalog
    ): array {
        $name = Str::lower($categoryName);

        foreach ($catalog as $keywords => $profile) {
            foreach (explode('|', $keywords) as $keyword) {
                if (Str::contains($name, $keyword)) {
                    return $profile;
                }
            }
        }

        return [
            'products' => [
                [
                    'name' => "Premium {$categoryName} Collection",
                    'description' =>
                        "Discover our {$categoryName} collection, " .
                        'featuring practical designs and contemporary style.',
                    'price' => 199.00,
                ],
                [
                    'name' => "Essential {$categoryName} Edition",
                    'description' =>
                        "Explore our {$categoryName} essentials, " .
                        'designed for everyday convenience and versatility.',
                    'price' => 299.00,
                ],
            ],
        ];
    }

    private function catalog(): array
    {
        return [
            'electronics|electronic' => [
                'products' => [
                    [
                        'name' => 'iPhone 16 Pro',
                        'description' => 'Experience powerful performance, an advanced camera system, and a premium display in a sleek smartphone designed for everyday use.',
                        'price' => 4499.00,
                    ],
                    [
                        'name' => 'Wireless Noise-Cancelling Headphones',
                        'description' => 'Enjoy immersive audio, comfortable ear cushions, and wireless convenience for music, calls, and travel.',
                        'price' => 899.00,
                    ],
                    [
                        'name' => 'Ultra-Slim Laptop',
                        'description' => 'A lightweight laptop designed for productivity, multitasking, and entertainment at home, work, or on the go.',
                        'price' => 3299.00,
                    ],
                    [
                        'name' => 'Smart Watch Series',
                        'description' => 'Stay connected with a modern smartwatch featuring activity tracking, convenient notifications, and a versatile everyday design.',
                        'price' => 699.00,
                    ],
                ],
            ],

            'clothing|fashion|apparel' => [
                'products' => [
                    [
                        'name' => 'Classic Cotton T-Shirt',
                        'description' => 'A timeless cotton T-shirt featuring a comfortable fit and versatile styling for everyday wear.',
                        'price' => 79.00,
                    ],
                    [
                        'name' => 'Premium Casual Jacket',
                        'description' => 'A contemporary jacket with a versatile silhouette, perfect for layering and creating effortless everyday outfits.',
                        'price' => 249.00,
                    ],
                    [
                        'name' => 'Everyday Sneakers',
                        'description' => 'Modern casual sneakers combining versatile styling with everyday comfort for a variety of occasions.',
                        'price' => 199.00,
                    ],
                    [
                        'name' => 'Minimalist Shoulder Bag',
                        'description' => 'A stylish shoulder bag designed to organize everyday essentials while complementing a wide range of outfits.',
                        'price' => 159.00,
                    ],
                ],
            ],

            'furniture|home|decor' => [
                'products' => [
                    [
                        'name' => 'Modern Accent Chair',
                        'description' => 'A contemporary accent chair designed to bring comfort and understated elegance to living rooms and reading corners.',
                        'price' => 799.00,
                    ],
                    [
                        'name' => 'Minimalist Work Desk',
                        'description' => 'A clean-lined desk offering a practical workspace for studying, working, and organizing everyday essentials.',
                        'price' => 599.00,
                    ],
                    [
                        'name' => 'Contemporary Coffee Table',
                        'description' => 'A versatile coffee table that adds functional surface space and a refined touch to modern living areas.',
                        'price' => 399.00,
                    ],
                    [
                        'name' => 'Modern Lounge Sofa',
                        'description' => 'A contemporary lounge sofa designed to complement modern interiors and create a welcoming living space.',
                        'price' => 2499.00,
                    ],
                ],
            ],
        ];
    }
}