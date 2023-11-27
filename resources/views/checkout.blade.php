@extends('layouts.layout')

@section('page-title', 'Checkout')
@section('breadcrumb', 'Checkout')
@section('content')
<!-- Checkout Start -->
<div class="container-fluid pt-5">
    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                </div>
                <div class="card-body">
                    <h5 class="font-weight-medium mb-3">Products</h5>
                    @foreach($cartItems as $item)
                    <div class="d-flex justify-content-between">
                        <p>{{ $item->product->name }}</p>
                        <p>Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                    <hr class="mt-0">
                    <div class="d-flex justify-content-between mb-3 pt-1">
                        <h6 class="font-weight-medium">Subtotal</h6>
                        <h6 class="font-weight-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Shipping</h6>
                        <h6 class="font-weight-medium">Rp {{ number_format($shipping, 0, ',', '.') }}</h6>
                    </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <div class="d-flex justify-content-between mt-2">
                        <h5 class="font-weight-bold">Total</h5>
                        <h5 class="font-weight-bold">Rp {{ number_format($total, 0, ',', '.') }}</h5>
                    </div>
                </div>
            </div>

            <a href="{{ route('checkout.pay', ['order_id' => uniqid(), 'gross_amount' => $total]) }}"
                class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Pay</a>

        </div>
    </div>
</div>
<!-- Checkout End -->
@endsection