<?php

namespace App\Http\Controllers;

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

    public function shop()
    {
        return view('shop');
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
