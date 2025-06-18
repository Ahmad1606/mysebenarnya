<?php

use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\InquiryManagementController;
use App\Http\Controllers\AssignmentManagementController;
use Illuminate\Support\Facades\Route;

// Default homepage route (fixes 404 on /)
Route::get('/', function () {
    return view('welcome'); // Change to your desired homepage view or redirect('/login')
});

// Login & Register
Route::get('/login', [UserManagementController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserManagementController::class, 'login']);
Route::post('/logout', [UserManagementController::class, 'logout'])->name('logout');

Route::get('/register', [UserManagementController::class, 'showPublicRegisterForm'])->name('register');
Route::post('/register', [UserManagementController::class, 'registerPublicUser']);

// Email verification
Route::get('/verify/{token}', [UserManagementController::class, 'verifyEmail'])->name('email.verify');

// Password reset
Route::get('/password/forgot/{guard?}', [UserManagementController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/password/email', [UserManagementController::class, 'sendResetLink'])->name('password.email');
Route::get('/password/reset/{token}/{guard?}', [UserManagementController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/password/reset', [UserManagementController::class, 'resetPassword'])->name('password.update');

// Common authenticated routes - we need to check all guards
Route::middleware(['auth:public,agency,mcmc'])->group(function () {
    // Dashboard - role-based content
    Route::get('/dashboard', [UserManagementController::class, 'dashboard'])->name('dashboard');
    
    // Profile management - role-based
    Route::get('/profile/{userType}', [UserManagementController::class, 'showProfile']);
    Route::post('/profile/{userType}', [UserManagementController::class, 'updateProfile']);
});

// Public User
Route::middleware(['auth:public', 'IsPublicUser'])->group(function () {
    Route::get('/inquiries/submit', [InquiryManagementController::class, 'showInquiryForm']);
    Route::post('/inquiries/submit', [InquiryManagementController::class, 'submitInquiry']);
    Route::get('/inquiries/mine', [InquiryManagementController::class, 'myInquiries'])->name('inquiries.mine');
    Route::get('/inquiries/assignment/{id}', [InquiryManagementController::class, 'showInquiryAssignment']);
});

// Agency Staff
Route::middleware(['auth:agency', 'IsAgency'])->group(function () {
    Route::get('/agency/first-login', fn() => view('manageUser.FirstLoginView'));
    Route::post('/agency/first-login', [UserManagementController::class, 'changePassword']);
    Route::get('/agency/inquiries', [InquiryManagementController::class, 'agencyInquiries']);
    Route::get('/agency/inquiries/history/{id}', [InquiryManagementController::class, 'inquiryHistory']);
    Route::get('/agency/assignments', [AssignmentManagementController::class, 'receiveAssignments']);
    Route::get('/agency/assignment/review/{id}', [AssignmentManagementController::class, 'showJurisdiction']);
    Route::post('/agency/assignment/update/{id}', [AssignmentManagementController::class, 'updateAssignment']);
});

// MCMC Staff
Route::middleware(['auth:mcmc', 'IsMcmc'])->group(function () {
    Route::post('/register-agency', [UserManagementController::class, 'createAgency']);
    Route::get('/mcmc/users', [UserManagementController::class, 'showAllUsers']);
    Route::get('/mcmc/users/activity/{id}', [UserManagementController::class, 'userActivity']);
    Route::get('/report/users', [UserManagementController::class, 'showUserReport'])->name('report.users');
    Route::get('/mcmc/inquiries/new', [InquiryManagementController::class, 'listNewInquiries']);
    Route::get('/mcmc/inquiries/{id}', [InquiryManagementController::class, 'showInquiry']);
    Route::post('/mcmc/inquiries/{id}/flag', [InquiryManagementController::class, 'flagInquiry']);
    Route::get('/mcmc/inquiries/all', [InquiryManagementController::class, 'showFiltered']);
    Route::get('/report/inquiries', [InquiryManagementController::class, 'showReport']);
    Route::get('/assign/{id}', [AssignmentManagementController::class, 'create']);
    Route::post('/assign/{id}', [AssignmentManagementController::class, 'assignToAgency']);
    Route::get('/report/assignments', [AssignmentManagementController::class, 'showReport']);
});

// Public Inquiries (everyone)
Route::get('/inquiries/public', [InquiryManagementController::class, 'listPublicInquiries']);