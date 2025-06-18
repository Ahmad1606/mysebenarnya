@extends('layouts.app')

@section('title', 'Set New Password')
@section('page-title', 'First-Time Password Reset')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h5 class="mb-3">Create Your New Password</h5>

        <form method="POST" action="{{ route('agency.password.reset.submit') }}">
            @csrf

            <div class="mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" name="new_password" id="new_password" class="form-control" required minlength="8">
            </div>

            <div class="mb-3">
                <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-key me-1"></i> Update Password
            </button>
        </form>
    </div>
</div>
@endsection
