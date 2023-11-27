<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function home()
    {
        // Mengambil 6 produk terlaris berdasarkan total kuantitas terjual
        $bestSellingProducts = Product::withCount('orders')
            ->orderByDesc('orders_count')
            ->take(6)
            ->get();

        // Mengambil 6 produk promo
        $promoProducts = Product::whereHas('promos', function ($query) {
            $query->where('start_date', '<=', now())
                ->where('end_date', '>=', now());
        })
            ->take(6)
            ->get();

        // Mengambil 6 produk terbaru berdasarkan tanggal pembuatan
        $newestProducts = Product::orderByDesc('created_at')
            ->take(6)
            ->get();

        return view('welcome', compact('bestSellingProducts', 'promoProducts', 'newestProducts'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function orderHistory(Request $request)
    {
        $sort = $request->input('sort', 'desc');

        $orderHistory = Order::where('user_id', auth()->id())
            ->orderBy('created_at', $sort)
            ->get();

        return view('order-history', compact('orderHistory'));
    }

    public function submitReview(Request $request)
    {
        // Validate the review form data
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required',
        ]);

        // Save the review to the database
        $review = new Review();
        $review->user_id = auth()->id();
        $review->product_id = $request->input('product_id');
        $review->rating = $request->input('rating');
        $review->comment = $request->input('comment');
        $review->save();

        // Redirect back to the order history page
        return redirect()->route('order.history');
    }

    public function showProfile()
    {
        return view('profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user

        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
        ]);

        // Update user profile based on the form data
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'phone_number' => $request->input('phone_number'),
        ]);

        // Redirect back or to a success page
        return redirect()->back()->with('success', 'Profile updated successfully');
    }
}
