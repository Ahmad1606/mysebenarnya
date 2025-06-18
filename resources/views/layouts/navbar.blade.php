<div class="bg-success text-white vh-100 p-3" style="width: 250px;">
    <h5>Navigation</h5>
    <ul class="nav flex-column">

        @if(Auth::guard('public')->check())
            <li class="nav-item"><a href="{{ route('public.profile') }}" class="nav-link text-white">Manage Profile</a></li>
            <li class="nav-item"><a href="#" class="nav-link text-white">Submit Inquiry</a></li>
            <li class="nav-item"><a href="#" class="nav-link text-white">Inquiry Progress</a></li>

        @elseif(Auth::guard('agency')->check())
            <li class="nav-item"><a href="#" class="nav-link text-white">Dashboard</a></li>
            <li class="nav-item"><a href="#" class="nav-link text-white">Agency Profile</a></li>

        @elseif(Auth::guard('mcmc')->check())
            <li class="nav-item"><a href="#" class="nav-link text-white">Dashboard</a></li>
            <li class="nav-item"><a href="#" class="nav-link text-white">User Management</a></li>
        @endif

        <li class="nav-item mt-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-light w-100">Logout</button>
            </form>
        </li>
    </ul>
</div>
