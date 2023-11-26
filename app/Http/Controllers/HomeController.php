<?php

namespace App\Http\Controllers;

use App\Models\Order;
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

    public function reviews()
    {
        // Logika untuk halaman ulasan
    }

    public function orderHistory(Request $request)
    {
        $sort = $request->input('sort', 'desc');

        $orderHistory = Order::where('user_id', auth()->id())
            ->orderBy('created_at', $sort)
            ->get();

        return view('order-history', compact('orderHistory'));
    }
}
