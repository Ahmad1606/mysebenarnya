@extends('layouts.app')

@section('content')
<h2>Reject Inquiry</h2>
<form method="POST" action="{{ route('assignments.reject') }}">
    @csrf
    <label for="InquiryID">Inquiry ID:</label>
    <input type="number" name="InquiryID" required>

    <label for="RejectionReason">Reason:</label>
    <textarea name="RejectionReason" required></textarea>

    <button type="submit">Submit Rejection</button>
</form>

@if(session('message'))
    <p>{{ session('message') }}</p>
@endif
@endsection
