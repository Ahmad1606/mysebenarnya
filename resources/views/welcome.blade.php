<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to MySebenarnya</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">MySebenarnya</a>
        </div>
    </nav>

    <div class="container text-center my-auto mt-5">
        <h1 class="display-4">Welcome to MySebenarnya</h1>
        <p class="lead mt-3">A centralized platform for submitting and managing inquiries across agencies and MCMC.</p>

        <div class="mt-4">
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg mx-2">Login</a>
            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg mx-2">Register</a>
        </div>
    </div>

    <footer class="mt-auto py-3 bg-light text-center">
        <div class="container">
            <small class="text-muted">&copy; 2025 MySebenarnya - Powered by UMPSA</small>
        </div>
    </footer>

</body>
</html>
