@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0"><i class="fas fa-search me-2"></i>Browse Inquiries</h3>
                    
                    @if(Auth::guard('mcmc')->check())
                        <a href="{{ url('/report/inquiries') }}" class="btn btn-sm btn-outline-theme">
                            <i class="fas fa-download me-1"></i> Export Report
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    <form method="GET" class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="search" name="search" class="form-control" placeholder="Search keyword..." value="{{ request('search') }}">
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                <input type="date" name="date_from" class="form-control" placeholder="From date" value="{{ request('date_from') }}">
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                <input type="date" name="date_to" class="form-control" placeholder="To date" value="{{ request('date_to') }}">
                            </div>
                        </div>
                        
                        @if(Auth::guard('mcmc')->check())
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-filter"></i></span>
                                    <select name="status" class="form-select">
                                        <option value="">All Statuses</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="assigned" {{ request('status') == 'assigned' ? 'selected' : '' }}>Assigned</option>
                                        <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified</option>
                                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </div>
                            </div>
                        @endif
                        
                        <div class="col-12 d-flex justify-content-end">
                            <a href="{{ url()->current() }}" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-redo me-1"></i> Reset
                            </a>
                            <button type="submit" class="btn btn-theme-primary">
                                <i class="fas fa-filter me-1"></i> Apply Filters
                            </button>
                        </div>
                    </form>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">News Details</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Submitted</th>
                                    @if(Auth::guard('mcmc')->check())
                                        <th scope="col">Submitted By</th>
                                    @endif
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($inquiries) > 0)
                                    @foreach($inquiries as $inq)
                                        <tr>
                                            <td>{{ $inq->id }}</td>
                                            <td>{{ Str::limit($inq->news_detail, 60) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $inq->status == 'pending' ? 'warning' : ($inq->status == 'verified' ? 'success' : ($inq->status == 'assigned' ? 'info' : 'danger')) }}">
                                                    {{ ucfirst($inq->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $inq->created_at->format('d M Y') }}</td>
                                            @if(Auth::guard('mcmc')->check())
                                                <td>{{ $inq->user_name ?? 'Unknown' }}</td>
                                            @endif
                                            <td>
                                                @if(Auth::guard('mcmc')->check())
                                                    <div class="btn-group">
                                                        <a href="{{ url('/mcmc/inquiries/' . $inq->id) }}" class="btn btn-sm btn-theme-primary">
                                                            <i class="fas fa-eye me-1"></i> View
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-theme-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="visually-hidden">Toggle Dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a class="dropdown-item" href="{{ url('/assign/' . $inq->id) }}">
                                                                    <i class="fas fa-user-check me-1"></i> Assign
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#flagModal{{ $inq->id }}">
                                                                    <i class="fas fa-flag me-1"></i> Flag
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @elseif(Auth::guard('agency')->check())
                                                    <a href="{{ url('/agency/assignment/review/' . $inq->id) }}" class="btn btn-sm btn-theme-primary">
                                                        <i class="fas fa-eye me-1"></i> Review
                                                    </a>
                                                @else
                                                    <a href="{{ url('/inquiries/assignment/' . $inq->id) }}" class="btn btn-sm btn-theme-primary">
                                                        <i class="fas fa-eye me-1"></i> View
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        
                                        @if(Auth::guard('mcmc')->check())
                                            <!-- Flag Modal -->
                                            <div class="modal fade" id="flagModal{{ $inq->id }}" tabindex="-1" aria-labelledby="flagModalLabel{{ $inq->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="flagModalLabel{{ $inq->id }}">Flag Inquiry #{{ $inq->id }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ url('/mcmc/inquiries/' . $inq->id . '/flag') }}" method="POST">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="flag_reason" class="form-label">Reason for Flagging</label>
                                                                    <select class="form-select" id="flag_reason" name="flag_reason" required>
                                                                        <option value="">Select a reason...</option>
                                                                        <option value="inappropriate">Inappropriate Content</option>
                                                                        <option value="duplicate">Duplicate Inquiry</option>
                                                                        <option value="spam">Spam</option>
                                                                        <option value="other">Other</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="flag_notes" class="form-label">Additional Notes</label>
                                                                    <textarea class="form-control" id="flag_notes" name="flag_notes" rows="3"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger">Flag Inquiry</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="{{ Auth::guard('mcmc')->check() ? '6' : '5' }}" class="text-center py-4">
                                            <i class="fas fa-search fa-3x mb-3 text-muted"></i>
                                            <p class="mb-0">No inquiries found matching your criteria</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-4">
                        {{ $inquiries->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection