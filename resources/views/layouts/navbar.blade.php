<div class="container-fluid">
    <!-- Topbar Start -->
    <div class="row bg-secondary py-2 px-xl-5">
        <div class="col-lg-6 d-none d-lg-block">
            <div class="d-inline-flex align-items-center">
                <a class="text-dark" href="#">FAQs</a>
                <span class="text-muted px-2">|</span>
                <a class="text-dark" href="#">Help</a>
                <span class="text-muted px-2">|</span>
                <a class="text-dark" href="#">Support</a>
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

    <!-- Main Navbar Start -->
    <div class="row align-items-center py-3 px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a href="#" class="text-decoration-none">
                <h1 class="m-0 display-5 font-weight-semi-bold">
                    <span class="text-primary font-weight-bold border px-3 mr-1">O</span>Mart
                </h1>
            </a>
        </div>
        <div class="col-lg-6 col-6 text-left">
            <form action="#">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for products">
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
                    <span class="badge">{{ count(session('cart', [])) }}</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Main Navbar End -->
</div>
<!-- Topbar End -->

<!-- Navbar Start -->
<div class="container-fluid">
    <div class="row border-top px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            @if(Request::is('/'))
            <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100"
                data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                <h6 class="m-0">Categories</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            @else
            <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100"
                data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                <h6 class="m-0">Categories</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            @endif
            <nav class="navbar {{ Request::is('/') ? 'show' : 'collapse' }} navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0"
                id="navbar-vertical">
                <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link" data-toggle="dropdown">Dresses <i
                                class="fa fa-angle-down float-right mt-1"></i></a>
                        <div class="dropdown-menu position-absolute bg-secondary border-0 rounded-0 w-100 m-0">
                            <a href="" class="dropdown-item">Men's Dresses</a>
                            <a href="" class="dropdown-item">Women's Dresses</a>
                            <a href="" class="dropdown-item">Baby's Dresses</a>
                        </div>
                    </div>
                    <a href="" class="nav-item nav-link">Shirts</a>
                    <a href="" class="nav-item nav-link">Jeans</a>
                    <a href="" class="nav-item nav-link">Swimwear</a>
                    <a href="" class="nav-item nav-link">Sleepwear</a>
                    <a href="" class="nav-item nav-link">Sportswear</a>
                    <a href="" class="nav-item nav-link">Jumpsuits</a>
                    <a href="" class="nav-item nav-link">Blazers</a>
                    <a href="" class="nav-item nav-link">Jackets</a>
                    <a href="" class="nav-item nav-link">Shoes</a>
                </div>
            </nav>
        </div>

        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                <a href="{{ route('home') }}" class="text-decoration-none d-block d-lg-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold">
                        <span class="text-primary font-weight-bold border px-3 mr-1">O</span>Mart
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
                        <!-- User Dropdown if logged in -->
                        <div class="dropdown mr-2">
                            <button class="btn border" type="button" id="userDropdown" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">Profile</a>
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
                        <a href="{{ route('register') }}" class="nav-item nav-link">Register</a>
                        @endauth
                    </div>
                </div>
            </nav>

            @if(\Request::is('/'))
            <div id="header-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active" style="height: 410px;">
                        <img class="img-fluid" src="{{ asset('img/carousel-1.jpg') }}" alt="Image">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 700px;">
                                <h4 class="text-light text-uppercase font-weight-medium mb-3">10% Off Your First Order
                                </h4>
                                <h3 class="display-4 text-white font-weight-semi-bold mb-4">Fashionable Dress</h3>
                                <a href="" class="btn btn-light py-2 px-3">Shop Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item" style="height: 410px;">
                        <img class="img-fluid" src="{{ asset('img/carousel-2.jpg') }}" alt="Image">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 700px;">
                                <h4 class="text-light text-uppercase font-weight-medium mb-3">10% Off Your First Order
                                </h4>
                                <h3 class="display-4 text-white font-weight-semi-bold mb-4">Reasonable Price</h3>
                                <a href="" class="btn btn-light py-2 px-3">Shop Now</a>
                            </div>
                        </div>
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