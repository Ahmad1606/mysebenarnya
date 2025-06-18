<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MySebenarnya</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa;">

    {{-- Header --}}
    @include('layouts.header')

    {{-- Layout container: Sidebar + Content --}}
    <div class="d-flex">
        {{-- Sidebar Navigation --}}
        @include('layouts.navbar')

        {{-- Page Content Area --}}
        <div class="flex-grow-1 p-4">
            @yield('content')
        </div>
    </div>

    {{-- Footer --}}
    @include('layouts.footer')

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
