@php
    $role = session('role') ?? (
        Auth::guard('public')->check() ? 'public' :
        (Auth::guard('agency')->check() ? 'agency' :
        (Auth::guard('mcmc')->check() ? 'mcmc' : 'guest'))
    );
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'MySebenarnya')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Bootstrap 5 & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Header -->
    <header class="py-3 px-4 text-white d-flex justify-content-between align-items-center"
            style="background-color: #0c4a6e;">
        <h4 class="fw-bold mb-0">MySebenarnya</h4>
        <div class="d-flex align-items-center gap-3">
            <span class="fw-semibold">{{ Auth::guard($role)->user()->{ucfirst($role).'Name'} ?? 'User' }}</span>
            <div class="bg-primary text-white rounded-circle fw-bold d-flex justify-content-center align-items-center"
                style="width: 36px; height: 36px;">
                {{
                    $role === 'public' ? 'P' :
                    ($role === 'agency' ? 'A' :
                    ($role === 'mcmc' ? 'MC' : 'XX'))
                }}
            </div>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <input type="hidden" name="role" value="{{ $role }}">
                <button class="btn btn-danger btn-sm text-white">Logout</button>
            </form>
        </div>
    </header>

    <!-- Body -->
    <div class="container-fluid">
        <div class="row min-vh-100">

            <!-- Sidebar -->
            <aside class="col-md-3 col-lg-2 p-3 bg-transparent">
                <div class="card shadow-sm border-0">
                    <div class="bg-primary text-white px-3 py-2 rounded-top">
                        <h6 class="mb-0 fw-semibold">
                            @switch($role)
                                @case('public')
                                    Public User Menu
                                    @break
                                @case('agency')
                                    Event Advisor Menu
                                    @break
                                @case('mcmc')
                                    MCMC Admin Menu
                                    @break
                                @default
                                    Menu
                            @endswitch
                        </h6>
                    </div>

                    <ul class="nav flex-column px-2 py-3">
                        @php $current = request()->route()->getName(); @endphp

                        @if($role === 'public')
                            <li class="nav-item mb-1">
                                <a href="{{ route('public.profile') }}"
                                   class="nav-link d-flex align-items-center rounded {{ $current === 'public.profile' ? 'active fw-semibold text-primary' : 'text-dark' }}">
                                    <i class="fas fa-user me-2"></i> Manage Profile
                                </a>
                            </li>
                            <li class="nav-item mb-1">
                                <a href="#"
                                   class="nav-link d-flex align-items-center rounded text-dark">
                                    <i class="fas fa-pen-to-square me-2"></i> Submit Inquiry
                                </a>
                            </li>
                            <li class="nav-item mb-1">
                                <a href="#"
                                   class="nav-link d-flex align-items-center rounded text-dark">
                                    <i class="fas fa-spinner me-2"></i> Inquiry Progress
                                </a>
                            </li>

                        @elseif($role === 'agency')
                            <li class="nav-item mb-1">
                                <a href="{{ route('agency.dashboard') }}"
                                   class="nav-link d-flex align-items-center rounded {{ $current === 'agency.dashboard' ? 'active fw-semibold text-primary' : 'text-dark' }}">
                                    <i class="fas fa-chart-line me-2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item mb-1">
                                <a href="{{ route('agency.profile') }}"
                                   class="nav-link d-flex align-items-center rounded {{ $current === 'agency.profile' ? 'active fw-semibold text-primary' : 'text-dark' }}">
                                    <i class="fas fa-user me-2"></i> Manage Profile
                                </a>
                            </li>
                            <li class="nav-item mb-1">
                                <a href="#"
                                   class="nav-link d-flex align-items-center rounded text-dark">
                                    <i class="fas fa-folder-open me-2"></i> Manage Inquiry
                                </a>
                            </li>

                        @elseif($role === 'mcmc')
                            <li class="nav-item mb-1">
                                <a href="{{ route('mcmc.dashboard') }}"
                                   class="nav-link d-flex align-items-center rounded {{ $current === 'mcmc.dashboard' ? 'active fw-semibold text-primary' : 'text-dark' }}">
                                    <i class="fas fa-chart-line me-2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item mb-1">
                                <a href="{{ route('mcmc.profile') }}"
                                   class="nav-link d-flex align-items-center rounded {{ $current === 'mcmc.profile' ? 'active fw-semibold text-primary' : 'text-dark' }}">
                                    <i class="fas fa-user me-2"></i> Manage Profile
                                </a>
                            </li>
                            <li class="nav-item mb-1">
                                <a href="#"
                                   class="nav-link d-flex align-items-center rounded text-dark">
                                    <i class="fas fa-users-gear me-2"></i> Manage User
                                </a>
                            </li>
                            <li class="nav-item mb-1">
                                <a href="#"
                                   class="nav-link d-flex align-items-center rounded text-dark">
                                    <i class="fas fa-folder-open me-2"></i> Manage Inquiry
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-3 bg-white border-top">
        @yield('footer', '© ' . date('Y') . ' MySebenarnya. All rights reserved.')
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
