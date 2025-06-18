@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Your Inquiry History</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Inquiry ID</th>
                <th>Type</th>
                <th>Status</th>
                <th>Submitted On</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inquiries as $inquiry)
                <tr>
                    <td>{{ $inquiry->id }}</td>
                    <td>{{ $inquiry->inquiry_type }}</td>
                    <td>{{ $inquiry->status }}</td>
                    <td>{{ $inquiry->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
