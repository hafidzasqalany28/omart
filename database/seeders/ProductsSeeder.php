<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        $categories = ['Makanan', 'Minuman', 'Kebutuhan Dapur', 'Rumah Tangga', 'Ibu & Anak'];

        foreach ($categories as $category) {
            $categoryModel = Category::create(['name' => $category]);

            for ($i = 1; $i <= 3; $i++) {
                $productName = "$category Product $i";
                $imageName = Str::slug($productName, '-') . '.png';
                $price = rand(10000, 100000);
                $quantity = rand(10, 50);

                Product::create([
                    'name' => $productName,
                    'description' => "Description for $productName",
                    'price' => $price,
                    'quantity' => $quantity,
                    'category_id' => $categoryModel->id,
                    'image' => $imageName,
                ]);
            }
        }
    }
}
