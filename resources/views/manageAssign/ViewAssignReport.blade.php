@extends('layouts.app')

@section('content')
<h2>Assignment Report</h2>

<form method="GET" action="{{ route('assignments.report') }}">
    <label>Filter by Agency:</label>
    <input name="agency" type="number">

    <label>Date Range:</label>
    <input type="date" name="start_date"> to <input type="date" name="end_date">

    <button type="submit">Filter</button>
</form>

<table>
    <tr>
        <th>Inquiry ID</th>
        <th>Agency</th>
        <th>Assigned At</th>
    </tr>
    @foreach($assignments as $assignment)
    <tr>
        <td>{{ $assignment->Inquiry_Id }}</td>
        <td>{{ $assignment->agency->AgencyUserName ?? 'N/A' }}</td>
        <td>{{ $assignment->Assigned_at }}</td>
    </tr>
    @endforeach
</table>
@endsection
