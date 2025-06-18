@extends('layouts.app')
@section('content')
<div class="forgot-box theme-{{ $guard }}">
    <h2>Forgot Password ({{ ucfirst($guard) }})</h2>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <input type="hidden" name="guard" value="{{ $guard }}">
        <label>Email</label><input type="email" name="email" required>
        <button type="submit">Send Reset Link</button>
    </form>
</div>
@endsection