<?php

namespace Database\Seeders;

use App\Models\Promo;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PromosSeeder extends Seeder
{
    public function run()
    {
        $products = \App\Models\Product::pluck('id');

        foreach ($products as $productId) {
            Promo::create([
                'name' => "Promo for Product $productId",
                'description' => "Description for Promo of Product $productId",
                'discount_percentage' => rand(5, 50),
                'product_id' => $productId,
                'start_date' => now(),
                'end_date' => now()->addDays(30),
            ]);
        }
    }
}
