<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;
use App\Models\Product;
use Midtrans\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MidtransController extends Controller
{
    public function checkout(Request $request)
    {
        $cartItems = $request->session()->get('cart', []);
        $subtotal = 0;
        $itemDetails = [];
        // Hitung subtotal dan dapatkan detail item
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $itemDetails[] = [
                'id' => $item['id'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'name' => $item['name'],
            ];
        }

        $shipping = 20000; // Sesuaikan dengan logika aplikasi Anda

        $total = $subtotal + $shipping; // Sesuaikan dengan logika aplikasi Anda

        // Tampilkan tampilan checkout dengan informasi keranjang belanja
        return view('checkout', compact('cartItems', 'subtotal', 'total', 'itemDetails', 'shipping'));
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

        $cartItems = $request->session()->get('cart', []);
        $subtotal = 0;

        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $totalAmount = round($subtotal);

        // Create the order
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->total_amount = $totalAmount;
        $order->status = 'pending';
        $order->quantity = count($cartItems);
        $order->save();

        // Set the order_id in transactionDetails to match the created order's ID
        $transactionDetails = [
            'order_id' => 'cc-' . $order->id,
            'gross_amount' => $totalAmount, // Round the value
        ];

        $itemDetails = [];

        foreach ($cartItems as $item) {
            $itemDetails[] = [
                'id' => $item['id'],
                'price' => round($item['price']), // Round the value
                'quantity' => $item['quantity'],
                'name' => $item['name'],
            ];
        }

        $customerDetails = [
            // Add customer details as needed
        ];

        $transactionData = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
        ];

        // Attach each product to the order
        foreach ($cartItems as $item) {
            $product = Product::find($item['id']);
            $order->products()->attach($product, [
                'quantity' => $item['quantity'],
                'price' => round($item['price']),
            ]);
        }

        // Membuat notifikasi URL untuk menanggapi hasil pembayaran dari Midtrans
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

        // Verifikasi keaslian notifikasi dari Midtrans
        $signatureKey = config('services.midtrans.serverKey');
        // $isSignatureValid = $this->verifySignature($payload, $request->header('Signature'), $signatureKey);

        if ($notification->status_code == 200) {
            // Extract numeric part from Midtrans order ID
            $midtransOrderId = $notification->order_id;
            $numericOrderId = (int) preg_replace('/[^0-9]/', '', $midtransOrderId);

            // Query order using the extracted numeric ID
            $order = Order::find($numericOrderId);

            if ($order) {
                $order->status = 'processing'; // Ubah status sesuai dengan kebutuhan Anda
                $order->save();
            }
        }

        return response('OK', 200);
    }

    // private function verifySignature($payload, $headerSignature, $secretKey)
    // {
    //     $expectedSignature = base64_encode(hash_hmac('sha256', $payload, $secretKey, true));

    //     return $expectedSignature === $headerSignature;
    // }
}
