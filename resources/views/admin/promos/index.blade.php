<!-- resources/views/admin/promos/index.blade.php -->

@extends('adminlte::page')

@section('title', 'Manage Promos')

@section('content_header')
<h1>Manage Promos</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">List of Promos</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <a href="{{ route('admin.promos.create') }}" class="btn btn-primary mb-2">Create Promo</a>
        <table class="table table-responsive-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Discount Percentage</th>
                    <th>Product</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($promos as $promo)
                <tr>
                    <td>{{ $promo->id }}</td>
                    <td>{{ $promo->name }}</td>
                    <td>{{ $promo->description }}</td>
                    <td>{{ $promo->discount_percentage }}</td>
                    <td>{{ $promo->product->name }}</td>
                    <td>{{ $promo->start_date }}</td>
                    <td>{{ $promo->end_date }}</td>
                    <td>{{ $promo->created_at }}</td>
                    <td>{{ $promo->updated_at }}</td>
                    <td>
                        {{-- <a href="{{ route('admin.promos.show', $promo->id) }}" class="btn btn-info btn-sm">Show</a>
                        --}}
                        <a href="{{ route('admin.promos.edit', $promo->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.promos.destroy', $promo->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this promo?')">Delete</button>
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