<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->get();

        $orders->transform(function ($order) {
            $order->formattedTotalAmount = 'Rp ' . number_format($order->total_amount, 0, ',', '.');
            return $order;
        });

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['products.reviews', 'user']);

        $order->formattedTotalAmount = 'Rp ' . number_format($order->total_amount, 0, ',', '.');

        $order->products->transform(function ($product) {
            $product->formattedPrice = 'Rp ' . number_format($product->pivot->price, 0, ',', '.');
            return $product;
        });

        return view('admin.orders.show', compact('order'));
    }

    public function update(Order $order)
    {
        $order->update(['status' => 'completed']);

        return Redirect::route('admin.orders.index')->with('success', 'Order marked as completed successfully');
    }
}
