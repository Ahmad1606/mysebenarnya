@extends('layouts.app')
@section('content')
<div class="max-w-xl mx-auto mt-10 p-8 bg-white rounded-lg shadow-xl border-2 border-green-700">
    <h2 class="text-2xl font-bold mb-4 text-green-800">Jurisdiction Review</h2>
    <div class="mb-4">
        <strong>News Detail:</strong>
        <div class="bg-gray-100 p-2 rounded">{{ $inquiry->news_detail }}</div>
    </div>
    <form method="POST" action="{{ url('/manageAssign/JurisdictionForm/'.$inquiry->id) }}">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Decision</label>
            <select name="decision" class="w-full rounded border-gray-300" required>
                <option value="">Select</option>
                <option value="accept">Accept</option>
                <option value="reject">Reject</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Comment</label>
            <textarea name="comment" class="w-full border-gray-300 rounded" rows="3"></textarea>
        </div>
        <button type="submit" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800">
            Submit
        </button>
    </form>
</div>
@endsection