<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - MySebenarnya</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa;">
    <div class="container mt-5" style="max-width: 500px;">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="mb-4 text-center">Login</h3>

                {{-- Show validation error for login --}}
                 @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
                 @if (session('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="identifier" class="form-label">Email / Username</label>
                        <input type="text" name="identifier" id="identifier" class="form-control" required value="{{ old('identifier') }}">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Login As</label>
                        <select name="role" id="role" class="form-select" required>
                            <option value="">-- Select Role --</option>
                            <option value="public">Public User</option>
                            <option value="agency">Agency User</option>
                            <option value="mcmc">MCMC User</option>
                        </select>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>

                <div class="text-center">
                    <small>Not Registered? <a href="{{ route('register') }}">Register Now</a></small>
                </div>
            </div>
        </div>
    </div>

   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
