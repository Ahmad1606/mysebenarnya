@extends('layouts.app')

@section('title', 'User Report')

@section('content')
<h4 class="fw-bold mb-4">User Report ({{ ucfirst($type) }})</h4>

@if(is_iterable($data))
    @foreach($data as $role => $list)
        <div class="mb-4">
            <h6 class="fw-semibold">{{ ucfirst($role) }} Users ({{ $list->count() }})</h6>
            <ul>
                @foreach($list as $user)
                    <li>{{ $user->PublicName ?? $user->AgencyUserName ?? $user->MCMCUserName }}</li>
                @endforeach
            </ul>
        </div>
    @endforeach
@else
    <div>
        <h6 class="fw-semibold">{{ ucfirst($type) }} Users ({{ $data->count() }})</h6>
        <ul>
            @foreach($data as $user)
                <li>{{ $user->PublicName ?? $user->AgencyUserName ?? $user->MCMCUserName }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endsection
