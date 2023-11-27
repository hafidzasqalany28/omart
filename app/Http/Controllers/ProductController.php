<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $products = Product::query();

        // Filter by category
        if ($request->has('categories')) {
            $products->whereIn('category_id', $request->input('categories'));
        }
        // Filter by price range
        if ($request->filled('min_price')) {
            $products->where('price', '>=', $request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $products->where('price', '<=', $request->input('max_price'));
        }

        // Search by name
        if ($request->filled('search')) {
            $products->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $products = $products->get();

        return view('products', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $promo = $product->promotion;
        $reviews = $product->reviews;
        $reviewCount = $reviews->count();

        // Calculate average rating
        $averageRating = $product->reviews()->avg('rating');

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(5)
            ->get();

        return view('products-detail', compact('product', 'promo', 'reviews', 'reviewCount', 'averageRating', 'relatedProducts'));
    }
}
