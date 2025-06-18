@extends('layouts.app')
@section('content')
@php
    // Prepare arrays for chart
    $statusLabels = [];
    $statusCounts = [];
    foreach ($stats as $stat) {
        $statusLabels[] = ucfirst($stat->status);
        $statusCounts[] = $stat->total;
    }
@endphp
<div class="max-w-6xl mx-auto mt-8 p-8 bg-white rounded-lg shadow-xl border-2 border-pink-700">
    <h2 class="text-2xl font-bold mb-4 text-pink-800">Inquiry Report</h2>
    <form method="GET" class="flex items-center gap-4 mb-4">
        <input type="date" name="date_from" class="border rounded px-2">
        <input type="date" name="date_to" class="border rounded px-2">
        <button class="bg-pink-700 text-white px-4 py-2 rounded hover:bg-pink-800">Filter</button>
        <button name="format" value="pdf" class="ml-2 bg-indigo-700 text-white px-4 py-2 rounded">PDF</button>
        <button name="format" value="excel" class="bg-green-700 text-white px-4 py-2 rounded">Excel</button>
    </form>
    <canvas id="inquiryChart" class="mt-8"></canvas>
    <div class="overflow-x-auto mt-4">
        <table class="w-full table-auto border-collapse">
            <thead class="bg-pink-100">
                <tr>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stats as $stat)
                    <tr>
                        <td class="border px-4 py-2">{{ ucfirst($stat->status) }}</td>
                        <td class="border px-4 py-2">{{ $stat->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const chartLabels = {!! json_encode($statusLabels) !!};
    const chartData = {!! json_encode($statusCounts) !!};
    const ctx = document.getElementById('inquiryChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Inquiry Count',
                data: chartData,
                backgroundColor: ['#f06292','#ba68c8','#4fc3f7','#81c784','#ffd54f','#ff8a65','#7986cb']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Total Inquiries by Status'
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