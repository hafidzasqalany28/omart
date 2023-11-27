<!-- Footer Start -->
<div class="container-fluid bg-secondary text-dark mt-5 pt-5">
    <div class="row px-xl-5 pt-5">
        <!-- Contact Information Column -->
        <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
            <a href="#" class="text-decoration-none">
                <h1 class="mb-4 display-5 font-weight-semi-bold">
                    <span class="text-primary font-weight-bold border border-white px-3 mr-1">O</span>Mart Merauke
                </h1>
            </a>
            <p>Your one-stop destination for all your grocery needs. Quality products, exceptional service, and
                unbeatable prices.</p>
            <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Main Street, Merauke, Indonesia
            </p>
            <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@omartmerauke.com</p>
            <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+123 456 7890</p>
        </div>

        <!-- Quick Links Columns -->
        <div class="col-lg-8 col-md-12">
            <div class="row">
                <!-- Quick Links Column 1 -->
                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-dark mb-2" href="{{ route('home') }}"><i
                                class="fa fa-angle-right mr-2"></i>Home</a>
                        <a class="text-dark mb-2" href="{{ route('products') }}"><i
                                class="fa fa-angle-right mr-2"></i>Our Products</a>
                        <a class="text-dark mb-2" href="{{ route('contact') }}"><i
                                class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        <a class="text-dark mb-2" href="{{ route('cart') }}"><i
                                class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                        <a class="text-dark mb-2" href="{{ route('checkout') }}"><i
                                class="fa fa-angle-right mr-2"></i>Checkout</a>
                    </div>
                </div>

                <!-- Quick Links Column 2 -->
                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-dark mb-2" href=""><i class="fa fa-angle-right mr-2"></i>About Us</a>
                        <a class="text-dark mb-2" href=""><i class="fa fa-angle-right mr-2"></i>Special Offers</a>
                        <a class="text-dark mb-2" href=""><i class="fa fa-angle-right mr-2"></i>FAQs</a>
                        <a class="text-dark mb-2" href="{{ route('order.history') }}"><i
                                class="fa fa-angle-right mr-2"></i>Order History</a>
                    </div>
                </div>

                <!-- Newsletter Column -->
                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4">Newsletter</h5>
                    <form action="#">
                        <div class="form-group">
                            <input type="text" class="form-control border-0 py-4" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control border-0 py-4" placeholder="Your Email" required>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block border-0 py-3" type="submit">Subscribe Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Row with Copyright and Payment Methods -->
    <div class="row border-top border-light mx-xl-5 py-4">
        <div class="col-md-6 px-xl-0">
            <p class="mb-md-0 text-center text-md-left text-dark">
                &copy; <a class="text-dark font-weight-semi-bold" href="#">Omart Merauke</a>. All Rights Reserved.
                Designed by <a class="text-dark font-weight-semi-bold" href="https://htmlcodex.com">HTML Codex</a><br>
                Distributed By <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
            </p>
        </div>
        <div class="col-md-6 px-xl-0 text-center text-md-right">
            <img class="img-fluid" src="{{ asset('img/payments.png') }}" alt="Payment Methods">
        </div>
    </div>
</div>
<!-- Back to Top Button -->
<a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>
<!-- Footer End -->