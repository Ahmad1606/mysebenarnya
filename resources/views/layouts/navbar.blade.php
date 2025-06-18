<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <i class="fas fa-check-circle me-2"></i>MySebenarnya
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ url('/inquiries/public') }}">
                        <i class="fas fa-globe me-1"></i> Public Inquiries
                    </a>
                </li>
            </ul>
            
            <div class="d-flex align-items-center">
                @auth
                    @php
                        $userType = Auth::guard('mcmc')->check() ? 'mcmc' : (Auth::guard('agency')->check() ? 'agency' : 'public');
                    @endphp
                    
                    <a class="btn btn-light me-2" href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                    </a>
                    
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> {{ ucfirst($userType) }} Account
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ url('/profile/' . $userType) }}">
                                    <i class="fas fa-user me-2"></i> My Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a class="btn btn-light me-2" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt me-1"></i> Login
                    </a>
                    <a class="btn btn-outline-light" href="{{ route('register') }}">
                        <i class="fas fa-user-plus me-1"></i> Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
