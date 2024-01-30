@extends('adminlte::page')

@section('title', 'Edit Product')

@section('content_header')
<h1>Edit Product</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
            </div>

            <div class="form-group">
                <label for="description">Product Description:</label>
                <textarea name="description" id="description" class="form-control" rows="3"
                    required>{{ $product->description }}</textarea>
            </div>

            <div class="form-group">
                <label for="price">Product Price:</label>
                <input type="number" name="price" id="price" class="form-control" step="0.01"
                    value="{{ $product->price }}" required>
            </div>

            <div class="form-group">
                <label for="category_id">Product Category:</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : ''
                        }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="quantity">Product Quantity:</label>
                <input type="number" name="quantity" id="quantity" class="form-control"
                    value="{{ $product->quantity ?? '' }}" required>
            </div>


            <div class="form-group">
                <label for="image">Product Image:</label>
                <input type="file" name="image" id="image" class="form-control-file">
                @if($product->image)
                <img src="{{ asset('img/products/' . $product->image) }}" alt="{{ $product->name }}"
                    class="img-thumbnail" style="max-width: 100px; margin-top: 10px;">
                @else
                No Image
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>
</div>
@stop