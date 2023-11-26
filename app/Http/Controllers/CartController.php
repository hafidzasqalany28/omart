<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\CartItem;

class CartController extends Controller
{
    public function showCart()
    {
        // Retrieve cart items from the database for the authenticated user
        $cartItems = CartItem::where('user_id', auth()->id())->with('product')->get();

        // Cek apakah keranjang belanja kosong
        if ($cartItems->isEmpty()) {
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

        // Get the quantity directly from the request
        $quantity = $request->input('quantity', 1);

        // Check if the product is already in the cart for the authenticated user
        $cartItem = CartItem::where('user_id', auth()->id())->where('product_id', $product->id)->first();

        if ($cartItem) {
            // If yes, update the quantity
            $cartItem->update(['quantity' => $cartItem->quantity + $quantity]);
        } else {
            // If not, add the product to the cart
            CartItem::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

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
        // Remove the item from the cart based on product ID and user ID
        CartItem::where('user_id', auth()->id())->where('product_id', $id)->delete();

        return redirect()->route('cart')->with('success', 'Product removed from cart successfully.');
    }

    public function getCartSubtotal($cart)
    {
        $subtotal = 0;

        foreach ($cart as $item) {
            // Assuming each item in the cart has a 'product' relation
            $product = $item->product;

            // Hitung harga berdasarkan promo jika tersedia
            if ($product->promos->isNotEmpty()) {
                $subtotal += ($product->price - ($product->price * $product->promos[0]->discount_percentage / 100)) * $item->quantity;
            } else {
                $subtotal += $product->price * $item->quantity;
            }
        }

        return $subtotal;
    }

    // Add this new method to calculate item subtotal
    private function calculateItemSubtotal($item)
    {
        $product = $item->product;
        $subtotal = 0;

        // Hitung harga berdasarkan promo jika tersedia
        if ($product->promos->isNotEmpty()) {
            $subtotal = ($product->price - ($product->price * $product->promos[0]->discount_percentage / 100)) * $item->quantity;
        } else {
            $subtotal = $product->price * $item->quantity;
        }

        return $subtotal;
    }
}
