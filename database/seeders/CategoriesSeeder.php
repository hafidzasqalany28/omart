<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        Category::create(['name' => 'Makanan']);
        Category::create(['name' => 'Minuman']);
        Category::create(['name' => 'Home & Living']);
        Category::create(['name' => 'Kesehatan & Kecantikan']);
        Category::create(['name' => 'Ibu & Anak']);
    }
}
