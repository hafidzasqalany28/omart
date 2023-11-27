@extends('layouts.layout')
@section('page-title', 'Product Detail')
@section('breadcrumb', 'Product Detail')
@section('content')
<!-- Shop Detail Start -->
<div class="container-fluid py-5">
    <div class="row px-xl-5 align-items-center">
        <!-- Product Image and Information Column -->
        <div class="col-lg-5 pb-5">
            <div class="d-flex flex-column align-items-center">
                @if($product->image)
                <img class="w-75 h-auto mb-3" src="{{ asset('img/products/' . $product->image) }}" alt="Product Image">
                @endif

                <!-- Add your dynamic product sharing here -->
            </div>
        </div>

        <!-- Product Information Column -->
        <div class="col-lg-7 pb-5">
            <h3 class="font-weight-semi-bold mb-3">{{ $product->name }}</h3>

            <!-- Rating Section -->
            <div class="d-flex align-items-center mb-3">
                <div class="text-primary mr-2">
                    @for($i = 0; $i < 5; $i++) @if($i < $averageRating) <small class="fas fa-star"></small>
                        @else
                        <small class="far fa-star"></small>
                        @endif
                        @endfor
                </div>
                <small class="pt-1">({{ $reviewCount }} Reviews)</small>
            </div>


            <!-- Price -->
            <div class="d-flex align-items-center mb-4">
                @if($product->promos->isNotEmpty())
                <!-- Display promotional price and discount badge if available -->
                <h3 class="font-weight-semi-bold mb-0">
                    Rp {{ number_format($product->price - ($product->price * $product->promos[0]->discount_percentage /
                    100), 0, ',', '.') }}
                </h3>
                <h6 class="text-muted ml-2"><del>Rp {{ number_format($product->price, 0, ',', '.') }}</del></h6>
                <span class="badge badge-warning ml-2">
                    -{{ $product->promos[0]->discount_percentage }}%
                </span>
                @else
                <!-- Display regular price if no promo available -->
                <h3 class="font-weight-semi-bold mb-0">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </h3>
                @if ($product->previous_price)
                <h6 class="text-muted ml-2"><del>Rp {{ number_format($product->previous_price, 0, ',', '.') }}</del>
                </h6>
                @endif
                @endif
            </div>

            <!-- Description -->
            <p class="mb-4">{{ $product->description }}</p>

            <!-- Quantity and Add to Cart -->
            <div class="d-flex align-items-center">
                <div class="input-group quantity mr-3" style="width: 130px;">
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-minus">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <input type="number" class="form-control bg-secondary text-center" id="quantityInput"
                        name="quantity" value="1">
                    <div class="input-group-btn">
                        <button class="btn btn-primary btn-plus">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <form action="{{ route('cart.add', ['id' => $product->id]) }}" method="POST">
                    @csrf
                    <!-- Include the quantity input in the form with a name attribute -->
                    <input type="hidden" name="quantity" id="addToCartQuantity" value="1">
                    <button type="submit" class="btn btn-primary px-3">
                        <i class="fa fa-shopping-cart mr-1"></i> Add To Cart
                    </button>
                </form>
            </div>
            <!-- Add your dynamic product sharing here -->
        </div>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Description</a>
                <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2">Promo</a>
                <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Reviews ({{ $reviewCount }})</a>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab-pane-1">
                    <h4 class="mb-3">Product Description</h4>
                    @if($product->description)
                    <p>{{ $product->description }}</p>
                    @else
                    <p>No description available for this product.</p>
                    @endif
                </div>
                <div class="tab-pane fade" id="tab-pane-2">
                    <h4 class="mb-3">Promo</h4>
                    @if($product->promos->isNotEmpty())
                    @foreach ($product->promos as $promo)
                    <div class="mb-3">
                        <h5>{{ $promo->name }}</h5>
                        <p>{{ $promo->description }}</p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Discount Percentage: <span class="badge badge-warning">{{
                                    $promo->discount_percentage }}</span>%</li>
                            <li class="list-group-item">Start Date: {{ $promo->start_date }}</li>
                            <li class="list-group-item">End Date: {{ $promo->end_date }}</li>
                        </ul>
                    </div>
                    @endforeach
                    @else
                    <p>No promo available for this product.</p>
                    @endif
                </div>

                <div class="tab-pane fade" id="tab-pane-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="mb-4">{{ $reviewCount }} review(s) for "{{ $product->name }}"</h4>
                            @forelse($reviews as $review)
                            <div class="media mb-4">
                                <img src="{{ asset('img/user.png') }}" alt="Image" class="img-fluid mr-3 mt-1"
                                    style="width: 45px;">
                                <div class="media-body">
                                    <h6>{{ $review->user->name }}<small> - <i>{{ $review->created_at->format('d M Y')
                                                }}</i></small></h6>
                                    <div class="text-primary mb-2">
                                        @for($i = 0; $i < $review->rating; $i++)
                                            <i class="fas fa-star"></i>
                                            @endfor
                                            @for($i = 0; $i < 5 - $review->rating; $i++)
                                                <i class="far fa-star"></i>
                                                @endfor
                                    </div>
                                    <p>{{ $review->comment }}</p>
                                </div>
                            </div>
                            @empty
                            <p>No reviews available for this product.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shop Detail End -->

<!-- Products Start -->
<div class="container-fluid py-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">You May Also Like</span></h2>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel related-carousel">
                @foreach ($relatedProducts as $index => $relatedProduct)
                <div class="card product-item border-0" style="border-color: {{ $index % 2 === 0 ? 'red' : 'blue' }}">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src="{{ asset('img/products/' . $relatedProduct->image) }}"
                            alt="{{ $relatedProduct->name }}">
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">{{ $relatedProduct->name }}</h6>
                        <div class="d-flex justify-content-center">
                            @if($relatedProduct->promos->isNotEmpty())
                            <!-- Display promotional price and discount badge if available -->
                            <h6>
                                Rp {{ number_format($relatedProduct->price - ($relatedProduct->price *
                                $relatedProduct->promos[0]->discount_percentage / 100), 0, ',', '.') }}
                            </h6>
                            <h6 class="text-muted ml-2"><del>Rp {{ number_format($relatedProduct->price, 0, ',', '.')
                                    }}</del></h6>
                            <span class="badge badge-warning ml-2">-{{ $relatedProduct->promos[0]->discount_percentage
                                }}%</span>
                            @else
                            <!-- Display regular price if no promo available -->
                            <h6>Rp {{ number_format($relatedProduct->price, 0, ',', '.') }}</h6>
                            @if ($relatedProduct->previous_price)
                            <h6 class="text-muted ml-2"><del>Rp {{ number_format($relatedProduct->previous_price, 0,
                                    ',', '.') }}</del></h6>
                            @endif
                            @endif
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="{{ route('products.detail', ['id' => $relatedProduct->id]) }}"
                            class="btn btn-sm text-dark p-0">
                            <i class="fas fa-eye text-primary mr-1"></i>View Detail
                        </a>
                        <form action="{{ route('cart.add', ['id' => $relatedProduct->id]) }}" method="POST">
                            @csrf
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
<!-- Products End -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var quantityInput = document.getElementById('quantityInput');
        var addToCartQuantity = document.getElementById('addToCartQuantity');
        var btnMinus = document.querySelector('.btn-minus');
        var btnPlus = document.querySelector('.btn-plus');

        // Update the hidden input value and form when the quantity changes
        quantityInput.addEventListener('input', function () {
            addToCartQuantity.value = this.value;
        });

        // Add event listeners for the plus and minus buttons if available
        if (btnMinus && btnPlus) {
            btnMinus.addEventListener('click', function () {
                quantityInput.value = Math.max(parseInt(quantityInput.value, 10), 1);
                addToCartQuantity.value = quantityInput.value;
            });

            btnPlus.addEventListener('click', function () {
                quantityInput.value = parseInt(quantityInput.value, 10);
                addToCartQuantity.value = quantityInput.value;
            });
        }
    });
</script>
@endsection