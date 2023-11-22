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

    public function home()
    {
        $products = Product::all();

        return view('welcome', compact('products'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function reviews()
    {
        // Logika untuk halaman ulasan
    }
}
