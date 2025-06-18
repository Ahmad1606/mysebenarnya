@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-lg mt-4 mb-4">
                <div class="card-header text-center py-4">
                    <h3 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i>Register as Public User
                    </h3>
                    <p class="text-muted mt-2 mb-0">Create your account to submit news verification inquiries</p>
                </div>
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" enctype="multipart/form-data" action="{{ route('register') }}" class="needs-validation" novalidate>
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-2"></i>Full Name
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                    id="name" name="name" value="{{ old('name') }}" 
                                    placeholder="Enter your full name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>Email Address
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                    id="email" name="email" value="{{ old('email') }}" 
                                    placeholder="Enter your email address" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">We'll send a verification link to this email</div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="contact" class="form-label">
                                <i class="fas fa-phone me-2"></i>Contact Number
                            </label>
                            <input type="text" class="form-control @error('contact') is-invalid @enderror" 
                                id="contact" name="contact" value="{{ old('contact') }}" 
                                placeholder="Enter your contact number" required>
                            @error('contact')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Password
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                        id="password" name="password" 
                                        placeholder="Create a password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">Must be at least 8 characters long</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Confirm Password
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control" 
                                        id="password_confirmation" name="password_confirmation" 
                                        placeholder="Confirm your password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="profile_pic" class="form-label">
                                <i class="fas fa-image me-2"></i>Profile Picture (Optional)
                            </label>
                            <input type="file" class="form-control @error('profile_pic') is-invalid @enderror" 
                                id="profile_pic" name="profile_pic" accept="image/*">
                            @error('profile_pic')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Maximum file size: 2MB (JPG, PNG)</div>
                        </div>
                        
                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms of Service</a> and <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">Privacy Policy</a>
                            </label>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-theme-primary btn-lg">
                                <i class="fas fa-user-plus me-2"></i>Create Account
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3">
                    <div>
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-decoration-none">
                            <i class="fas fa-sign-in-alt me-1"></i>Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Terms of Service Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Terms of Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>1. Acceptance of Terms</h6>
                <p>By registering for an account on MySebenarnya, you agree to these Terms of Service.</p>
                
                <h6>2. User Responsibilities</h6>
                <p>Users are responsible for maintaining the confidentiality of their account information and for all activities that occur under their account.</p>
                
                <h6>3. Acceptable Use</h6>
                <p>Users agree to submit genuine inquiries and not to use the service for spreading misinformation or harmful content.</p>
                
                <h6>4. Content Submission</h6>
                <p>Users grant MySebenarnya the right to review, verify, and publish submitted content as part of the verification process.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-theme-primary" data-bs-dismiss="modal">I Understand</button>
            </div>
        </div>
    </div>
</div>

<!-- Privacy Policy Modal -->
<div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="privacyModalLabel">Privacy Policy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>1. Information Collection</h6>
                <p>We collect personal information such as name, email, and contact number for account creation and verification purposes.</p>
                
                <h6>2. Information Usage</h6>
                <p>Your information will be used to process inquiries, communicate verification results, and improve our services.</p>
                
                <h6>3. Information Sharing</h6>
                <p>We may share your information with relevant government agencies for the purpose of news verification.</p>
                
                <h6>4. Data Security</h6>
                <p>We implement appropriate security measures to protect your personal information from unauthorized access or disclosure.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-theme-primary" data-bs-dismiss="modal">I Understand</button>
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
    
    document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password_confirmation');
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
    
    // Preview profile picture
    document.getElementById('profile_pic').addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // You could add image preview functionality here if desired
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
@endsection
@endsection