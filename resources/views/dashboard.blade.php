@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            @if($userType === 'public')
                <h1 class="h3 mb-0 text-gray-800">Public User Dashboard</h1>
                <p class="text-muted">Welcome to your news verification dashboard</p>
            @elseif($userType === 'mcmc')
                <h1 class="h3 mb-0 text-gray-800">MCMC Staff Dashboard</h1>
                <p class="text-muted">Manage news verification system and monitor activities</p>
            @elseif($userType === 'agency')
                <h1 class="h3 mb-0 text-gray-800">Agency Staff Dashboard</h1>
                <p class="text-muted">Manage and respond to assigned news verification inquiries</p>
            @endif
        </div>
    </div>

    @if($userType === 'public')
        <!-- Public User Dashboard Content -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="card-icon me-3">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <div>
                            <h5 class="card-title">Submit Inquiry</h5>
                            <p class="card-text">Submit a new news verification inquiry</p>
                            <a href="{{ url('/inquiries/submit') }}" class="btn btn-theme-primary">
                                <i class="fas fa-plus me-1"></i> New Inquiry
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="card-icon me-3">
                            <i class="fas fa-history"></i>
                        </div>
                        <div>
                            <h5 class="card-title">My Inquiries</h5>
                            <p class="card-text">View and track your submitted inquiries</p>
                            <a href="{{ url('/inquiries/mine') }}" class="btn btn-theme-primary">
                                <i class="fas fa-list me-1"></i> View Inquiries
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="card-icon me-3">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div>
                            <h5 class="card-title">Public Inquiries</h5>
                            <p class="card-text">Browse verified news from the public database</p>
                            <a href="{{ url('/inquiries/public') }}" class="btn btn-theme-primary">
                                <i class="fas fa-search me-1"></i> Browse
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-bell me-1"></i> Recent Activity
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            @if(isset($recentInquiries) && count($recentInquiries) > 0)
                                @foreach($recentInquiries as $inquiry)
                                    <div class="timeline-item mb-3 pb-3 border-bottom">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted"><i class="fas fa-clock me-1"></i> {{ $inquiry->created_at->diffForHumans() }}</span>
                                            <span class="badge bg-{{ $inquiry->status == 'pending' ? 'warning' : ($inquiry->status == 'verified' ? 'success' : 'danger') }}">
                                                {{ ucfirst($inquiry->status) }}
                                            </span>
                                        </div>
                                        <h5 class="mt-2">Inquiry #{{ $inquiry->id }}</h5>
                                        <p>{{ Str::limit($inquiry->news_detail, 100) }}</p>
                                        <a href="{{ url('/inquiries/mine') }}" class="btn btn-sm btn-outline-theme">View Details</a>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x mb-3 text-muted"></i>
                                    <p>No recent activity found</p>
                                    <a href="{{ url('/inquiries/submit') }}" class="btn btn-theme-primary">Submit Your First Inquiry</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-info-circle me-1"></i> Quick Guide
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h5><i class="fas fa-paper-plane text-primary me-2"></i> Submit an Inquiry</h5>
                            <p>Provide news details, supporting evidence, and links for verification.</p>
                        </div>
                        <div class="mb-3">
                            <h5><i class="fas fa-search text-success me-2"></i> Track Progress</h5>
                            <p>Monitor the status of your inquiries through the verification process.</p>
                        </div>
                        <div>
                            <h5><i class="fas fa-check-circle text-info me-2"></i> Get Verification</h5>
                            <p>Receive official verification results from authorized agencies.</p>
                        </div>
                        <div class="text-center mt-4">
                            <a href="{{ url('/inquiries/submit') }}" class="btn btn-theme-primary">
                                <i class="fas fa-paper-plane me-1"></i> Submit Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif($userType === 'mcmc')
        <!-- MCMC Staff Dashboard Content -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h5 class="card-title mb-0">New Inquiries</h5>
                            <div class="card-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                        </div>
                        <h2 class="display-4 mb-0">{{ $newInquiries ?? 0 }}</h2>
                        <p class="text-muted">Awaiting review</p>
                        <a href="{{ url('/filtered-inquiries') }}" class="btn btn-sm btn-theme-primary mt-2">
                            <i class="fas fa-arrow-right me-1"></i> Review Now
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h5 class="card-title mb-0">Assigned</h5>
                            <div class="card-icon">
                                <i class="fas fa-tasks"></i>
                            </div>
                        </div>
                        <h2 class="display-4 mb-0">{{ $assignedInquiries ?? 0 }}</h2>
                        <p class="text-muted">In progress</p>
                        <a href="{{ url('/filtered-inquiries') }}" class="btn btn-sm btn-theme-primary mt-2">
                            <i class="fas fa-arrow-right me-1"></i> View All
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h5 class="card-title mb-0">Verified</h5>
                            <div class="card-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <h2 class="display-4 mb-0">{{ $verifiedInquiries ?? 0 }}</h2>
                        <p class="text-muted">This month</p>
                        <a href="{{ url('/filtered-inquiries') }}" class="btn btn-sm btn-theme-primary mt-2">
                            <i class="fas fa-arrow-right me-1"></i> View All
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h5 class="card-title mb-0">Agencies</h5>
                            <div class="card-icon">
                                <i class="fas fa-building"></i>
                            </div>
                        </div>
                        <h2 class="display-4 mb-0">{{ $totalAgencies ?? 0 }}</h2>
                        <p class="text-muted">Active agencies</p>
                        <a href="{{ url('/mcmc/users') }}" class="btn btn-sm btn-theme-primary mt-2">
                            <i class="fas fa-arrow-right me-1"></i> Manage
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-chart-bar me-1"></i> Monthly Statistics</span>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-theme active">Inquiries</button>
                            <button type="button" class="btn btn-sm btn-outline-theme">Assignments</button>
                            <button type="button" class="btn btn-sm btn-outline-theme">Users</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="statisticsChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-chart-pie me-1"></i> Inquiry Status
                    </div>
                    <div class="card-body">
                        <canvas id="statusChart" height="260"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-file-alt me-1"></i> Recent Inquiries</span>
                        <a href="{{ url('/mcmc/inquiries/all') }}" class="btn btn-sm btn-outline-theme">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Submitted By</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($recentInquiries) && count($recentInquiries) > 0)
                                        @foreach($recentInquiries as $inquiry)
                                            <tr>
                                                <td>#{{ $inquiry->id }}</td>
                                                <td>{{ $inquiry->user_name }}</td>
                                                <td>{{ $inquiry->created_at->format('d M Y') }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $inquiry->status == 'pending' ? 'warning' : ($inquiry->status == 'verified' ? 'success' : 'danger') }}">
                                                        {{ ucfirst($inquiry->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ url('/mcmc/inquiries/' . $inquiry->id) }}" class="btn btn-sm btn-theme-primary">
                                                        <i class="fas fa-eye me-1"></i> View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <i class="fas fa-inbox fa-2x mb-3 text-muted"></i>
                                                <p class="mb-0">No recent inquiries found</p>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-users me-1"></i> Recent User Activity</span>
                        <a href="{{ url('/mcmc/users') }}" class="btn btn-sm btn-outline-theme">View All Users</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Type</th>
                                        <th>Activity</th>
                                        <th>Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($recentUserActivity) && count($recentUserActivity) > 0)
                                        @foreach($recentUserActivity as $activity)
                                            <tr>
                                                <td>{{ $activity->user_name }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $activity->user_type == 'public' ? 'primary' : ($activity->user_type == 'agency' ? 'success' : 'info') }}">
                                                        {{ ucfirst($activity->user_type) }}
                                                    </span>
                                                </td>
                                                <td>{{ $activity->action }}</td>
                                                <td>{{ $activity->created_at->diffForHumans() }}</td>
                                                <td>
                                                    <a href="{{ url('/mcmc/users/activity/' . $activity->user_id) }}" class="btn btn-sm btn-theme-primary">
                                                        <i class="fas fa-eye me-1"></i> Details
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <i class="fas fa-users fa-2x mb-3 text-muted"></i>
                                                <p class="mb-0">No recent user activity found</p>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif($userType === 'agency')
        <!-- Agency Staff Dashboard Content -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h5 class="card-title mb-0">New Assignments</h5>
                            <div class="card-icon">
                                <i class="fas fa-inbox"></i>
                            </div>
                        </div>
                        <h2 class="display-4 mb-0">{{ $newAssignments ?? 0 }}</h2>
                        <p class="text-muted">Pending review</p>
                        <a href="{{ url('/agency/assignments') }}" class="btn btn-sm btn-theme-primary mt-2">
                            <i class="fas fa-arrow-right me-1"></i> View All
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h5 class="card-title mb-0">In Progress</h5>
                            <div class="card-icon">
                                <i class="fas fa-spinner"></i>
                            </div>
                        </div>
                        <h2 class="display-4 mb-0">{{ $inProgressAssignments ?? 0 }}</h2>
                        <p class="text-muted">Currently reviewing</p>
                        <a href="{{ url('/agency/assignments') }}" class="btn btn-sm btn-theme-primary mt-2">
                            <i class="fas fa-arrow-right me-1"></i> View All
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h5 class="card-title mb-0">Completed</h5>
                            <div class="card-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <h2 class="display-4 mb-0">{{ $completedAssignments ?? 0 }}</h2>
                        <p class="text-muted">This month</p>
                        <a href="{{ url('/agency/inquiries') }}" class="btn btn-sm btn-theme-primary mt-2">
                            <i class="fas fa-arrow-right me-1"></i> View History
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h5 class="card-title mb-0">Response Time</h5>
                            <div class="card-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                        <h2 class="display-4 mb-0">{{ $avgResponseTime ?? '24h' }}</h2>
                        <p class="text-muted">Average response</p>
                        <a href="{{ url('/agency/inquiries') }}" class="btn btn-sm btn-theme-primary mt-2">
                            <i class="fas fa-arrow-right me-1"></i> View Details
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-tasks me-1"></i> Recent Assignments</span>
                        <a href="{{ url('/agency/assignments') }}" class="btn btn-sm btn-outline-theme">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Inquiry</th>
                                        <th>Assigned</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($recentAssignments) && count($recentAssignments) > 0)
                                        @foreach($recentAssignments as $assignment)
                                            <tr>
                                                <td>#{{ $assignment->id }}</td>
                                                <td>{{ Str::limit($assignment->inquiry_detail, 30) }}</td>
                                                <td>{{ $assignment->assigned_at->diffForHumans() }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $assignment->status == 'pending' ? 'warning' : ($assignment->status == 'completed' ? 'success' : 'info') }}">
                                                        {{ ucfirst($assignment->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ url('/agency/assignment/review/' . $assignment->id) }}" class="btn btn-sm btn-theme-primary">
                                                        <i class="fas fa-eye me-1"></i> Review
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <i class="fas fa-inbox fa-2x mb-3 text-muted"></i>
                                                <p class="mb-0">No assignments found</p>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-bell me-1"></i> Notifications
                    </div>
                    <div class="card-body">
                        @if(isset($notifications) && count($notifications) > 0)
                            @foreach($notifications as $notification)
                                <div class="d-flex mb-3 pb-3 border-bottom">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-circle-exclamation text-warning fa-lg"></i>
                                    </div>
                                    <div class="ms-3">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-0">{{ $notification->title }}</h6>
                                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-0 text-muted">{{ $notification->message }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-bell-slash fa-2x mb-3 text-muted"></i>
                                <p>No new notifications</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-chart-line me-1"></i> Performance
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Response Rate</span>
                                <span>85%</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 85%;" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Accuracy</span>
                                <span>92%</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 92%;" aria-valuenow="92" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>Timeliness</span>
                                <span>78%</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 78%;" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@section('scripts')
@if($userType === 'mcmc')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly Statistics Chart
    var ctx = document.getElementById('statisticsChart').getContext('2d');
    var statisticsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'New Inquiries',
                data: [65, 59, 80, 81, 56, 55, 40, 45, 60, 70, 75, 90],
                backgroundColor: 'rgba(21, 101, 192, 0.6)',
                borderColor: 'rgba(21, 101, 192, 1)',
                borderWidth: 1
            }, {
                label: 'Verified News',
                data: [28, 48, 40, 19, 86, 27, 90, 35, 50, 60, 65, 80],
                backgroundColor: 'rgba(46, 125, 50, 0.6)',
                borderColor: 'rgba(46, 125, 50, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    
    // Status Pie Chart
    var ctxPie = document.getElementById('statusChart').getContext('2d');
    var statusChart = new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'In Progress', 'Verified', 'Rejected'],
            datasets: [{
                data: [12, 19, 8, 5],
                backgroundColor: [
                    'rgba(255, 152, 0, 0.7)',
                    'rgba(33, 150, 243, 0.7)',
                    'rgba(76, 175, 80, 0.7)',
                    'rgba(244, 67, 54, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 152, 0, 1)',
                    'rgba(33, 150, 243, 1)',
                    'rgba(76, 175, 80, 1)',
                    'rgba(244, 67, 54, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endif
@endsection
@endsection