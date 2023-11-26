<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class MidtransController extends Controller
{
    public function checkout(Request $request)
    {
        // Retrieve cart items from the database for the authenticated user
        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();

        // Check if the cart is empty
        if ($cartItems->isEmpty()) {
            return view('checkout', [
                'cartItems' => $cartItems,
                'subtotal' => 0,
                'shipping' => 0,
                'total' => 0,
            ]);
        }

        $subtotal = $this->getCartSubtotal($cartItems);
        $shipping = 20000; // Adjust with the appropriate shipping cost
        $total = $subtotal + $shipping;

        // Display checkout view with cart information
        return view('checkout', compact('cartItems', 'subtotal', 'total', 'shipping'));
    }

    // Add this new method to calculate cart subtotal
    private function getCartSubtotal($cartItems)
    {
        $subtotal = 0;

        foreach ($cartItems as $cartItem) {
            // Assuming each cart item has a 'product' relation
            $product = $cartItem->product;

            // Calculate price based on promo if available
            if ($product->promos->isNotEmpty()) {
                $subtotal += ($product->price - ($product->price * $product->promos[0]->discount_percentage / 100)) * $cartItem->quantity;
            } else {
                $subtotal += $product->price * $cartItem->quantity;
            }
        }

        return $subtotal;
    }

    public function pay(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'required',
            'gross_amount' => 'required|numeric',
            // Add any additional validation rules here
        ]);

        // Configure Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$clientKey = config('services.midtrans.clientKey');
        Config::$isProduction = !config('services.midtrans.isSandbox');

        // Retrieve cart items from the database for the authenticated user
        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();

        // Check if the cart is empty
        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Cart is empty.');
        }

        // Calculate subtotal and shipping
        $subtotal = $this->getCartSubtotal($cartItems);
        $shipping = 20000; // Adjust with the appropriate shipping cost
        $totalAmount = round($subtotal + $shipping);

        // Create the order
        $order = $this->createOrder($cartItems, $totalAmount);

        // Set transaction details
        $transactionDetails = [
            'order_id' => 'cc-' . $order->id,
            'gross_amount' => $totalAmount,
        ];

        // Set item details including shipping
        $itemDetails = $this->prepareItemDetails($cartItems, $shipping);

        // Set customer details
        $customerDetails = $this->prepareCustomerDetails();

        // Set overall transaction data
        $transactionData = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
        ];

        // Attach each product to the order
        $this->attachProductsToOrder($order, $cartItems);

        // Create notification URL
        $notificationUrl = route('midtrans.notification');

        try {
            // Create the transaction
            $paymentResponse = Snap::createTransaction($transactionData);

            // Get the Snap token from the payment response
            $snapToken = $paymentResponse->token;
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        // Return a redirect response with the Snap token
        return redirect()->away('https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $snapToken . '?callback=' . urlencode($notificationUrl));
    }

    public function notification(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload);

        // Verify the authenticity of the notification from Midtrans
        $signatureKey = config('services.midtrans.serverKey');

        if ($notification->status_code == 200) {
            // Extract numeric part from Midtrans order ID
            $midtransOrderId = $notification->order_id;
            $numericOrderId = (int) preg_replace('/[^0-9]/', '', $midtransOrderId);

            // Query order using the extracted numeric ID
            $order = Order::find($numericOrderId);

            if ($order) {
                $order->status = 'processing'; // Update status as needed
                $order->save();
            }
        }

        return response('OK', 200);
    }

    // Helper methods

    private function createOrder($cartItems, $totalAmount)
    {
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->total_amount = $totalAmount;
        $order->status = 'pending';
        $order->quantity = $cartItems->sum('quantity');
        $order->save();

        return $order;
    }

    private function prepareItemDetails($cartItems, $shipping)
    {
        $itemDetails = [];

        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product;

            // Menggunakan harga promo jika tersedia, jika tidak, gunakan harga dasar
            $itemPrice = $product->promos->isNotEmpty()
                ? ($product->price - ($product->price * $product->promos[0]->discount_percentage / 100))
                : $product->price;

            $itemDetails[] = [
                'id' => $product->id,
                'price' => round($itemPrice),
                'quantity' => $cartItem->quantity,
                'name' => $product->name,
            ];
        }

        // Menambahkan biaya pengiriman sebagai item terpisah
        $itemDetails[] = [
            'id' => 'shipping',
            'price' => round($shipping),
            'quantity' => 1,
            'name' => 'Shipping Cost',
        ];

        return $itemDetails;
    }

    private function prepareCustomerDetails()
    {
        $user = auth()->user();

        return [
            'first_name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone_number,
            'billing_address' => [
                'first_name' => $user->name,
                'address' => $user->address,
            ],
            'shipping_address' => [
                'first_name' => $user->name,
            ],
        ];
    }

    private function attachProductsToOrder($order, $cartItems)
    {
        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product;
            $order->products()->attach($product, [
                'quantity' => $cartItem->quantity,
                'price' => round($product->price),
            ]);
        }
    }
}
