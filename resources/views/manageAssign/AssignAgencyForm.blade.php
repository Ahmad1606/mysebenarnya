@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-lg mb-4">
                <div class="card-header">
                    <h3 class="mb-0"><i class="fas fa-user-check me-2"></i>Assign Inquiry to Agency</h3>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="inquiry-details mb-4">
                        <h5 class="card-title"><i class="fas fa-newspaper me-2"></i>Inquiry #{{ $inquiry->id }}</h5>
                        <div class="card bg-light mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="badge bg-{{ $inquiry->status == 'pending' ? 'warning' : ($inquiry->status == 'verified' ? 'success' : ($inquiry->status == 'assigned' ? 'info' : 'danger')) }}">
                                        {{ ucfirst($inquiry->status) }}
                                    </span>
                                    <small class="text-muted">Submitted: {{ $inquiry->created_at->format('d M Y, h:i A') }}</small>
                                </div>
                                <p class="mb-0">{{ $inquiry->news_detail }}</p>
                            </div>
                        </div>
                        
                        @if($inquiry->evidence)
                            <div class="mb-3">
                                <h6><i class="fas fa-paperclip me-2"></i>Evidence/Attachments</h6>
                                <div class="d-flex flex-wrap">
                                    @foreach(json_decode($inquiry->evidence) as $evidence)
                                        <div class="evidence-item me-2 mb-2">
                                            <a href="{{ asset('storage/' . $evidence) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-file me-1"></i> View File
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        @if($inquiry->links)
                            <div class="mb-3">
                                <h6><i class="fas fa-link me-2"></i>Related Links</h6>
                                <ul class="list-group">
                                    @foreach(json_decode($inquiry->links) as $link)
                                        <li class="list-group-item">
                                            <a href="{{ $link }}" target="_blank">{{ $link }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <form method="POST" action="{{ url('/assign/' . $inquiry->id) }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="agency_id" class="form-label">
                                <i class="fas fa-building me-2"></i>Select Agency
                            </label>
                            <select class="form-select" id="agency_id" name="agency_id" required>
                                <option value="">-- Select an agency --</option>
                                @foreach($agencies as $agency)
                                    <option value="{{ $agency->id }}">{{ $agency->name }}</option>
                                @endforeach
                            </select>
                            <div class="form-text">Select the most appropriate agency for this inquiry</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="priority" class="form-label">
                                <i class="fas fa-flag me-2"></i>Priority Level
                            </label>
                            <select class="form-select" id="priority" name="priority">
                                <option value="normal">Normal</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="deadline" class="form-label">
                                <i class="fas fa-calendar-alt me-2"></i>Response Deadline
                            </label>
                            <input type="date" class="form-control" id="deadline" name="deadline" 
                                value="{{ now()->addDays(7)->format('Y-m-d') }}">
                        </div>
                        
                        <div class="mb-4">
                            <label for="comment" class="form-label">
                                <i class="fas fa-comment me-2"></i>Instructions/Notes for Agency
                            </label>
                            <textarea class="form-control" id="comment" name="comment" rows="4" placeholder="Provide any specific instructions or context for the agency..."></textarea>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back
                            </a>
                            <button type="submit" class="btn btn-theme-primary">
                                <i class="fas fa-paper-plane me-1"></i> Assign Inquiry
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Assignment Guidelines</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0 text-primary me-3">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                                <div>
                                    <h6>Jurisdiction</h6>
                                    <p class="text-muted small">Ensure the agency has jurisdiction over the subject matter.</p>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0 text-primary me-3">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                                <div>
                                    <h6>Workload</h6>
                                    <p class="text-muted small">Consider the current workload of the agency before assigning.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0 text-primary me-3">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                                <div>
                                    <h6>Urgency</h6>
                                    <p class="text-muted small">Set appropriate priority and deadline based on public impact.</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="flex-shrink-0 text-primary me-3">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                                <div>
                                    <h6>Clear Instructions</h6>
                                    <p class="text-muted small">Provide clear context and instructions to facilitate verification.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection