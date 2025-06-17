@extends('layouts.app')

@section('content')
<h2>Assign Inquiry to Agency</h2>
<form action="{{ route('assign.agency') }}" method="POST">
    @csrf
    <label for="InquiryID">Inquiry ID:</label>
    <input type="number" name="InquiryID" required>

    <label for="AgencyID">Select Agency:</label>
    <select name="AgencyID" required>
        @foreach($agencies as $agency)
            <option value="{{ $agency->AgencyID }}">{{ $agency->AgencyUserName }}</option>
        @endforeach
    </select>

    <button type="submit">Assign</button>
</form>
@if(session('success'))
    <p>{{ session('success') }}</p>
@endif
@endsection
