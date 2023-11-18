@extends('adminlte::page')

@section('title', 'Edit Role')

@section('content_header')
<h1>Edit Role</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Role Name:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $role->name }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Role</button>
        </form>
    </div>
</div>
@stop