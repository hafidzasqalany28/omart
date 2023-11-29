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

    public function create()
    {
        $categories = Category::all();
        return view('create-product', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = new Product($request->except('image'));
        $product->image = $this->storeImage($request);
        $product->save();

        return redirect()->route('admin.products.index');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('edit-product', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->fill($request->except('image'));

        if ($request->hasFile('image')) {
            $product->image = $this->storeImage($request);
        }

        $product->save();

        return redirect()->route('admin.products.index');
    }

    protected function storeImage(Request $request)
    {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/products'), $imageName);
        return $imageName;
    }
}
