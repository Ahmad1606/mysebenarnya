@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">My Profile</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name', $user->pu_name ?? $user->AUname ?? $user->MCName) }}" required>
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control"
                   value="{{ old('phone', $user->pu_phone_number ?? $user->AUphone_number ?? $user->MCContact) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>
@endsection
