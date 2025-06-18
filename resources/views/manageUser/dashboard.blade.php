@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h3 class="card-title">Welcome, {{ Auth::guard('public')->user()->PublicName }}!</h3>
        <p class="card-text">You are now logged in as a Public User.</p>
    </div>
</div>
@endsection
