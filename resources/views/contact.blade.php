@extends('layouts.layout')
@section('page-title', 'Hubungi Kami')
@section('breadcrumb', 'Hubungi Kami')
@section('content')
<!-- Kontak Mulai -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-7 mb-5">
            <div class="contact-form">
                <div id="success"></div>
                <form name="sentMessage" id="contactForm" novalidate="novalidate">
                    <div class="control-group">
                        <input type="text" class="form-control" id="name" placeholder="Nama Anda" required="required"
                            data-validation-required-message="Silakan masukkan nama Anda" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <input type="email" class="form-control" id="email" placeholder="Email Anda" required="required"
                            data-validation-required-message="Silakan masukkan email Anda" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <input type="text" class="form-control" id="subject" placeholder="Subjek" required="required"
                            data-validation-required-message="Silakan masukkan subjek" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <textarea class="form-control" rows="6" id="message" placeholder="Pesan" required="required"
                            data-validation-required-message="Silakan masukkan pesan Anda"></textarea>
                        <p class="help-block text-danger"></p>
                    </div>
                    <div>
                        <button class="btn btn-primary py-2 px-4" type="submit" id="sendMessageButton">Kirim
                            Pesan</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-5 mb-5">
            <h5 class="font-weight-semi-bold mb-3">Hubungi Kami</h5>
            <p>Supermarket Omart Merauke siap membantu Anda. Jangan ragu untuk menghubungi kami untuk pertanyaan atau
                bantuan apa pun yang Anda butuhkan. Tim kami yang berdedikasi siap membantu.</p>
            <div class="d-flex flex-column mb-3">
                <h5 class="font-weight-semi-bold mb-3">Supermarket Omart Merauke</h5>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>Jalan 123, Merauke, Indonesia</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@omartmerauke.com</p>
                <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
            </div>
        </div>
    </div>
</div>
<!-- Kontak Selesai -->
@endsection