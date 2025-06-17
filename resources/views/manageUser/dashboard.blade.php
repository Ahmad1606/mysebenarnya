<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Public Dashboard - MySebenarnya</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa;">

    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="#">MySebenarnya</a>
            <div class="ms-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <input type="hidden" name="role" value="public">
                    <button type="submit" class="btn btn-light btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        @if(session('message'))
            <div class="alert alert-success text-center">
                {{ session('message') }}
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="card-title">Welcome, {{ Auth::guard('public')->user()->PublicName }}!</h3>
                <p class="card-text">You have successfully logged in to your public user dashboard.</p>

                {{-- Future widgets or modules here --}}
                <p><strong>Email:</strong> {{ Auth::guard('public')->user()->PublicEmail }}</p>
                <p><strong>Contact:</strong> {{ Auth::guard('public')->user()->PublicContact }}</p>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
