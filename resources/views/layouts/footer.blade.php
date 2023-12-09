<!-- Footer Start -->
<div class="container-fluid bg-secondary text-dark mt-5 pt-5">
    <div class="row px-xl-5 pt-5">
        <!-- Kolom Informasi Kontak -->
        <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
            <a href="#" class="text-decoration-none">
                <h5 class="font-weight-bold text-dark mb-4">Informasi Kami</h5>
            </a>
            <p>Solusi belanja semua kebutuhan grocery Anda. Produk berkualitas, layanan luar biasa, dan harga yang tak
                terkalahkan.</p>
            <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Jalan Utama, Merauke, Indonesia
            </p>
            <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@omartmerauke.com</p>
            <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+123 456 7890</p>
        </div>

        <!-- Kolom Tautan Cepat -->
        <div class="col-lg-8 col-md-12">
            <div class="row">
                <!-- Kolom Tautan Cepat 1 -->
                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4">Tautan Cepat</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-dark mb-2" href="{{ route('home') }}"><i
                                class="fa fa-angle-right mr-2"></i>Beranda</a>
                        <a class="text-dark mb-2" href="{{ route('products') }}"><i
                                class="fa fa-angle-right mr-2"></i>Produk Kami</a>
                        <a class="text-dark mb-2" href="{{ route('contact') }}"><i
                                class="fa fa-angle-right mr-2"></i>Hubungi Kami</a>
                        <a class="text-dark mb-2" href="{{ route('cart') }}"><i
                                class="fa fa-angle-right mr-2"></i>Keranjang Belanja</a>
                        <a class="text-dark mb-2" href="{{ route('checkout') }}"><i
                                class="fa fa-angle-right mr-2"></i>Checkout</a>
                    </div>
                </div>

                <!-- Kolom Tautan Cepat 2 -->
                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4">Tautan Cepat</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-dark mb-2" href=""><i class="fa fa-angle-right mr-2"></i>Tentang Kami</a>
                        <a class="text-dark mb-2" href=""><i class="fa fa-angle-right mr-2"></i>Penawaran Khusus</a>
                        <a class="text-dark mb-2" href=""><i class="fa fa-angle-right mr-2"></i>FAQ</a>
                        <a class="text-dark mb-2" href="{{ route('order.history') }}"><i
                                class="fa fa-angle-right mr-2"></i>Histori Pesanan</a>
                    </div>
                </div>

                <!-- Kolom Newsletter -->
                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4">Newsletter</h5>
                    <form action="#">
                        <div class="form-group">
                            <input type="text" class="form-control border-0 py-4" placeholder="Nama Anda" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control border-0 py-4" placeholder="Email Anda" required>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block border-0 py-3" type="submit">Berlangganan
                                Sekarang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Baris Bawah dengan Hak Cipta dan Metode Pembayaran -->
    <div class="row border-top border-light mx-xl-5 py-4">
        <div class="col-md-6 px-xl-0">
            <p class="mb-md-0 text-center text-md-left text-dark">
                &copy; <a class="text-dark font-weight-semi-bold" href="#">Omart Merauke</a>. Seluruh Hak Dilindungi.
                Didukung oleh <a class="text-dark font-weight-semi-bold" href="https://htmlcodex.com">HTML Codex</a><br>
                Didistribusikan Oleh <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
            </p>
        </div>
        <div class="col-md-6 px-xl-0 text-center text-md-right">
            <img class="img-fluid" src="{{ asset('img/payments.png') }}" alt="Metode Pembayaran">
        </div>
    </div>
</div>
<!-- Tombol Kembali ke Atas -->
<a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>
<!-- Footer End -->