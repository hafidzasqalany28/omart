<!-- resources/views/admin/promos/edit.blade.php -->

@extends('adminlte::page')

@section('title', 'Edit Promo')

@section('content_header')
<h1>Edit Promo</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.promos.update', $promo->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Promo Name:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $promo->name }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description" class="form-control"
                    required>{{ $promo->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="discount_percentage">Discount Percentage:</label>
                <input type="number" name="discount_percentage" id="discount_percentage" class="form-control"
                    value="{{ $promo->discount_percentage }}" required>
            </div>

            <div class="form-group">
                <label for="product_id">Product:</label>
                <select name="product_id" id="product_id" class="form-control" required>
                    @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ $promo->product_id == $product->id ? 'selected' : '' }}>{{
                        $product->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" id="start_date" class="form-control"
                    value="{{ $promo->start_date }}" required>
            </div>

            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $promo->end_date }}"
                    required>
            </div>

            <button type="submit" class="btn btn-primary">Update Promo</button>
        </form>
    </div>
</div>
@stop