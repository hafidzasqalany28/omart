<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    // public function index()
    // {
    //     return view('home');
    // }

    public function welcome()
    {
        return view('welcome');
    }

    public function shop(Request $request)
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


        $products = $products->get();

        return view('shop', compact('products', 'categories'));
    }



    public function shopDetail()
    {
        return view('shop-detail');
    }

    public function shoppingCart()
    {
        return view('shopping-cart');
    }

    public function checkout()
    {
        return view('checkout');
    }

    public function contact()
    {
        return view('contact');
    }
}
