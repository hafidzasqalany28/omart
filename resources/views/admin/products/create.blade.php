@extends('adminlte::page')

@section('title', 'Create Product')

@section('content_header')
<h1>Create Product</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="description">Product Description:</label>
                <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label for="price">Product Price:</label>
                <input type="number" name="price" id="price" class="form-control" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="category_id">Product Category:</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="quantity">Product Quantity:</label>
                <input type="number" name="quantity" id="quantity" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="image">Product Image:</label>
                <input type="file" name="image" id="image" class="form-control-file">
            </div>

            <button type="submit" class="btn btn-primary">Create Product</button>
        </form>
    </div>
</div>
@stop