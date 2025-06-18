@extends('layouts.app')
@section('content')
<div class="verify-status theme-public">
    <h3>{{ session('success') ?? session('error') }}</h3>
    <a href="{{ route('login') }}">Go to Login</a>
</div>
@endsection