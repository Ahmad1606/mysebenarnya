<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - MySebenarnya</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa;">
    <div class="container mt-5" style="max-width: 600px;">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="mb-4 text-center">Public User Registration</h3>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="PublicName" class="form-control" required value="{{ old('PublicName') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="PublicEmail" class="form-control" required value="{{ old('PublicEmail') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="PublicContact" class="form-control" required value="{{ old('PublicContact') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="PublicPassword" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="PublicPassword_confirmation" class="form-control" required>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-success">Register</button>
                    </div>

                    <div class="text-center">
                        <small>Already registered? <a href="{{ route('login') }}">Login here</a></small>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
