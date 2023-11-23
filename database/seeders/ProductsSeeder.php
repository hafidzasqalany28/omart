<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        $categoryIds = [];

        foreach (['Makanan', 'Minuman', 'Kebutuhan Dapur', 'Rumah Tangga', 'Ibu & Anak'] as $category) {
            $categoryIds[$category] = Category::create(['name' => $category])->id;
        }

        foreach ($categoryIds as $category => $categoryId) {
            for ($i = 1; $i <= 3; $i++) {
                $productName = "$category Product $i";
                $imageName = Str::slug($productName, '-') . '.png';

                Product::create([
                    'name' => $productName,
                    'description' => "Description for $productName",
                    'price' => rand(10000, 100000),
                    'category_id' => $categoryId,
                    'image' => "$imageName",
                ]);
            }
        }
    }
}
