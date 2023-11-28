@extends('adminlte::page')

@section('title', 'Manage Reviews')

@section('content_header')
<h1>Manage Reviews</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List of Reviews</h3>
    </div>
    <div class="card-body">
        <table class="table table-responsive-md">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Total Reviews</th>
                    <th>Average Rating</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->reviews_count }}</td>
                    <td>{{ $product->reviews->first() ? number_format($product->reviews->first()->average_rating, 2) :
                        'N/A' }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.reviews.show', $product->id) }}" class="btn btn-info btn-sm">Show
                                Details</a>
                            <form action="{{ route('admin.reviews.destroyAll', ['product' => $product->id]) }}"
                                method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm ml-2"
                                    onclick="return confirm('Are you sure you want to delete all reviews?')">Delete
                                    All Reviews</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No products available</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop