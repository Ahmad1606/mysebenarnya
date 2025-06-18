@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto mt-10 p-8 bg-white rounded-lg shadow-xl border-2 border-yellow-700">
    <h2 class="text-2xl font-bold mb-4 text-yellow-800">Inquiry History</h2>
    <div class="mb-4">
        <strong>News:</strong>
        <div class="bg-gray-100 p-2 rounded">{{ $inquiry->news_detail }}</div>
    </div>
    <h3 class="font-semibold mb-2">Progress Timeline</h3>
    <ul class="timeline">
        @foreach($inquiry->progress as $prog)
            <li class="mb-4">
                <span class="font-semibold">{{ ucfirst($prog->type) }}</span>
                —
                <span class="text-sm text-gray-500">{{ $prog->created_at->diffForHumans() }}</span>
                @if($prog->file_path)
                    <div>
                        <a href="{{ asset('storage/'.$prog->file_path) }}" class="text-blue-600 underline" target="_blank">View Evidence</a>
                    </div>
                @endif
                @if($prog->link)
                    <div>
                        <a href="{{ $prog->link }}" class="text-blue-600 underline" target="_blank">View Link</a>
                    </div>
                @endif
                @if($prog->notes)
                    <div class="italic text-gray-700">{{ $prog->notes }}</div>
                @endif
            </li>
        @endforeach
    </ul>
</div>
@endsection