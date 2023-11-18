@extends('adminlte::page')

@section('title', 'Create Category')

@section('content_header')
<h1>Create Category</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Category Name:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Create Category</button>
        </form>
    </div>
</div>
@stop