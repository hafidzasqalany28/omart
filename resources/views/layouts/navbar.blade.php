<div class="container-fluid">
    <!-- Baris Topbar Start -->
    <div class="row bg-secondary py-2 px-xl-5">
        <div class="col-lg-6 d-none d-lg-block">
            <div class="d-inline-flex align-items-center">
                <a class="text-dark" href="#">FAQ</a>
                <span class="text-muted px-2">|</span>
                <a class="text-dark" href="#">Bantuan</a>
                <span class="text-muted px-2">|</span>
                <a class="text-dark" href="#">Dukungan</a>
            </div>
        </div>
        <div class="col-lg-6 text-center text-lg-right">
            <div class="d-inline-flex align-items-center">
                <a class="text-dark px-2" href="#">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a class="text-dark px-2" href="#">
                    <i class="fab fa-twitter"></i>
                </a>
                <a class="text-dark px-2" href="#">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a class="text-dark px-2" href="#">
                    <i class="fab fa-instagram"></i>
                </a>
                <a class="text-dark pl-2" href="#">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Utama Start -->
    <div class="row align-items-center py-3 px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a href="{{ route('home') }}" class="text-decoration-none">
                <h1 class="m-0 display-5 font-weight-semi-bold text-primary">
                    <img src="{{ asset('img/logo-omart.png') }}" alt="Logo Omart" class="img-fluid logo-img">
                </h1>
            </a>
        </div>
        <div class="col-lg-6 col-6 text-left">
            <form action="#">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari produk">
                    <div class="input-group-append">
                        <span class="input-group-text bg-transparent text-primary">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-3 col-6 text-right">
            <div class="d-flex align-items-center">
                @auth
                <a href="{{ route('order.history') }}"
                    class="nav-item nav-link{{ request()->is('order/history') ? ' active' : '' }}">
                    <i class="fas fa-shopping-bag text-primary"></i>
                    Histori Pembelian
                </a>
                @endauth
                <a href="{{ route('cart') }}" class="nav-item nav-link{{ request()->is('cart') ? ' active' : '' }}">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge text-primary">{{ \App\Models\CartItem::where('user_id', auth()->id())->count() }}</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Navbar Utama End -->
</div>

<!-- Navbar Start -->
<div class="container-fluid">
    <div class="row border-top px-xl-5">
        <div class="col-lg-12">
            <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
              <a href="{{ route('home') }}" class="text-decoration-none d-block d-lg-none">
    <h1 class="m-0 display-5 font-weight-semi-bold text-primary">
        <img src="{{ asset('img/logo-omart.png') }}" alt="Logo Omart" class="img-fluid logo-img" style="max-width: 200px; max-height: 80px; width: auto; height: auto;">
    </h1>
</a>


                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="{{ route('home') }}"
                            class="nav-item nav-link{{ Route::currentRouteName() === 'home' ? ' active' : '' }}">
                            Beranda
                        </a>
                        <a href="{{ route('products') }}"
                            class="nav-item nav-link{{ Route::currentRouteName() === 'products' ? ' active' : '' }}">
                            Produk
                        </a>
                        <a href="{{ route('contact') }}"
                            class="nav-item nav-link{{ Route::currentRouteName() === 'contact' ? ' active' : '' }}">
                            Bantuan
                        </a>
                    </div>
                    <div class="navbar-nav ml-auto">
                        @auth
                        <!-- Dropdown Pengguna jika sudah login -->
                        <div class="dropdown mr-2">
                            <button class="btn border" type="button" id="userDropdown" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('profile') }}">Profil</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                        @else
                        <a href="{{ route('login') }}" class="nav-item nav-link mr-2">Login</a>
                        <a href="{{ route('register') }}" class="nav-item nav-link">Daftar</a>
                        @endauth
                    </div>
                </div>
            </nav>

            @if(\Request::is('/'))
            <div id="header-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner" style="position: relative; height: 0; padding-bottom: 56.25%;">
                    <div class="carousel-item active"
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                        <a href="{{ route('products') }}">
                            <img class="img-fluid w-100 h-100" src="{{ asset('img/promo1.jpg') }}" alt="Gambar"
                                style="object-fit: cover;">
                        </a>
                    </div>
                    <div class="carousel-item" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                        <a href="{{ route('products') }}">
                            <img class="img-fluid w-100 h-100" src="{{ asset('img/promo2.jpg') }}" alt="Gambar"
                                style="object-fit: cover;">
                        </a>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                    <div class="btn btn-dark" style="width: 45px; height: 45px;">
                        <span class="carousel-control-prev-icon mb-n2"></span>
                    </div>
                </a>
                <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                    <div class="btn btn-dark" style="width: 45px; height: 45px;">
                        <span class="carousel-control-next-icon mb-n2"></span>
                    </div>
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
<!-- Navbar End -->