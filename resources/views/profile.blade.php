@extends('layouts.layout')
@section('page-title', 'Profil')
@section('breadcrumb', 'Profil')
@section('content')
<div class="container mb-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Edit Profil Anda</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="name">Nama:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ Auth::user()->name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ Auth::user()->email }}" required>
                        </div>

                        <div class="form-group">
                            <label for="address">Alamat:</label>
                            <input type="text" class="form-control" id="address" name="address"
                                value="{{ Auth::user()->address }}" required>
                        </div>

                        <div class="form-group">
                            <label for="phone_number">Nomor Telepon:</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number"
                                value="{{ Auth::user()->phone_number }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Perbarui Profil</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection