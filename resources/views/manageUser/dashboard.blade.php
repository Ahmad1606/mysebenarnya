@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', ucfirst($role) . ' Dashboard')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info d-flex align-items-center gap-2">
                <i class="fas fa-info-circle"></i>
                <div>Welcome to the <strong>{{ ucfirst($role) }}</strong> dashboard!</div>
            </div>
        </div>
    </div>

    {{-- Optional Role-specific cards --}}
    <div class="row">
        @if($role === 'public')
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Quick Actions</h6>
                        <a href="#" class="btn btn-primary btn-sm w-100 mb-2">
                            <i class="fas fa-pen-to-square me-1"></i> Submit Inquiry
                        </a>
                        <a href="#" class="btn btn-outline-secondary btn-sm w-100">
                            <i class="fas fa-spinner me-1"></i> View Inquiry Progress
                        </a>
                    </div>
                </div>
            </div>
        @elseif($role === 'agency')
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Agency Overview</h6>
                        <p class="mb-2">You can manage and respond to public inquiries here.</p>
                        <a href="#" class="btn btn-primary btn-sm w-100">
                            <i class="fas fa-folder-open me-1"></i> Go to Manage Inquiries
                        </a>
                    </div>
                </div>
            </div>
        @elseif($role === 'mcmc')
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Admin Tools</h6>
                        <a href="#" class="btn btn-outline-dark btn-sm w-100 mb-2">
                            <i class="fas fa-users-gear me-1"></i> Manage Users
                        </a>
                        <a href="#" class="btn btn-outline-primary btn-sm w-100">
                            <i class="fas fa-folder-open me-1"></i> Manage Inquiries
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card border-primary shadow-sm">
                            <div class="card-body">
                                <h6 class="text-muted">Public Users</h6>
                                <h3>{{ $publicCount }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card border-success shadow-sm">
                            <div class="card-body">
                                <h6 class="text-muted">Agency Users</h6>
                                <h3>{{ $agencyCount }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card border-dark shadow-sm">
                            <div class="card-body">
                                <h6 class="text-muted">MCMC Users</h6>
                                <h3>{{ $mcmcCount }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3 mb-4">
                    <h5 class="fw-semibold mb-0">User Summary Report</h5>
                    <div class="btn-group">
                        {{-- Public --}}
                        <a href="{{ route('mcmc.export', ['type' => 'public', 'format' => 'pdf']) }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-file-pdf me-1"></i> Public PDF
                        </a>
                        <a href="{{ route('mcmc.export', ['type' => 'public', 'format' => 'excel']) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel me-1"></i> Public Excel
                        </a>

                        {{-- Agency --}}
                        <a href="{{ route('mcmc.export', ['type' => 'agency', 'format' => 'pdf']) }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-file-pdf me-1"></i> Agency PDF
                        </a>
                        <a href="{{ route('mcmc.export', ['type' => 'agency', 'format' => 'excel']) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel me-1"></i> Agency Excel
                        </a>

                        {{-- MCMC --}}
                        <a href="{{ route('mcmc.export', ['type' => 'mcmc', 'format' => 'pdf']) }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-file-pdf me-1"></i> MCMC PDF
                        </a>
                        <a href="{{ route('mcmc.export', ['type' => 'mcmc', 'format' => 'excel']) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel me-1"></i> MCMC Excel
                        </a>

                        {{-- All (Optional) --}}
                        <a href="{{ route('mcmc.report', ['type' => 'all']) }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-list me-1"></i> View Full Report
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
