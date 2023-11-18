<?php

namespace Database\Seeders;

use App\Models\Promo;
use App\Models\Product;
use Illuminate\Database\Seeder;

class PromosSeeder extends Seeder
{
    public function run()
    {
        $categories = Product::distinct('category_id')->pluck('category_id');

        foreach ($categories as $categoryId) {
            $product = Product::where('category_id', $categoryId)->first();

            if ($product) {
                Promo::create([
                    'name' => "Promo for " . $product->name,
                    'description' => "Description for Promo of " . $product->name,
                    'discount_percentage' => rand(5, 50),
                    'product_id' => $product->id,
                    'start_date' => now(),
                    'end_date' => now()->addDays(30),
                ]);
            }
        }
    }
}
