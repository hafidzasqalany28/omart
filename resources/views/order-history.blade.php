@extends('layouts.layout')

@section('content')

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Order History</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{ route('home') }}">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Order History</p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Sorting Dropdown Start -->
<div class="container mb-4">
    <div class="dropdown ml-auto float-right">
        <button class="btn border dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            Sort by
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
            <a class="dropdown-item" href="{{ route('order.history', ['sort' => 'desc']) }}">Latest</a>
            <a class="dropdown-item" href="{{ route('order.history', ['sort' => 'asc']) }}">Oldest</a>
        </div>
    </div>
</div>
<!-- Sorting Dropdown End -->


<!-- Page order history start -->
<div class="container-fluid pt-5">
    <div class="row mt-3">
        @forelse($orderHistory as $order)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Order ID: {{ $order->id }}</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Total:</strong> Rp {{ number_format($order->total_amount + 20000, 0, ',',
                        '.') }}</p>
                    <p class="mb-2"><strong>Status:</strong> {{ $order->status }}</p>
                    <p class="mb-2"><strong>Quantity:</strong> {{ $order->quantity }}</p>
                    <p class="mb-2"><strong>Order Date:</strong> {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
                    <hr>
                    <h5>Ordered Products:</h5>
                    <ul class="list-group">
                        @php $totalProductsPrice = 0; @endphp
                        @forelse($order->products as $product)
                        <li class="list-group-item">
                            <p class="mb-1"><strong>Name:</strong> {{ $product->name }}</p>
                            <p class="mb-1"><strong>Price:</strong> Rp {{ number_format($product->pivot->price, 0, ',',
                                '.') }}</p>
                            <p class="mb-1"><strong>Quantity:</strong> {{ $product->pivot->quantity }}</p>
                            @php
                            $subtotal = $product->pivot->price * $product->pivot->quantity;
                            $totalProductsPrice += $subtotal;
                            @endphp
                            <!-- Add the following lines to show review modal trigger -->
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#reviewModal{{ $product->id }}">
                                Write a Review
                            </button>

                            <!-- Add the following lines to include the review modal -->
                            @include('layouts.review-modal', ['product' => $product, 'order' => $order])
                        </li>
                        @empty
                        <li class="list-group-item text-muted">No products in this order.</li>
                        @endforelse
                    </ul>
                    <hr>
                    <p class="mb-1"><strong>Ongkir:</strong> Rp 20,000</p>

                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p>No order history available.</p>
        </div>
        @endforelse
    </div>
</div>
<!-- Page order history end -->
@endsection