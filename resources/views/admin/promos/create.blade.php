<!-- resources/views/admin/promos/create.blade.php -->

@extends('adminlte::page')

@section('title', 'Create Promo')

@section('content_header')
<h1>Create Promo</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.promos.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Promo Name:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="discount_percentage">Discount Percentage:</label>
                <input type="number" name="discount_percentage" id="discount_percentage" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="product_id">Product:</label>
                <select name="product_id" id="product_id" class="form-control" required>
                    @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" id="start_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" id="end_date" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Create Promo</button>
        </form>
    </div>
</div>
@stop