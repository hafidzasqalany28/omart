<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        $categoryIds = [];

        // Populate category IDs
        foreach (['Makanan', 'Minuman', 'Home & Living', 'Kesehatan & Kecantikan', 'Ibu & Anak'] as $category) {
            $categoryIds[$category] = Category::create(['name' => $category])->id;
        }

        // Seed products
        foreach ($categoryIds as $category => $categoryId) {
            for ($i = 1; $i <= 3; $i++) {
                Product::create([
                    'name' => "$category Product $i",
                    'description' => "Description for $category Product $i",
                    'price' => rand(10, 100),
                    'category_id' => $categoryId,
                ]);
            }
        }
    }
}
