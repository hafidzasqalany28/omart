@extends('layouts.layout')
@section('page-title', 'Produk Kami')
@section('breadcrumb', 'Produk Kami')
@section('content')
<!-- Toko Start -->
<div class="container-fluid pt-5">
    <div class="row">
        <!-- Sidebar Toko Start -->
        <div class="col-lg-3 col-md-12">
            <form action="{{ route('products.filter') }}" method="GET" class="bg-light p-3 mb-4">
                <h5 class="font-weight-bold mb-4">Filter</h5>

                <!-- Filter Kategori -->
                <div class="mb-3">
                    <h6 class="font-weight-bold mb-3">Kategori:</h6>
                    @foreach($categories as $category)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}"
                            id="category{{ $category->id }}">
                        <label class="form-check-label" for="category{{ $category->id }}">
                            {{ $category->name }}
                        </label>
                    </div>
                    @endforeach
                </div>

                <!-- Filter Rentang Harga -->
                <div class="mb-3">
                    <h6 class="font-weight-bold mb-3">Rentang Harga:</h6>
                    <label for="min_price">Harga Min:</label>
                    <input type="number" class="form-control" id="min_price" name="min_price"
                        placeholder="Masukkan harga min">
                    <label for="max_price">Harga Max:</label>
                    <input type="number" class="form-control" id="max_price" name="max_price"
                        placeholder="Masukkan harga max">
                </div>

                <button type="submit" class="btn btn-primary btn-block">Terapkan Filter</button>
            </form>
        </div>
        <!-- Sidebar Toko End -->

        <!-- Produk Toko Start -->
        <div class="col-lg-9 col-md-12">
            <div class="row">
                <!-- Pilihan Pencarian dan Penyortiran -->
                <div class="col-12 mb-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <!-- Form Pencarian -->
                        <form action="{{ route('products.filter') }}" method="GET" class="w-50">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search"
                                    placeholder="Cari berdasarkan nama" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="input-group-text bg-transparent text-primary"
                                        id="search-btn">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Dropdown Penyortiran -->
                        <div class="dropdown ml-4">
                            <button class="btn border dropdown-toggle" type="button" id="triggerId"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Urutkan berdasarkan
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                                <a class="dropdown-item" href="#">Terbaru</a>
                                <a class="dropdown-item" href="#">Popularitas</a>
                                <a class="dropdown-item" href="#">Rating Tertinggi</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Pilihan Pencarian dan Penyortiran -->

                <!-- Loop melalui produk dan tampilkan secara dinamis -->
                @forelse($products as $product)
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="card product-item border-0">
                        <!-- Gambar Produk -->
                        <img class="card-img-top" src="{{ asset('img/products/' . $product->image) }}"
                            alt="{{ $product->name }}">
                        <!-- Rincian Produk -->
                        <div class="card-body text-center">
                            <h6 class="card-title text-truncate">{{ $product->name }}</h6>
                            <div class="d-flex justify-content-center">
                                <!-- Tampilkan harga promosi jika tersedia -->
                                @if($product->promos->isNotEmpty())
                                <h6 class="font-weight-bold">Rp {{ number_format($product->price - ($product->price *
                                    $product->promos[0]->discount_percentage / 100), 0, ',', '.') }}
                                </h6>
                                <h6 class="text-muted ml-2"><del>Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </del></h6>
                                <span class="badge badge-warning ml-2">-{{ $product->promos[0]->discount_percentage }}
                                    %</span>
                                @else
                                <!-- Tampilkan harga reguler jika tidak ada promo -->
                                <h6 class="font-weight-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</h6>
                                @endif
                            </div>
                        </div>
                        <!-- Aksi Produk -->
                        <div class="card-footer bg-light border d-flex justify-content-between">
                            <a href="{{ route('products.detail', ['id' => $product->id]) }}"
                                class="btn btn-sm text-dark p-0">
                                <i class="fas fa-eye text-primary mr-1"></i>Lihat Detail
                            </a>
                            <form action="{{ route('cart.add', ['id' => $product->id]) }}" method="POST"
                                class="d-inline">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <!-- Sertakan input tersembunyi untuk jumlah -->
                                <button type="submit" class="btn btn-sm text-dark p-0">
                                    <i class="fas fa-shopping-cart text-primary mr-1"></i>Tambahkan ke Keranjang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <p class="text-center">Tidak ada produk ditemukan.</p>
                </div>
                @endforelse
                <!-- Akhir loop produk -->
            </div>
        </div>
        <!-- Produk Toko End -->
    </div>
</div>
<!-- Toko End -->
@endsection