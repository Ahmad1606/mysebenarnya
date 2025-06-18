<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - MySebenarnya</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa;">
    <div class="container mt-5" style="max-width: 500px;">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="mb-4 text-center">MySebenarnya-Login</h3>

                {{-- Flash messages --}}
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
                            <option value="agency">Agency</option>
                            <option value="mcmc">MCMC</option>
                        </select>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>

                <div class="text-center">
                    <small>Not Registered? <a href="{{ route('register') }}">Register Now</a></small><br>
                    <a href="#" class="text-decoration-none mt-2 d-inline-block" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">
                        Forgot Password?
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forgotPasswordModalLabel">Reset Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reset-role" class="form-label">Role</label>
                        <select name="role" id="reset-role" class="form-select" required>
                            <option value="">-- Select Role --</option>
                            <option value="public">Public</option>
                            <option value="agency">Agency</option>
                            <option value="mcmc">MCMC</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="reset-email" class="form-label">Registered Email</label>
                        <input type="email" name="email" id="reset-email" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Send Reset Link</button>
                </div>
            </div>
        </form>
      </div>
    </div>

    <!-- First-Time Agency Password Reset Modal -->
    @if(session('first_time_login'))
    <div class="modal fade" id="firstTimeResetModal" tabindex="-1" aria-labelledby="firstTimeResetModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('agency.password.reset.submit') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="firstTimeResetModalLabel">Set Your New Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3">This is your first time logging in. Please set a new password to proceed.</p>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" name="new_password" class="form-control" required minlength="8">
                        </div>
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Auto-open first-time reset modal if session flag is true
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('first_time_login'))
                let resetModal = new bootstrap.Modal(document.getElementById('firstTimeResetModal'));
                resetModal.show();
            @endif
        });
    </script>
</body>
</html>
