@extends('layouts.app')
@section('content')
<div class="first-login theme-agency">
    <h2>First Login: Set New Password</h2>
    <form method="POST" action="{{ route('agency.first-login-reset') }}">
        @csrf
        <label>New Password</label><input type="password" name="new_password" required>
        <label>Confirm New Password</label><input type="password" name="new_password_confirmation" required>
        <button type="submit">Update Password</button>
    </form>
</div>
@endsection