<?php

// app/Http/Controllers/Admin/PromoController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Models\Product;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $promos = Promo::with('product')->get();
        return view('admin.promos.index', compact('promos'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.promos.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'discount_percentage' => 'required|numeric',
            'product_id' => 'required|exists:products,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        Promo::create($request->all());

        return redirect()->route('admin.promos.index')->with('success', 'Promo created successfully');
    }

    public function edit(Promo $promo)
    {
        $products = Product::all();
        return view('admin.promos.edit', compact('promo', 'products'));
    }

    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'discount_percentage' => 'required|numeric',
            'product_id' => 'required|exists:products,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $promo->update($request->all());

        return redirect()->route('admin.promos.index')->with('success', 'Promo updated successfully');
    }

    public function show(Promo $promo)
    {
        // return view('admin.promos.show', compact('promo'));
    }

    public function destroy(Promo $promo)
    {
        $promo->delete();

        return redirect()->route('admin.promos.index')->with('success', 'Promo deleted successfully');
    }
}
