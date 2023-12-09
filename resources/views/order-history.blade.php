@extends('layouts.layout')
@section('page-title', 'Histori Pesanan')
@section('breadcrumb', 'Histori Pesanan')
@section('content')
<!-- Sorting Dropdown Start -->
<div class="container mb-4">
    <div class="dropdown ml-auto float-right">
        <button class="btn border dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            Urutkan berdasarkan
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
            <a class="dropdown-item" href="{{ route('order.history', ['sort' => 'desc']) }}">Terbaru</a>
            <a class="dropdown-item" href="{{ route('order.history', ['sort' => 'asc']) }}">Terlama</a>
        </div>
    </div>
</div>
<!-- Sorting Dropdown End -->


<!-- Halaman histori pesanan start -->
<div class="container-fluid pt-5">
    <div class="row mt-3">
        @forelse($orderHistory as $order)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">ID Pesanan: {{ $order->id }}</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Total:</strong> Rp {{ number_format($order->total_amount + 20000, 0, ',',
                        '.') }}</p>
                    <p class="mb-2"><strong>Status:</strong> {{ $order->status }}</p>
                    <p class="mb-2"><strong>Jumlah:</strong> {{ $order->quantity }}</p>
                    <p class="mb-2"><strong>Tanggal Pesan:</strong> {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
                    <hr>
                    <h5>Produk Dipesan:</h5>
                    <ul class="list-group">
                        @php $totalProductsPrice = 0; @endphp
                        @forelse($order->products as $product)
                        <li class="list-group-item">
                            <p class="mb-1"><strong>Nama:</strong> {{ $product->name }}</p>
                            <p class="mb-1"><strong>Harga:</strong> Rp {{ number_format($product->pivot->price, 0, ',',
                                '.') }}</p>
                            <p class="mb-1"><strong>Jumlah:</strong> {{ $product->pivot->quantity }}</p>
                            @php
                            $subtotal = $product->pivot->price * $product->pivot->quantity;
                            $totalProductsPrice += $subtotal;
                            @endphp

                            <!-- Tambahkan baris berikut untuk menampilkan modal ulasan hanya saat status selesai -->
                            @if($order->status === 'completed')
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#reviewModal{{ $product->id }}">
                                Tulis Ulasan
                            </button>

                            <!-- Tambahkan baris berikut untuk menyertakan modal ulasan -->
                            @include('layouts.review-modal', ['product' => $product, 'order' => $order])
                            @endif
                        </li>
                        @empty
                        <li class="list-group-item text-muted">Tidak ada produk dalam pesanan ini.</li>
                        @endforelse
                    </ul>
                    <hr>
                    <p class="mb-1"><strong>Ongkos Kirim:</strong> Rp 20,000</p>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p>Tidak ada histori pesanan yang tersedia.</p>
        </div>
        @endforelse
    </div>
</div>
<!-- Halaman histori pesanan end -->
@endsection