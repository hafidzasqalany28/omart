@extends('adminlte::page')

@section('title', 'Product Reviews')

@section('content_header')
<h1>Product Reviews - {{ $product->name }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Reviews for {{ $product->name }}</h3>
    </div>
    <div class="card-body">
        <table class="table table-responsive-md">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Comment</th>
                    <th>User</th>
                    <th>Rating</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th> <!-- New column for delete button -->
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                <tr>
                    <td>{{ $review->id }}</td>
                    <td>{{ $review->comment }}</td>
                    <td>{{ $review->user->name }}</td>
                    <td>{{ $review->rating }}/5</td>
                    <td>{{ $review->created_at }}</td>
                    <td>{{ $review->updated_at }}</td>
                    <td>
                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this review?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No reviews available for this product</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop