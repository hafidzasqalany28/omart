<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home()
    {
        $bestSellingProducts = $this->getBestSellingProducts(6);
        $promoProducts = $this->getPromoProducts(6);
        $newestProducts = $this->getNewestProducts(6);

        return view('welcome', compact('bestSellingProducts', 'promoProducts', 'newestProducts'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function orderHistory(Request $request)
    {
        $sort = $request->input('sort', 'desc');
        $orderHistory = $this->getUserOrderHistory($sort);

        return view('order-history', compact('orderHistory'));
    }

    public function submitReview(Request $request)
    {
        $this->validateReviewForm($request);

        $review = $this->saveReview($request);

        return redirect()->route('order.history')->with('success', 'Review submitted successfully');
    }

    public function showProfile()
    {
        return view('profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $this->validateProfileUpdateForm($request, $user);

        $this->updateUserProfile($request, $user);

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    // Helper methods...

    // Get best-selling products
    private function getBestSellingProducts($count)
    {
        return Product::withCount('orders')
            ->orderByDesc('orders_count')
            ->take($count)
            ->get();
    }

    // Get promo products
    private function getPromoProducts($count)
    {
        return Product::whereHas('promos', function ($query) {
            $query->where('start_date', '<=', now())
                ->where('end_date', '>=', now());
        })
            ->take($count)
            ->get();
    }

    // Get newest products
    private function getNewestProducts($count)
    {
        return Product::orderByDesc('created_at')
            ->take($count)
            ->get();
    }

    // Get user order history
    private function getUserOrderHistory($sort)
    {
        return Order::where('user_id', auth()->id())
            ->orderBy('created_at', $sort)
            ->get();
    }

    // Validate review form data
    private function validateReviewForm(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required',
        ]);
    }

    // Save review to the database
    private function saveReview(Request $request)
    {
        $review = new Review();
        $review->user_id = auth()->id();
        $review->product_id = $request->input('product_id');
        $review->rating = $request->input('rating');
        $review->comment = $request->input('comment');
        $review->save();

        return $review;
    }

    // Validate profile update form data
    private function validateProfileUpdateForm(Request $request, $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
        ]);
    }

    // Update user profile
    private function updateUserProfile(Request $request, $user)
    {
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'phone_number' => $request->input('phone_number'),
        ]);
    }
}
