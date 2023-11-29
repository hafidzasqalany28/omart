@extends('adminlte::page')

@section('title', 'Order Details')

@section('content_header')
<h1>Order Details</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h3>Ordered Products:</h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Promo</th>
                                <th>Discount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($order->products as $key => $product)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->pivot->quantity }}</td>
                                <td>{{ $product->formattedPrice }}</td>
                                <td>
                                    @if ($product->promos->isNotEmpty())
                                    {{ $product->promos->first()->name }}
                                    @else
                                    No
                                    @endif
                                </td>
                                <td>
                                    @if ($product->promos->isNotEmpty())
                                    {{ $product->promos->first()->discount_percentage }}%
                                    @else
                                    N/A
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">No products in this order</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h3>Reviews:</h3>
                @if ($order->products->isNotEmpty())
                <div class="row">
                    @foreach ($order->products as $product)
                    @php $reviews = $product->reviews->where('user_id', $order->user_id); @endphp
                    @if ($reviews->isNotEmpty())
                    @foreach ($reviews as $review)
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <p><strong>User:</strong> {{ $review->user->name }}</p>
                                <p><strong>Product:</strong> {{ $product->name }}</p>
                                <p><strong>Comment:</strong> {{ $review->comment }}</p>
                                <p><strong>Rating:</strong> {{ $review->rating }}</p>
                                <p><strong>Date:</strong> {{ $review->created_at->format('Y-m-d H:i:s') }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <p>No reviews available for {{ $product->name }}</p>
                    @endif
                    @endforeach
                </div>
                @else
                <p>No products in this order</p>
                @endif
            </div>
        </div>
    </div>
</div>
@stop