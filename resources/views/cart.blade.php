@extends('layouts.layout')

@section('page-title', 'Shopping Cart')
@section('breadcrumb', 'Shopping Cart')
@section('content')
<!-- Cart Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-bordered text-center mb-0">
                <thead class="bg-secondary text-dark">
                    <tr>
                        <th>Products</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @forelse($cartItems as $item)
                    <tr>
                        <td class="align-middle">
                            @if(isset($item->product->image))
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('img/products/' . $item->product->image) }}"
                                    alt="{{ $item->product->name }}" style="width: 50px;">
                                <span class="ml-2">{{ $item->product->name }}</span>
                            </div>
                            @endif
                        </td>
                        <td class="align-middle">
                            @if(isset($item->product->promos) && $item->product->promos->isNotEmpty())
                            <del>Rp {{ number_format($item->product->price, 0, ',', '.') }}</del>
                            <br>
                            Rp {{ number_format($item->product->price - ($item->product->price *
                            $item->product->promos[0]->discount_percentage / 100), 0, ',', '.') }}
                            @else
                            Rp {{ number_format($item->product->price, 0, ',', '.') }}
                            @endif
                        </td>
                        <td class="align-middle">
                            <div class="input-group quantity mx-auto" style="width: 100px;">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-primary btn-minus">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control form-control-sm bg-secondary text-center"
                                    value="{{ $item->quantity }}">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-primary btn-plus">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        <td class="align-middle">
                            <form action="{{ route('cart.remove', ['id' => $item->product->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary"><i
                                        class="fa fa-times"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No items in the cart.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="col-lg-4">
            {{-- <form class="mb-5" action="">
                <div class="input-group">
                    <input type="text" class="form-control p-4" placeholder="Coupon Code">
                    <div class="input-group-append">
                        <button class="btn btn-primary">Apply Coupon</button>
                    </div>
                </div>
            </form> --}}
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3 pt-1">
                        <h6 class="font-weight-medium">Subtotal</h6>
                        <h6 class="font-weight-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Ongkir</h6>
                        <h6 class="font-weight-medium">Rp {{ number_format($shipping, 0, ',', '.') }}</h6>
                    </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <div class="d-flex justify-content-between mt-2">
                        <h5 class="font-weight-bold">Total</h5>
                        <h5 class="font-weight-bold">Rp {{ number_format($total, 0, ',', '.') }}</h5>
                    </div>
                    <a href="{{ route('checkout') }}" class="btn btn-block btn-primary my-3 py-3">Proceed To
                        Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->
@endsection