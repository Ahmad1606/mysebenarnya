@php
    $userType = Auth::guard('mcmc')->check() ? 'mcmc' : (Auth::guard('agency')->check() ? 'agency' : 'public');
@endphp

<div class="sidebar-header p-3 border-bottom">
    <h5 class="mb-0 text-center" style="color: var(--theme-primary);">
        <i class="fas fa-user-shield me-2"></i>{{ ucfirst($userType) }} Panel
    </h5>
</div>

<ul class="nav flex-column mt-3">
    <!-- Common Dashboard Link -->
    <li class="nav-item">
        <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
    </li>

    @if($userType == 'mcmc')
        <!-- MCMC Staff Navigation -->
        <li class="nav-item">
            <a href="{{ url('/mcmc/inquiries/new') }}" class="nav-link {{ request()->is('mcmc/inquiries/new') ? 'active' : '' }}">
                <i class="fas fa-inbox"></i> New Inquiries
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('/mcmc/inquiries/all') }}" class="nav-link {{ request()->is('mcmc/inquiries/all') ? 'active' : '' }}">
                <i class="fas fa-list-alt"></i> All Inquiries
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('/mcmc/users') }}" class="nav-link {{ request()->is('mcmc/users') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Manage Users
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('/report/inquiries') }}" class="nav-link {{ request()->is('report/inquiries') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i> Inquiry Reports
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('/report/assignments') }}" class="nav-link {{ request()->is('report/assignments') ? 'active' : '' }}">
                <i class="fas fa-tasks"></i> Assignment Reports
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('/report/users') }}" class="nav-link {{ request()->is('report/users') ? 'active' : '' }}">
                <i class="fas fa-user-chart"></i> User Reports
            </a>
        </li>
    @elseif($userType == 'agency')
        <!-- Agency Staff Navigation -->
        <li class="nav-item">
            <a href="{{ url('/agency/assignments') }}" class="nav-link {{ request()->is('agency/assignments') ? 'active' : '' }}">
                <i class="fas fa-tasks"></i> My Assignments
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('/agency/inquiries') }}" class="nav-link {{ request()->is('agency/inquiries') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list"></i> Inquiry History
            </a>
        </li>
    @else
        <!-- Public User Navigation -->
        <li class="nav-item">
            <a href="{{ url('/inquiries/submit') }}" class="nav-link {{ request()->is('inquiries/submit') ? 'active' : '' }}">
                <i class="fas fa-paper-plane"></i> Submit Inquiry
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('/inquiries/mine') }}" class="nav-link {{ request()->is('inquiries/mine') ? 'active' : '' }}">
                <i class="fas fa-history"></i> My Inquiries
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('/inquiries/public') }}" class="nav-link {{ request()->is('inquiries/public') ? 'active' : '' }}">
                <i class="fas fa-globe"></i> Public Inquiries
            </a>
        </li>
    @endif
    
    <!-- Common Navigation Items -->
    <li class="nav-item mt-3">
        <a href="{{ url('/profile/' . $userType) }}" class="nav-link {{ request()->is('profile/' . $userType) ? 'active' : '' }}">
            <i class="fas fa-user-circle"></i> My Profile
        </a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </li>
</ul>