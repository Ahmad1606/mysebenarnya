@extends('layouts.app')
@section('content')
<div class="max-w-lg mx-auto mt-12 p-8 bg-white rounded-lg shadow-lg border-2 border-red-600">
    <h2 class="text-2xl font-bold text-red-700 mb-4">Rejection Reason</h2>
    <form method="POST" action="{{ url('/manageAssign/RejectionForm/'.$inquiry->id) }}">
        @csrf
        <label class="block mb-2 font-semibold">Reason for Rejection</label>
        <textarea name="comment" class="w-full border-gray-300 rounded" rows="4" required></textarea>
        <button type="submit" class="mt-4 bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
            Submit Reason
        </button>
    </form>
</div>
@endsection