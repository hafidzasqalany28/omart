@extends('layouts.layout')

@section('content')
<!-- Featured Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5 pb-3">
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
            </div>
        </div>
    </div>
</div>
<!-- Featured End -->


<!-- Offer Start -->
<div class="container-fluid offer pt-5">
    <div class="row px-xl-5">
        <div class="col-md-6 pb-4">
            <div class="position-relative bg-secondary text-center text-md-right text-white mb-2 py-5 px-5">
                <img src="{{ asset('img/offer-1.png') }}" alt="">
                <div class="position-relative" style="z-index: 1;">
                    <h5 class="text-uppercase text-primary mb-3">20% off the all order</h5>
                    <h1 class="mb-4 font-weight-semi-bold">Spring Collection</h1>
                    <a href="" class="btn btn-outline-primary py-md-2 px-md-3">Shop Now</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 pb-4">
            <div class="position-relative bg-secondary text-center text-md-left text-white mb-2 py-5 px-5">
                <img src="{{ asset('img/offer-2.png') }}" alt="">
                <div class="position-relative" style="z-index: 1;">
                    <h5 class="text-uppercase text-primary mb-3">20% off the all order</h5>
                    <h1 class="mb-4 font-weight-semi-bold">Winter Collection</h1>
                    <a href="" class="btn btn-outline-primary py-md-2 px-md-3">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Offer End -->

<!-- Promo Products -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Promo Products</span></h2>
    </div>
    <div class="row px-xl-5 pb-3">
        <div class="col">
            <div class="owl-carousel related-carousel">
                @foreach($promoProducts as $product)
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src="{{ asset('img/products/' . $product->image) }}"
                            alt="{{ $product->name }}">
                    </div>
                    <!-- Product Details -->
                    <div class="card-body text-center">
                        <h6 class="card-title text-truncate">{{ $product->name }}</h6>
                        <div class="d-flex justify-content-center">
                            <!-- Display promotional price if available -->
                            @if($product->promos->isNotEmpty())
                            <h6 class="font-weight-bold">Rp {{ number_format($product->price - ($product->price *
                                $product->promos[0]->discount_percentage / 100), 0, ',', '.') }}
                            </h6>
                            <h6 class="text-muted ml-2"><del>Rp {{ number_format($product->price, 0, ',', '.') }}
                                </del></h6>
                            <span class="badge badge-warning ml-2">-{{ $product->promos[0]->discount_percentage }}
                                %</span>
                            @else
                            <!-- Display regular price if no promo available -->
                            <h6 class="font-weight-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</h6>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="{{ route('products.detail', $product->id) }}" class="btn btn-sm text-dark p-0">
                            <i class="fas fa-eye text-primary mr-1"></i>View Detail
                        </a>
                        <form action="{{ route('cart.add', ['id' => $product->id]) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <!-- Include a hidden input for quantity -->
                            <button type="submit" class="btn btn-sm text-dark p-0">
                                <i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Promo Product End -->

<!-- Best Selling Products -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Best Selling</span></h2>
    </div>
    <div class="row px-xl-5 pb-3">
        <div class="col">
            <div class="owl-carousel related-carousel">
                @foreach($bestSellingProducts as $product)
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src="{{ asset('img/products/' . $product->image) }}"
                            alt="{{ $product->name }}">
                    </div>
                    <!-- Product Details -->
                    <div class="card-body text-center">
                        <h6 class="card-title text-truncate">{{ $product->name }}</h6>
                        <div class="d-flex justify-content-center">
                            <!-- Display promotional price if available -->
                            @if($product->promos->isNotEmpty())
                            <h6 class="font-weight-bold">Rp {{ number_format($product->price - ($product->price *
                                $product->promos[0]->discount_percentage / 100), 0, ',', '.') }}
                            </h6>
                            <h6 class="text-muted ml-2"><del>Rp {{ number_format($product->price, 0, ',', '.') }}
                                </del></h6>
                            <span class="badge badge-warning ml-2">-{{ $product->promos[0]->discount_percentage }}
                                %</span>
                            @else
                            <!-- Display regular price if no promo available -->
                            <h6 class="font-weight-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</h6>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="{{ route('products.detail', $product->id) }}" class="btn btn-sm text-dark p-0">
                            <i class="fas fa-eye text-primary mr-1"></i>View Detail
                        </a>
                        <form action="{{ route('cart.add', ['id' => $product->id]) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <!-- Include a hidden input for quantity -->
                            <button type="submit" class="btn btn-sm text-dark p-0">
                                <i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Best Selling Products End -->

<!-- Newest Products -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Newest Products</span></h2>
    </div>
    <div class="row px-xl-5 pb-3">
        <div class="col">
            <div class="owl-carousel related-carousel">
                @foreach($newestProducts as $product)
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src="{{ asset('img/products/' . $product->image) }}"
                            alt="{{ $product->name }}">
                    </div>
                    <!-- Product Details -->
                    <div class="card-body text-center">
                        <h6 class="card-title text-truncate">{{ $product->name }}</h6>
                        <div class="d-flex justify-content-center">
                            <!-- Display promotional price if available -->
                            @if($product->promos->isNotEmpty())
                            <h6 class="font-weight-bold">Rp {{ number_format($product->price - ($product->price *
                                $product->promos[0]->discount_percentage / 100), 0, ',', '.') }}
                            </h6>
                            <h6 class="text-muted ml-2"><del>Rp {{ number_format($product->price, 0, ',', '.') }}
                                </del></h6>
                            <span class="badge badge-warning ml-2">-{{ $product->promos[0]->discount_percentage }}
                                %</span>
                            @else
                            <!-- Display regular price if no promo available -->
                            <h6 class="font-weight-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</h6>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="{{ route('products.detail', $product->id) }}" class="btn btn-sm text-dark p-0">
                            <i class="fas fa-eye text-primary mr-1"></i>View Detail
                        </a>
                        <form action="{{ route('cart.add', ['id' => $product->id]) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <!-- Include a hidden input for quantity -->
                            <button type="submit" class="btn btn-sm text-dark p-0">
                                <i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Newest Products End -->


@endsection