@extends('layouts.app')

@section('content')
<h2>Agency Jurisdiction</h2>
<table>
    <tr>
        <th>Agency Name</th>
        <th>Contact</th>
    </tr>
    @foreach($agencies as $agency)
    <tr>
        <td>{{ $agency->AgencyUserName }}</td>
        <td>{{ $agency->AgencyContact }}</td>
    </tr>
    @endforeach
</table>
@endsection
