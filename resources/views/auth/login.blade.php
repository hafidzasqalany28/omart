<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Omart Login</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}">
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="gradient-form" style="background: linear-gradient(to right, #FF69B4, #000000);">
    <div class="container py-5">
        <div class="card rounded-3 text-black">
            <div class="row g-0">
                <div class="col-lg-6">
                    <div class="card-body p-md-5 mx-md-4">
                        <div class="text-center">
                            <img src="{{ asset('img/logo-omart.png') }}" style="width: 185px;" alt="logo">
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <p class="h5 mb-4 text-center mt-4">Sign in to access your account.</p>
                            <div class="form-outline mb-4">
                                <input type="email" id="email"
                                    class="form-control form-control-sm @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" placeholder="Email address" required
                                    autocomplete="email" autofocus />
                                <label class="form-label sr-only" for="email">Email Address</label>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-outline mb-4">
                                <input type="password" id="password"
                                    class="form-control form-control-sm @error('password') is-invalid @enderror"
                                    name="password" placeholder="Password" required
                                    autocomplete="current-password" />
                                <label class="form-label sr-only" for="password">Password</label>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-check d-flex justify-content-between mb-4">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{
                                    old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">Remember Me</label>
                                <a href="{{ route('password.request') }}" class="text-muted">Forgot
                                    password?</a>
                            </div>
                            <button class="btn btn-primary btn-block btn-lg gradient-custom-2 mb-4"
                                type="submit">Sign in</button>
                        </form>
                        <div class="text-center">
                            <p class="small mb-0">Don't have an account? <a href="{{ route('register') }}"
                                    class="text-muted">Sign up</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card-body p-md-5 mx-0 d-flex align-items-center justify-content-center"
                        style="height: 520px; overflow: hidden;">
                        <img src="{{ asset('img/omart.jpg') }}" class="img-fluid" alt="Responsive Image"
                            style="object-fit: cover; height: 100%; width: 100%;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
