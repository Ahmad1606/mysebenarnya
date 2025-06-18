<header class="bg-primary text-white py-3">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h4 class="mb-0">MySebenarnya</h4>
        <div>
            @php
                $public = Auth::guard('public')->user();
                $agency = Auth::guard('agency')->user();
                $mcmc = Auth::guard('mcmc')->user();
                $role = $public ? 'Public User' : ($agency ? 'Agency Staff' : ($mcmc ? 'MCMC Staff' : 'Guest'));
                $user = $public ?? $agency ?? $mcmc;
            @endphp
            <span class="fw-bold">{{ $user?->name ?? $user?->PublicName ?? 'Guest' }}</span>
            <span class="ms-2 text-light">({{ $role }})</span>
        </div>
    </div>
</header>
