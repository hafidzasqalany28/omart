<?php

namespace App\Http\Controllers\Admin;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function index()
    {
        $products = Product::withCount('reviews')
            ->with(['reviews' => function ($query) {
                $query->select(DB::raw('avg(rating) as average_rating, product_id'))
                    ->groupBy('product_id');
            }])
            ->get();

        return view('admin.reviews.index', compact('products'));
    }

    public function show(Product $product)
    {
        $reviews = $product->reviews()->with(['user'])->get();
        return view('admin.reviews.show', compact('product', 'reviews'));
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully');
    }

    public function destroyAll(Product $product)
    {
        $product->reviews()->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'All reviews for ' . $product->name . ' deleted successfully');
    }
}
