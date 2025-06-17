@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Filter Inquiries</h2>
    <form action="{{ route('inquiry.filtered') }}" method="GET">
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="">All</option>
                <option value="pending">Pending</option>
                <option value="assigned">Assigned</option>
                <option value="resolved">Resolved</option>
            </select>
        </div>
        <button type="submit" class="btn btn-secondary">Filter</button>
    </form>

    <h3 class="mt-4">Filtered Results</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Status</th>
                <th>Submitted On</th>
            </tr>
        </thead>
        <tbody>
            @foreach($filteredInquiries as $inquiry)
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
