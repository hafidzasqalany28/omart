<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Omart - Supermarket Omart Merauke</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Template HTML Gratis" name="keywords">
    <meta content="Template HTML Gratis" name="description">

    <!-- Favicon -->
    <link href="{{ asset('img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Stylesheet Pustaka -->
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    
    <!-- Stylesheet Carousel -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Stylesheet Bootstrap Kustom -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>

    @include('layouts.navbar')

    @unless(request()->is('/'))
    <div class="container-fluid mb-5"
        style="background-image: url('{{ asset('img/bg-breadcumb.jpeg') }}'); background-size: cover; background-position: center;">
        <div class="d-flex flex-column align-items-center justify-content-center text-light" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">@yield('page-title', 'Judul Halaman')</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{ route('home') }}" class="text-light">Beranda</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">@yield('breadcrumb', 'Halaman')</p>
            </div>
        </div>
    </div>
    @endunless

    <div class="container-fluid pt-5">
        @yield('content')
    </div>

    @include('layouts.footer')

    <!-- Pustaka Javascript -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <!-- Berkas Javascript Kontak -->
    <script src="{{ asset('mail/jqBootstrapValidation.min.js') }}"></script>
    <script src="{{ asset('mail/contact.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>

</body>

</html>