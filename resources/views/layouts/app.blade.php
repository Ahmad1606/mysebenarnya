<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MySebenarnya - News Verification System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --mcmc-primary: #1565c0;
            --mcmc-secondary: #e3f2fd;
            --agency-primary: #2e7d32;
            --agency-secondary: #e8f5e9;
            --public-primary: #ff8f00;
            --public-secondary: #fff8e1;
            --guest-primary: #546e7a;
            --guest-secondary: #f5f5f5;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        /* Theme colors */
        .theme-mcmc {
            --theme-primary: var(--mcmc-primary);
            --theme-secondary: var(--mcmc-secondary);
            --theme-accent: #0d47a1;
            background-color: var(--theme-secondary);
        }
        
        .theme-agency {
            --theme-primary: var(--agency-primary);
            --theme-secondary: var(--agency-secondary);
            --theme-accent: #1b5e20;
            background-color: var(--theme-secondary);
        }
        
        .theme-public {
            --theme-primary: var(--public-primary);
            --theme-secondary: var(--public-secondary);
            --theme-accent: #ef6c00;
            background-color: var(--theme-secondary);
        }
        
        .theme-guest {
            --theme-primary: var(--guest-primary);
            --theme-secondary: var(--guest-secondary);
            --theme-accent: #37474f;
            background-color: var(--theme-secondary);
        }
        
        /* Navbar styling */
        .navbar-custom {
            background-color: var(--theme-primary);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .navbar-custom .navbar-brand {
            font-weight: 700;
            color: white;
        }
        
        /* Card styling */
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 20px;
            border: none;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background-color: var(--theme-primary);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            font-weight: 600;
        }
        
        /* Button styling */
        .btn-theme-primary {
            background-color: var(--theme-primary);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 16px;
            transition: all 0.3s ease;
        }
        
        .btn-theme-primary:hover {
            background-color: var(--theme-accent);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .btn-outline-theme {
            color: var(--theme-primary);
            border: 1px solid var(--theme-primary);
            background-color: transparent;
            border-radius: 5px;
            padding: 8px 16px;
            transition: all 0.3s ease;
        }
        
        .btn-outline-theme:hover {
            background-color: var(--theme-primary);
            color: white;
        }
        
        /* Form styling */
        .form-control {
            border-radius: 5px;
            padding: 10px 15px;
            border: 1px solid #ced4da;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--theme-primary);
            box-shadow: 0 0 0 0.25rem rgba(var(--theme-primary-rgb), 0.25);
        }
        
        label {
            font-weight: 500;
            margin-bottom: 5px;
            color: #495057;
        }
        
        /* Table styling */
        .table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .table thead {
            background-color: var(--theme-primary);
            color: white;
        }
        
        /* Status badges */
        .badge-pending {
            background-color: #ff9800;
            color: white;
        }
        
        .badge-approved {
            background-color: #4caf50;
            color: white;
        }
        
        .badge-rejected {
            background-color: #f44336;
            color: white;
        }
        
        .badge-processing {
            background-color: #2196f3;
            color: white;
        }
        
        /* Dashboard cards */
        .dashboard-card {
            border-left: 5px solid var(--theme-primary);
        }
        
        .dashboard-card .card-icon {
            font-size: 2.5rem;
            color: var(--theme-primary);
        }
        
        /* Sidebar */
        .sidebar {
            background-color: white;
            min-height: calc(100vh - 56px);
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            position: sticky;
            top: 56px;
        }
        
        .sidebar .nav-link {
            color: #495057;
            padding: 12px 20px;
            border-radius: 5px;
            margin: 5px 10px;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: var(--theme-secondary);
            color: var(--theme-primary);
        }
        
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        /* Footer */
        footer {
            background-color: white;
            padding: 15px 0;
            margin-top: auto;
            box-shadow: 0 -2px 4px rgba(0,0,0,0.05);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                position: static;
                min-height: auto;
            }
        }
    </style>
    @yield('styles')
</head>
@php
    $guard = Auth::guard('mcmc')->check() ? 'mcmc' : (Auth::guard('agency')->check() ? 'agency' : (Auth::guard('public')->check() ? 'public' : 'guest'));
@endphp
<body class="theme-{{ $guard }}">
    @include('layouts.navbar')

    <div class="container-fluid">
        <div class="row">
            @auth
                <div class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                    @include('layouts.sidebar')
                </div>
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                    @yield('content')
                </main>
            @else
                <main class="col-12 py-4">
                    @yield('content')
                </main>
            @endauth
        </div>
    </div>
    
    <footer class="text-center py-3">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} MySebenarnya - News Verification System</p>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Custom JS -->
    <script>
        // Enable tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        // Enable popovers
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        });
    </script>
    @yield('scripts')
</body>
</html>
