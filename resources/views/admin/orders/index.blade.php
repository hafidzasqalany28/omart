@extends('adminlte::page')

@section('title', 'Manage Orders')

@section('content_header')
<h1>Manage Orders</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h3>Orders List:</h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Total Amount</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->formattedTotalAmount }}</td>
                                <td>{{ $order->created_at }}</td>
                                <td>{{ $order->status }}</td>
                                <td>
                                    <div class="btn-group ml-1 mt-1">
                                        <a href="{{ route('admin.orders.show', $order->id) }}"
                                            class="btn btn-info btn-sm">Show Details</a>
                                    </div>

                                    @if($order->status == 'processing')
                                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success btn-sm ml-1 mt-1">Mark as
                                            Completed</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No orders available</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop