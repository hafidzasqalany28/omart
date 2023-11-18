@extends('adminlte::page')

@section('title', 'Product Details')

@section('content_header')
<h1>Product Details</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <h2>{{ $product->name }}</h2>
        <p><strong>Description:</strong> {{ $product->description }}</p>
        <p><strong>Price:</strong> Rp {{ $product->price }}</p>
        <p><strong>Category:</strong> {{ $product->category->name }}</p>
        <p><strong>Image:</strong></p>
        @if($product->image)
        <img src="{{ asset('img/products/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail"
            style="max-width: 200px;">
        @else
        No Image
        @endif
        <p><strong>Created At:</strong> {{ $product->created_at }}</p>
        <p><strong>Updated At:</strong> {{ $product->updated_at }}</p>
        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger"
                onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
        </form>
    </div>
</div>
@stop