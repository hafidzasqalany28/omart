@extends('layouts.layout')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Our Shop</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{ route('welcome') }}">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Shop</p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Shop Start -->
<div class="container-fluid pt-5">
    <div class="row">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-12">
            <form action="{{ route('shop.filter') }}" method="GET">
                <div class="bg-light p-3 mb-4">
                    <h5 class="font-weight-bold mb-4">Filters</h5>

                    <div class="mb-3">
                        <h6 class="font-weight-bold mb-3">Category:</h6>
                        @foreach($categories as $category)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="categories[]"
                                value="{{ $category->id }}" id="category{{ $category->id }}">
                            <label class="form-check-label" for="category{{ $category->id }}">
                                {{ $category->name }}
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold mb-3">Price Range:</h6>
                        <label for="min_price">Min Price:</label>
                        <input type="number" class="form-control" id="min_price" name="min_price"
                            placeholder="Enter min price">
                        <label for="max_price">Max Price:</label>
                        <input type="number" class="form-control" id="max_price" name="max_price"
                            placeholder="Enter max price">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Apply Filters</button>
                </div>
            </form>
        </div>
        <!-- Shop Sidebar End -->

        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-12">
            <div class="row">
                <!-- Search and Sort Options -->
                <div class="col-12 mb-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search by name">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-transparent text-primary">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </div>
                        </form>
                        <div class="dropdown ml-4">
                            <button class="btn border dropdown-toggle" type="button" id="triggerId"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Sort by
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId" style="">
                                <a class="dropdown-item" href="#">Latest</a>
                                <a class="dropdown-item" href="#">Popularity</a>
                                <a class="dropdown-item" href="#">Best Rating</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Search and Sort Options -->
                <!-- Loop through products and display dynamically -->
                @foreach($products as $product)
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="card product-item border-0">
                        <img class="card-img-top" src="{{ asset('img/products/' . $product->image) }}"
                            alt="{{ $product->name }}">
                        <div class="card-body text-center">
                            <h6 class="card-title text-truncate">{{ $product->name }}</h6>
                            <div class="d-flex justify-content-center">
                                @if($product->promos->isNotEmpty())
                                <!-- Display promotional price if available -->
                                <h6 class="font-weight-bold">Rp {{ number_format($product->price -
                                    ($product->price *
                                    $product->promos[0]->discount_percentage / 100), 0, ',', '.') }}
                                </h6>
                                <h6 class="text-muted ml-2"><del>Rp {{ number_format($product->price, 0, ',', '.')
                                        }}</del></h6>
                                <span class="badge badge-warning ml-2">-{{ $product->promos[0]->discount_percentage
                                    }}%</span>
                                @else
                                <!-- Display regular price if no promo available -->
                                <h6 class="font-weight-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</h6>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer bg-light border d-flex justify-content-between">
                            <a href="{{ route('shop.detail', ['id' => $product->id]) }}"
                                class="btn btn-sm btn-outline-dark">
                                <i class="fas fa-eye text-primary mr-2"></i>View Detail
                            </a>
                            <a href="{{ route('shopping.cart', ['id' => $product->id]) }}"
                                class="btn btn-sm btn-outline-dark">
                                <i class="fas fa-shopping-cart text-primary mr-2"></i>Add To Cart
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- End of product loop -->
            </div>
        </div>
        <!-- Shop Product End -->
    </div>
</div>
<!-- Shop End -->
@endsection