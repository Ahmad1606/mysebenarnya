@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header text-center py-4">
                    <h3 class="mb-0">
                        <i class="fas fa-user-shield me-2"></i>{{ ucfirst($guard) }} Login
                    </h3>
                </div>
                <div class="card-body p-4 p-md-5">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <input type="hidden" name="guard" value="{{ $guard }}">
                        
                        <div class="mb-4">
                            <label for="username" class="form-label">
                                <i class="fas fa-user me-2"></i>{{ $guard === 'public' ? 'Email Address' : 'Username' }}
                            </label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                id="username" name="username" value="{{ old('username') }}" 
                                placeholder="{{ $guard === 'public' ? 'Enter your email' : 'Enter your username' }}" required autofocus>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Password
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                    id="password" name="password" placeholder="Enter your password" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-theme-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3">
                    <div class="mb-2">
                        <a href="{{ route('password.request', ['guard' => $guard]) }}" class="text-decoration-none">
                            <i class="fas fa-key me-1"></i>Forgot Password?
                        </a>
                    </div>
                    
                    @if($guard === 'public')
                        <div>
                            Don't have an account?
                            <a href="{{ route('register') }}" class="text-decoration-none">
                                <i class="fas fa-user-plus me-1"></i>Register
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="text-center mt-4">
                <div class="btn-group" role="group" aria-label="User type selection">
                    <a href="{{ url('/login?guard=public') }}" class="btn {{ $guard === 'public' ? 'btn-theme-primary' : 'btn-outline-theme' }}">
                        <i class="fas fa-user me-1"></i>Public
                    </a>
                    <a href="{{ url('/login?guard=agency') }}" class="btn {{ $guard === 'agency' ? 'btn-theme-primary' : 'btn-outline-theme' }}">
                        <i class="fas fa-building me-1"></i>Agency
                    </a>
                    <a href="{{ url('/login?guard=mcmc') }}" class="btn {{ $guard === 'mcmc' ? 'btn-theme-primary' : 'btn-outline-theme' }}">
                        <i class="fas fa-user-tie me-1"></i>MCMC
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>
@endsection
@endsection