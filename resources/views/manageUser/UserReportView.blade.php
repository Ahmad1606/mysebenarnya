@extends('layouts.app')
@section('content')
<div class="report-view theme-mcmc">
    <h2>User Report</h2>
    <form method="GET" action="{{ route('report.users') }}">
        <input type="date" name="date_from"> to <input type="date" name="date_to">
        <select name="type">
            <option value="">All Types</option>
            <option value="public">Public</option>
            <option value="agency">Agency</option>
        </select>
        <button type="submit">Filter</button>
        <button name="format" value="pdf">Download PDF</button>
        <button name="format" value="excel">Download Excel</button>
    </form>
    <table>
        <tr><th>Name</th><th>Email</th><th>Contact</th><th>Role</th><th>Registered</th></tr>
        @foreach($users as $u)
            <tr>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->contact }}</td>
                <td>{{ $u->role }}</td>
                <td>{{ $u->created_at }}</td>
            </tr>
        @endforeach
    </table>
</div>
@endsection