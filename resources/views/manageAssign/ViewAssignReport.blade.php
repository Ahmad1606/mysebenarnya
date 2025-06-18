@extends('layouts.app')
@section('content')
@php
    // Prepare arrays for chart
    $assignmentLabels = [];
    $assignmentCounts = [];
    foreach ($stats as $stat) {
        $agency = $agencies->find($stat->assigned_agency_id);
        $assignmentLabels[] = $agency ? $agency->name : 'Unknown';
        $assignmentCounts[] = $stat->total;
    }
@endphp
<div class="max-w-6xl mx-auto mt-8 p-8 bg-white rounded-lg shadow-xl border-2 border-indigo-600">
    <h2 class="text-2xl font-bold mb-4 text-indigo-800">Assignment Report</h2>
    <form method="GET" class="flex items-center gap-4 mb-4">
        <input type="date" name="date_from" class="border rounded px-2">
        <input type="date" name="date_to" class="border rounded px-2">
        <select name="agency_id" class="border rounded px-2">
            <option value="">All Agencies</option>
            @foreach($agencies as $agency)
                <option value="{{ $agency->id }}">{{ $agency->name }}</option>
            @endforeach
        </select>
        <button class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Filter</button>
        <button name="format" value="pdf" class="ml-2 bg-pink-700 text-white px-4 py-2 rounded">PDF</button>
        <button name="format" value="excel" class="bg-green-700 text-white px-4 py-2 rounded">Excel</button>
    </form>
    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse">
            <thead class="bg-indigo-100">
                <tr>
                    <th class="px-4 py-2">Agency</th>
                    <th class="px-4 py-2">Total Inquiries Assigned</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stats as $stat)
                    <tr>
                        <td class="border px-4 py-2">
                            {{ optional($agencies->find($stat->assigned_agency_id))->name ?? 'Unknown' }}
                        </td>
                        <td class="border px-4 py-2">{{ $stat->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <canvas id="assignmentChart" class="mt-8"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const chartLabels = {!! json_encode($assignmentLabels) !!};
    const chartData = {!! json_encode($assignmentCounts) !!};
    const ctx = document.getElementById('assignmentChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Assigned Inquiries',
                data: chartData,
                backgroundColor: 'rgba(63,81,181,0.7)'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Total Assignments Per Agency'
                }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
});
</script>
@endsection