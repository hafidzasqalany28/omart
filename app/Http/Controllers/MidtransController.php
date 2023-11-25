<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MidtransController extends Controller
{
    public function checkout(Request $request)
    {
        $cartItems = $request->session()->get('cart', []);
        $subtotal = 0;
        $itemDetails = [];

        // Calculate subtotal and gather item details
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $itemDetails[] = [
                'id' => $item['id'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'name' => $item['name'],
            ];
        }

        $shipping = 20000; // Adjust as needed
        $total = $subtotal + $shipping;

        // Display checkout view with cart information
        return view('checkout', compact('cartItems', 'subtotal', 'total', 'itemDetails', 'shipping'));
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

        $cartItems = $request->session()->get('cart', []);
        $subtotal = 0;
        $shipping = 20000; // Adjust the shipping cost as needed

        // Calculate subtotal
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

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
        $order->quantity = count($cartItems);
        $order->save();

        return $order;
    }

    private function prepareItemDetails($cartItems, $shipping)
    {
        $itemDetails = [];

        foreach ($cartItems as $item) {
            $itemDetails[] = [
                'id' => $item['id'],
                'price' => round($item['price']),
                'quantity' => $item['quantity'],
                'name' => $item['name'],
            ];
        }

        // Add shipping as a separate item
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
        return [
            'first_name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'phone' => auth()->user()->phone_number,
            'billing_address' => [
                'first_name' => auth()->user()->name,
                'address' => auth()->user()->address,
            ],
            'shipping_address' => [
                'first_name' => auth()->user()->name,
            ],
        ];
    }

    private function attachProductsToOrder($order, $cartItems)
    {
        foreach ($cartItems as $item) {
            $product = Product::find($item['id']);
            $order->products()->attach($product, [
                'quantity' => $item['quantity'],
                'price' => round($item['price']),
            ]);
        }
    }
}
