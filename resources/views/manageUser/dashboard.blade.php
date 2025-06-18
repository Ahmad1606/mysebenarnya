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
        @endif
    </div>
@endsection
