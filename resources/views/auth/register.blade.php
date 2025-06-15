@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Register</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label>Register As</label>
            <select name="role" id="role" class="form-control" required>
                <option value="">Select Role</option>
                <option value="public">Public User</option>
                <option value="agency">Agency User</option>
                <option value="mcmc">MCMC User</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3" id="usernameField" style="display: none;">
            <label>Username (MCMC only)</label>
            <input type="text" name="username" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <div class="mb-3" id="positionField" style="display: none;">
            <label>Position (Agency only)</label>
            <input type="text" name="position" class="form-control">
        </div>

        <div class="mb-3" id="mcmcField" style="display: none;">
            <label>MCMC ID (Agency only)</label>
            <input type="number" name="mcmcid" class="form-control">
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Register</button>
    </form>
</div>

<script>
    document.getElementById('role').addEventListener('change', function () {
        const role = this.value;
        document.getElementById('usernameField').style.display = (role === 'mcmc') ? 'block' : 'none';
        document.getElementById('positionField').style.display = (role === 'agency') ? 'block' : 'none';
        document.getElementById('mcmcField').style.display = (role === 'agency') ? 'block' : 'none';
    });
</script>
@endsection
