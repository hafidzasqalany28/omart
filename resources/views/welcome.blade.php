@extends('layouts.layout')

@section('content')
<!-- Produk Unggulan Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5 pb-3">
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fas fa-shopping-basket text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">Pilihan Produk Luas</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                <h5 class="font-weight-semi-bold m-0">Pengiriman Gratis</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">Pengembalian Mudah</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-headset text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">Dukungan Pelanggan</h5>
            </div>
        </div>
    </div>
</div>
<!-- Produk Unggulan End -->

<!-- Produk Promo -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Produk Promo</span></h2>
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
                    <div class="card-body text-center">
                        <h6 class="card-title text-truncate">{{ $product->name }}</h6>
                        <div class="d-flex justify-content-center">
                            @if($product->promos->isNotEmpty())
                            <h6 class="font-weight-bold">Rp {{ number_format($product->price - ($product->price *
                                $product->promos[0]->discount_percentage / 100), 0, ',', '.') }}</h6>
                            <h6 class="text-muted ml-2"><del>Rp {{ number_format($product->price, 0, ',', '.') }}</del>
                            </h6>
                            <span class="badge badge-warning ml-2">-{{ $product->promos[0]->discount_percentage
                                }}%</span>
                            @else
                            <h6 class="font-weight-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</h6>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="{{ route('products.detail', $product->id) }}" class="btn btn-sm text-dark p-0">
                            <i class="fas fa-eye text-primary mr-1"></i>Lihat Detail
                        </a>
                        <form action="{{ route('cart.add', ['id' => $product->id]) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-sm text-dark p-0">
                                <i class="fas fa-shopping-cart text-primary mr-1"></i>Tambah ke Keranjang
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Produk Promo End -->

<!-- Produk Terlaris -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Produk Terlaris</span></h2>
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
                    <!-- Detail Produk -->
                    <div class="card-body text-center">
                        <h6 class="card-title text-truncate">{{ $product->name }}</h6>
                        <div class="d-flex justify-content-center">
                            @if($product->promos->isNotEmpty())
                            <h6 class="font-weight-bold">Rp {{ number_format($product->price - ($product->price *
                                $product->promos[0]->discount_percentage / 100), 0, ',', '.') }}
                            </h6>
                            <h6 class="text-muted ml-2"><del>Rp {{ number_format($product->price, 0, ',', '.') }}
                                </del></h6>
                            <span class="badge badge-warning ml-2">-{{ $product->promos[0]->discount_percentage }}
                                %</span>
                            @else
                            <h6 class="font-weight-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</h6>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="{{ route('products.detail', $product->id) }}" class="btn btn-sm text-dark p-0">
                            <i class="fas fa-eye text-primary mr-1"></i>Lihat Detail
                        </a>
                        <form action="{{ route('cart.add', ['id' => $product->id]) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-sm text-dark p-0">
                                <i class="fas fa-shopping-cart text-primary mr-1"></i>Tambah ke Keranjang
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Produk Terlaris End -->

<!-- Produk Terbaru -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Produk Terbaru</span></h2>
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
                    <!-- Detail Produk -->
                    <div class="card-body text-center">
                        <h6 class="card-title text-truncate">{{ $product->name }}</h6>
                        <div class="d-flex justify-content-center">
                            @if($product->promos->isNotEmpty())
                            <h6 class="font-weight-bold">Rp {{ number_format($product->price - ($product->price *
                                $product->promos[0]->discount_percentage / 100), 0, ',', '.') }}
                            </h6>
                            <h6 class="text-muted ml-2"><del>Rp {{ number_format($product->price, 0, ',', '.') }}
                                </del></h6>
                            <span class="badge badge-warning ml-2">-{{ $product->promos[0]->discount_percentage }}
                                %</span>
                            @else
                            <h6 class="font-weight-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</h6>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="{{ route('products.detail', $product->id) }}" class="btn btn-sm text-dark p-0">
                            <i class="fas fa-eye text-primary mr-1"></i>Lihat Detail
                        </a>
                        <form action="{{ route('cart.add', ['id' => $product->id]) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-sm text-dark p-0">
                                <i class="fas fa-shopping-cart text-primary mr-1"></i>Tambah ke Keranjang
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Produk Terbaru End -->

@endsection