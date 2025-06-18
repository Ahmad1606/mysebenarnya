@extends('layouts.app')

@section('title', 'Manage Profile')
@section('page-title', 'Manage Profile')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">

        <!-- Profile Display -->
        <div id="profile-view">
            <h6 class="text-muted mb-3">User Details</h6>

            @if($role === 'public')
                <p><strong>Full Name:</strong> {{ $user->PublicName }}</p>
                <p><strong>Email:</strong> {{ $user->PublicEmail }}</p>
                <p><strong>Contact:</strong> {{ $user->PublicContact }}</p>
            @elseif($role === 'agency')
                <p><strong>Username:</strong> {{ $user->AgencyUserName }}</p>
                <p><strong>Email:</strong> {{ $user->AgencyEmail }}</p>
                <p><strong>Contact:</strong> {{ $user->AgencyContact }}</p>
            @elseif($role === 'mcmc')
                <p><strong>Username:</strong> {{ $user->MCMCUserName }}</p>
                <p><strong>Email:</strong> {{ $user->MCMCEmail }}</p>
            @endif

            <div class="d-flex gap-2 mt-4">
                <button class="btn btn-primary" onclick="toggleEdit(true)">
                    <i class="fas fa-pen me-1"></i> Edit Profile
                </button>
                <a href="#" class="btn btn-secondary">
                    <i class="fas fa-key me-1"></i> Change Password
                </a>
            </div>
        </div>

        <!-- Profile Edit Form -->
        <form method="POST" action="{{ route($role . '.profile.update') }}" id="profile-form" class="d-none mt-4">
            @csrf

            <h6 class="text-muted mb-3">Edit Details</h6>

            @if($role === 'public')
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="PublicName" class="form-control" value="{{ $user->PublicName }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="{{ $user->PublicEmail }}" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Contact</label>
                    <input type="text" name="PublicContact" class="form-control" value="{{ $user->PublicContact }}">
                </div>
            @elseif($role === 'agency')
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="AgencyUserName" class="form-control" value="{{ $user->AgencyUserName }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="{{ $user->AgencyEmail }}" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Contact</label>
                    <input type="text" name="AgencyContact" class="form-control" value="{{ $user->AgencyContact }}">
                </div>
            @elseif($role === 'mcmc')
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="MCMCUserName" class="form-control" value="{{ $user->MCMCUserName }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="{{ $user->MCMCEmail }}" disabled>
                </div>
            @endif

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-1"></i> Save Changes
                </button>
                <button type="button" class="btn btn-outline-secondary" onclick="toggleEdit(false)">
                    Cancel
                </button>
            </div>
        </form>

    </div>
</div>

<!-- Inline JS for toggle -->
<script>
    function toggleEdit(show) {
        document.getElementById('profile-view').classList.toggle('d-none', show);
        document.getElementById('profile-form').classList.toggle('d-none', !show);
    }
</script>
@endsection
