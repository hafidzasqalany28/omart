<!-- resources/views/admin/promos/show.blade.php -->

@extends('adminlte::page')

@section('title', 'Promo Details')

@section('content_header')
<h1>Promo Details</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <h2>{{ $promo->name }}</h2>
        <p><strong>Description:</strong> {{ $promo->description }}</p>
        <p><strong>Discount Percentage:</strong> {{ $promo->discount_percentage }}</p>
        <p><strong>Product:</strong> {{ $promo->product->name }}</p>
        <p><strong>Start Date:</strong> {{ $promo->start_date }}</p>
        <p><strong>End Date:</strong> {{ $promo->end_date }}</p>
        <p><strong>Created At:</strong> {{ $promo->created_at }}</p>
        <p><strong>Updated At:</strong> {{ $promo->updated_at }}</p>
        <a href="{{ route('admin.promos.edit', $promo->id) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('admin.promos.destroy', $promo->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger"
                onclick="return confirm('Are you sure you want to delete this promo?')">Delete</button>
        </form>
    </div>
</div>
@stop