<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Promo;
use App\Models\Review;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totals = [
            'Orders' => Order::count(),
            'Products' => Product::count(),
            'Users' => User::count(),
            'Categories' => Category::count(),
            'Reviews' => Review::count(),
            'Promos' => Promo::count(),
        ];

        $latestOrders = $this->getLatestItems(Order::with('user')->latest()->limit(5)->get(), 'formattedTotalAmount', 'total_amount', 'Rp ');
        $latestProducts = $this->getLatestItems(Product::latest()->limit(5)->get(), 'formattedPrice', 'price', 'Rp ');
        $latestCategories = $this->getLatestItems(Category::withCount('products')->latest()->limit(5)->get());
        $latestReviews = $this->getLatestItems(Review::latest()->limit(5)->get());
        $latestPromos = $this->getLatestItems(Promo::latest()->limit(5)->get());

        // Fetch total sales data
        $totalSales = $this->getMonthlyData('quantity', 'total_sales');

        // Fetch total revenue data
        $totalRevenue = $this->getMonthlyData('total_amount', 'total_revenue');

        // Combine the data into a single array
        $data = [];
        foreach ($totalSales as $sale) {
            $month = $sale->month;
            $data[$month]['total_sales'] = $sale->total_sales;
        }

        foreach ($totalRevenue as $revenue) {
            $month = $revenue->month;
            $data[$month]['total_revenue'] = $revenue->total_revenue;
        }

        // Extract the months and values
        $months = array_keys($data);
        $sales = array_column($data, 'total_sales');
        $revenue = array_column($data, 'total_revenue');

        return view('admin.dashboard', compact(
            'totals',
            'latestOrders',
            'latestProducts',
            'latestCategories',
            'latestReviews',
            'latestPromos',
            'months',
            'sales',
            'revenue',
        ));
    }

    private function getLatestItems($items, $formattedKey = null, $valueKey = null, $prefix = '')
    {
        $items->transform(function ($item) use ($formattedKey, $valueKey, $prefix) {
            if ($formattedKey && $valueKey) {
                $formattedAmount = $prefix . number_format($item->$valueKey, 2, ',', '.');
                $item->$formattedKey = $formattedAmount;
            }
            return $item;
        });

        return $items;
    }

    private function getMonthlyData($quantityKey, $totalKey)
    {
        return DB::table('orders')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('SUM(' . $quantityKey . ') as ' . $totalKey))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }
}
