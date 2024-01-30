<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use App\Models\User;
use Midtrans\Config;
use App\Models\Order;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderProcessingNotification;

class MidtransController extends Controller
{
    public function checkout(Request $request)
    {
        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return view('checkout', [
                'cartItems' => $cartItems,
                'subtotal' => 0,
                'shipping' => 0,
                'total' => 0,
            ]);
        }

        $subtotal = $this->getCartSubtotal($cartItems);
        $shipping = 20000;
        $total = $subtotal + $shipping;

        return view('checkout', compact('cartItems', 'subtotal', 'total', 'shipping'));
    }

    private function getCartSubtotal($cartItems)
    {
        $subtotal = 0;

        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product;
            $subtotal += $this->calculateCartItemPrice($product, $cartItem->quantity);
        }

        return $subtotal;
    }

    private function calculateCartItemPrice($product, $quantity)
    {
        if ($product->promos->isNotEmpty()) {
            $discount = $product->promos[0]->discount_percentage / 100;
            return ($product->price - ($product->price * $discount)) * $quantity;
        } else {
            return $product->price * $quantity;
        }
    }

    public function pay(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'required',
            'gross_amount' => 'required|numeric',
            // Add any additional validation rules here
        ]);

        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$clientKey = config('services.midtrans.clientKey');
        Config::$isProduction = !config('services.midtrans.isSandbox');

        $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Cart is empty.');
        }

        $subtotal = $this->getCartSubtotal($cartItems);
        $shipping = 20000;
        $totalAmount = round($subtotal + $shipping);

        $order = $this->createOrder($cartItems, $totalAmount);

        $transactionDetails = [
            'order_id' => 'zzz-' . $order->id,
            'gross_amount' => $totalAmount,
        ];

        $itemDetails = $this->prepareItemDetails($cartItems, $shipping);
        $customerDetails = $this->prepareCustomerDetails();
        $transactionData = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
        ];

        $this->attachProductsToOrder($order, $cartItems);

        $notificationUrl = route('midtrans.notification');

        try {
            $paymentResponse = Snap::createTransaction($transactionData);
            $snapToken = $paymentResponse->token;
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->away('https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $snapToken . '?callback=' . urlencode($notificationUrl));
    }

    public function notification(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload);

        $signatureKey = config('services.midtrans.serverKey');

        if ($notification->status_code == 200) {
            $midtransOrderId = $notification->order_id;
            $numericOrderId = (int) preg_replace('/[^0-9]/', '', $midtransOrderId);
            $order = Order::find($numericOrderId);

            if ($order) {
                $order->status = 'processing';
                $order->save();
                $this->notifyAdminAboutProcessingOrder($order);
                $cartItems = CartItem::where('user_id', $order->user_id)->with('product')->get();
                $this->reduceProductStock($order->products, $cartItems);
                $this->clearCart();
            }
        }

        return response('OK', 200);
    }

    protected function notifyAdminAboutProcessingOrder($order)
    {
        $admin = User::where('role_id', 1)->first(); // Assuming the role_id for the admin is 1
        if ($admin) {
            // Send notification to admin
            Notification::send($admin, new OrderProcessingNotification($order));
        }
    }

    protected function reduceProductStock($products, $cartItems)
    {
        foreach ($products as $product) {
            $cartItem = $cartItems->firstWhere('product_id', $product->id);
            if ($cartItem) {
                $quantityToReduce = $cartItem->quantity;
                $product->reduceStock($quantityToReduce);
            }
        }
    }

    protected function clearCart()
    {
        $userId = auth()->user()->id;
        CartItem::where('user_id', $userId)->delete();
    }

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
            $itemPrice = $this->calculateCartItemPrice($product, $cartItem->quantity);

            $itemDetails[] = [
                'id' => $product->id,
                'price' => (int) round($itemPrice / $cartItem->quantity),
                'quantity' => $cartItem->quantity,
                'name' => $product->name,
            ];
        }

        $itemDetails[] = [
            'id' => 'shipping',
            'price' => (int) round($shipping),
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
                'price' => (int) round($product->price),
            ]);
        }
    }
}
