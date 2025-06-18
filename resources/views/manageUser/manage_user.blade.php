@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Manage Users</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerAgencyModal">
            <i class="fas fa-plus me-2"></i> Register New Agency
        </button>
    </div>

    {{-- Messages --}}
    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Tabs for filtering --}}
    <ul class="nav nav-tabs mb-3" id="userTabs">
        <li class="nav-item">
            <button class="nav-link active" data-role="public">Public Users</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-role="agency">Agency Users</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-role="mcmc">MCMC Users</button>
        </li>
    </ul>

    {{-- Public Users --}}
    <div class="card mb-4 user-card" data-role="public">
        <div class="card-header bg-primary text-white fw-semibold">Public Users</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Verified</th>
                        <th>Registered</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($publicUsers as $user)
                        <tr>
                            <td>{{ $user->PublicName }}</td>
                            <td>{{ $user->PublicEmail }}</td>
                            <td>{{ $user->PublicContact }}</td>
                            <td>{{ $user->PublicStatusVerify ? 'Yes' : 'No' }}</td>
                            <td>{{ $user->created_at ? $user->created_at->format('d M Y') : 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Agency Users --}}
    <div class="card mb-4 user-card d-none" data-role="agency">
        <div class="card-header bg-primary text-white fw-semibold">Agency Users</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>First Login</th>
                        <th>Registered</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($agencyUsers as $user)
                        <tr>
                            <td>{{ $user->AgencyUserName }}</td>
                            <td>{{ $user->AgencyEmail }}</td>
                            <td>{{ $user->AgencyContact }}</td>
                            <td>{{ $user->AgencyFirstLogin ? 'Yes' : 'No' }}</td>
                            <td>{{ $user->created_at ? $user->created_at->format('d M Y') : 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- MCMC Users --}}
    <div class="card mb-4 user-card d-none" data-role="mcmc">
        <div class="card-header bg-primary text-white fw-semibold">MCMC Users</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-sm mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Registered</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mcmcUsers as $user)
                        <tr>
                            <td>{{ $user->MCMCUserName }}</td>
                            <td>{{ $user->MCMCEmail }}</td>
                            <td>{{ $user->created_at ? $user->created_at->format('d M Y') : 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Register Agency Modal --}}
    <div class="modal fade" id="registerAgencyModal" tabindex="-1" aria-labelledby="registerAgencyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('mcmc.register.agency') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Register New Agency</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="AgencyUserName" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="AgencyEmail" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="AgencyPassword" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contact</label>
                            <input type="text" name="AgencyContact" class="form-control" required>
                        </div>
                        <input type="hidden" name="MCMCID" value="{{ Auth::guard('mcmc')->user()->MCMCID }}">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Tab Filter Script --}}
<script>
    document.querySelectorAll('#userTabs .nav-link').forEach(btn => {
        btn.addEventListener('click', function () {
            // Deactivate all tabs
            document.querySelectorAll('#userTabs .nav-link').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            // Show relevant table
            const role = this.dataset.role;
            document.querySelectorAll('.user-card').forEach(card => {
                card.classList.toggle('d-none', card.dataset.role !== role);
            });
        });
    });
</script>
@endsection
