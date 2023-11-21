<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function showCart()
    {
        return view('cart');
    }

    public function checkout()
    {
        return view('checkout');
    }

    public function orderHistory()
    {
        // Logika untuk halaman riwayat pesanan
    }
}
