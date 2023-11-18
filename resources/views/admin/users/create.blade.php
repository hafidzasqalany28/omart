@extends('adminlte::page')

@section('title', 'Create User')

@section('content_header')
<h1>Create User</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="role_id">Role:</label>
                <select name="role_id" id="role_id" class="form-control" required>
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <textarea name="address" id="address" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" name="phone_number" id="phone_number" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Create User</button>
        </form>
    </div>
</div>
@stop