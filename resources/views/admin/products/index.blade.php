@extends('adminlte::page')

@section('title', 'Manage Products')

@section('content_header')
<h1>Manage Products</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List of Products</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-2">Create Product</a>
        <table class="table table-responsive-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td class="text-truncate" style="max-width: 150px;">{{ $product->description }}</td>
                    <td class="text-nowrap">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>
                        @if($product->image)
                        <img src="{{ asset('img/products/' . $product->image) }}" alt="{{ $product->name }}"
                            class="img-thumbnail" style="max-width: 100px;">
                        @else
                        No Image
                        @endif
                    </td>
                    <td>{{ $product->created_at }}</td>
                    <td>{{ $product->updated_at }}</td>
                    <td>
                        <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-info btn-sm">Show</a>
                        <a href="{{ route('admin.products.edit', $product->id) }}"
                            class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
@stop