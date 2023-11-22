<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function showCart()
    {
        $cartItems = session('cart', []);

        // Cek apakah keranjang belanja kosong
        if (empty($cartItems)) {
            return view('cart', ['cartItems' => $cartItems, 'subtotal' => 0, 'shipping' => 0, 'total' => 0]);
        }

        $subtotal = $this->getCartSubtotal($cartItems);
        $shipping = 20000; // Ganti dengan biaya pengiriman yang sesuai
        $total = $subtotal + $shipping;

        foreach ($cartItems as &$item) {
            $item['subtotal'] = $this->calculateItemSubtotal($item);
        }

        return view('cart', compact('cartItems', 'subtotal', 'shipping', 'total'));
    }





    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $cart = session('cart', []);

        // Get the quantity directly from the request
        $quantity = $request->input('quantity', 1);

        // Check if the product is already in the cart
        if (array_key_exists($product->id, $cart)) {
            // If yes, update the quantity
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            // If not, add the product to the cart
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image,
            ];
        }

        // Save the cart back to the session
        session(['cart' => $cart]);

        // Check if the request has the 'quantity' input
        if ($request->has('quantity')) {
            // If 'quantity' exists, it's a request from the product details page
            return back()->with('success', 'Product added to cart successfully.');
        } else {
            // If not, it's a request from the regular product page
            return back()->with('success', 'Product added to cart successfully.');
        }
    }


    public function removeFromCart($id)
    {
        $cart = session('cart', []);

        // Hapus item dari keranjang belanja berdasarkan ID produk
        unset($cart[$id]);

        // Simpan kembali ke dalam session
        session(['cart' => $cart]);

        return redirect()->route('cart')->with('success', 'Product removed from cart successfully.');
    }

    public function getCartSubtotal($cart)
    {
        $subtotal = 0;

        foreach ($cart as $item) {
            $product = Product::find($item['id']);

            // Hitung harga berdasarkan promo jika tersedia
            if ($product->promos->isNotEmpty()) {
                $subtotal += ($product->price - ($product->price * $product->promos[0]->discount_percentage / 100)) * $item['quantity'];
            } else {
                $subtotal += $product->price * $item['quantity'];
            }
        }

        return $subtotal;
    }

    // Add this new method to calculate item subtotal
    private function calculateItemSubtotal($item)
    {
        $product = Product::find($item['id']);
        $subtotal = 0;

        // Hitung harga berdasarkan promo jika tersedia
        if ($product->promos->isNotEmpty()) {
            $subtotal = ($product->price - ($product->price * $product->promos[0]->discount_percentage / 100)) * $item['quantity'];
        } else {
            $subtotal = $product->price * $item['quantity'];
        }

        return $subtotal;
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
