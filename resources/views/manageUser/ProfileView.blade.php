@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg mb-4">
                <div class="card-header">
                    <h3 class="mb-0"><i class="fas fa-user-circle me-2"></i>My Profile</h3>
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

                    <form method="POST" enctype="multipart/form-data" action="{{ url('/profile/' . $userType) }}">
                        @csrf
                        
                        <div class="row mb-4">
                            <div class="col-md-3 text-center">
                                <div class="profile-image-container mb-3">
                                    @if($user->profile_pic)
                                        <img src="{{ asset('storage/' . $user->profile_pic) }}" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                    @else
                                        <div class="profile-placeholder rounded-circle d-flex align-items-center justify-content-center" style="width: 150px; height: 150px; background-color: var(--theme-secondary); color: var(--theme-primary); font-size: 3rem;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="profile_pic" class="form-label">Change Picture</label>
                                    <input class="form-control form-control-sm" id="profile_pic" name="profile_pic" type="file" accept="image/*">
                                </div>
                            </div>
                            
                            <div class="col-md-9">
                                <div class="mb-3">
                                    <label for="name" class="form-label">
                                        <i class="fas fa-user me-2"></i>Full Name
                                    </label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-2"></i>Email Address
                                    </label>
                                    <input type="email" class="form-control" id="email" value="{{ $user->email }}" readonly disabled>
                                    <div class="form-text">Email address cannot be changed</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="contact" class="form-label">
                                        <i class="fas fa-phone me-2"></i>Contact Number
                                    </label>
                                    <input type="text" class="form-control" id="contact" name="contact" value="{{ $user->contact }}">
                                </div>
                                
                                @if($userType === 'agency')
                                    <div class="mb-3">
                                        <label for="agency_info" class="form-label">
                                            <i class="fas fa-building me-2"></i>Agency Information
                                        </label>
                                        <textarea class="form-control" id="agency_info" name="agency_info" rows="4">{{ $user->agency_info ?? '' }}</textarea>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-theme" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                <i class="fas fa-key me-1"></i> Change Password
                            </button>
                            <button type="submit" class="btn btn-theme-primary">
                                <i class="fas fa-save me-1"></i> Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            @if($userType === 'public')
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-history me-2"></i>Account Activity</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Activity</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($activities) && count($activities) > 0)
                                        @foreach($activities as $activity)
                                            <tr>
                                                <td>{{ $activity->description }}</td>
                                                <td>{{ $activity->created_at }}</td>
                                                <td>
                                                    <span class="badge bg-success">Completed</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3" class="text-center py-4">
                                                <i class="fas fa-info-circle fa-2x mb-3 text-muted"></i>
                                                <p class="mb-0">No recent activity found</p>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @elseif($userType === 'agency')
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Performance Metrics</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Response Rate</span>
                                        <span>85%</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 85%;" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Accuracy</span>
                                        <span>92%</span>
                                    </div>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 92%;" aria-valuenow="92" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ url('/change-password') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                        <div class="form-text">Password must be at least 8 characters with letters, numbers, and symbols</div>
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-theme-primary">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection