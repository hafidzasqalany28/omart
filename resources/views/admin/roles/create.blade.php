@extends('adminlte::page')

@section('title', 'Create Role')

@section('content_header')
<h1>Create Role</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Role Name:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Create Role</button>
        </form>
    </div>
</div>
@stop