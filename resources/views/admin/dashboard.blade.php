@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fas fa-shopping-cart"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Orders</span>
                <span class="info-box-number">{{ $totals['Orders'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fas fa-box"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Products</span>
                <span class="info-box-number">{{ $totals['Products'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Users</span>
                <span class="info-box-number">{{ $totals['Users'] }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-primary"><i class="fas fa-list"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Categories</span>
                <span class="info-box-number">{{ $totals['Categories'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-secondary"><i class="fas fa-star"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Reviews</span>
                <span class="info-box-number">{{ $totals['Reviews'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-danger"><i class="fas fa-percent"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Promos</span>
                <span class="info-box-number">{{ $totals['Promos'] }}</span>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Monthly Sales Chart</h3>
            </div>
            <div class="card-body">
                <canvas id="barChart" height="285"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Latest Promos</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Discount Percentage</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestPromos as $promo)
                        <tr>
                            <td>{{ $promo->product->name }}</td>
                            <td>{{ $promo->name }}</td>
                            <td>{{ $promo->description }}</td>
                            <td>{{ $promo->discount_percentage }}%</td>
                            <td>
                                <a href="{{ route('admin.promos.index') }}" class="text-muted">
                                    <i class="fas fa-search"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">No latest promos</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @foreach(['Orders', 'Products', 'Categories', 'Reviews'] as $key)
    <div class="col-md-6">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">Latest {{ $key }}</h3>
                <div class="card-tools">
                    {{-- <div class="btn-group">
                        <button type="button" class="btn btn-tool btn-sm">
                            Sort
                        </button>
                        <button type="button" class="btn btn-tool btn-sm dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Ascending</a>
                            <a class="dropdown-item" href="#">Descending</a>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                    <thead>
                        <tr>
                            @if($key === 'Orders')
                            <th>Order Id</th>
                            <th>User</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            @elseif($key === 'Products')
                            <th>Name</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            @elseif($key === 'Categories')
                            <th>Name</th>
                            <th>Total Products</th>
                            @else
                            <th>User Name</th>
                            <th>Product Name</th>
                            <th>Comment</th>
                            <th>Rating</th>
                            @endif
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(${"latest$key"} as $item)
                        <tr>
                            @if($key === 'Orders')
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->formattedTotalAmount }}</td>
                            <td>
                                @if($item->status == 'completed')
                                <span class="badge bg-success">{{ $item->status }}</span>
                                @elseif($item->status == 'pending')
                                <span class="badge bg-warning">{{ $item->status }}</span>
                                @else
                                <span class="badge bg-danger">{{ $item->status }}</span>
                                @endif
                            </td>
                            @elseif($key === 'Products')
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->formattedPrice }}</td>
                            <td>{{ $item->category->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            @elseif($key === 'Categories')
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->products_count }}</td>
                            @else
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->comment }}</td>
                            <td>{{ $item->rating }}</td>
                            @endif
                            <td>
                                <a href="{{ route('admin.' . strtolower($key) . '.index') }}" class="text-muted">
                                    <i class="fas fa-search"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ $key === 'Categories' ? '3' : '5' }}">No latest {{ strtolower($key) }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endforeach
</div>
@stop

@push('js')
<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Chart styles -->
<style>
    canvas {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
</style>

<!-- Chart scripts -->
<script>
    // Function to create a bar chart
    function createBarChart(labels, salesData, revenueData) {
        var ctx = document.getElementById('barChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Total Sales',
                        data: salesData,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Total Revenue',
                        data: revenueData,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Assume you have passed the data from the controller
    var months = {!! json_encode($months) !!};
    var sales = {!! json_encode($sales) !!};
    var revenue = {!! json_encode($revenue) !!};

    // Call the function with your data
    document.addEventListener('DOMContentLoaded', function () {
        createBarChart(months, sales, revenue);
    });
</script>
@endpush