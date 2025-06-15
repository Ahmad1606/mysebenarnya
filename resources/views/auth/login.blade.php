@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Login</h2>

    @if($errors->has('login'))
        <div class="alert alert-danger">{{ $errors->first('login') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control" required>
                <option value="public">Public User</option>
                <option value="agency">Agency User</option>
                <option value="mcmc">MCMC User</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
@endsection
