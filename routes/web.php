<?php

use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});


// Login & Register
Route::get('/login', [UserManagementController::class, 'showLogin'])->name('login');
Route::post('/login', [UserManagementController::class, 'login']);
Route::post('/logout', [UserManagementController::class, 'logout'])->name('logout');

Route::get('/register', [UserManagementController::class, 'showRegister'])->name('register');
Route::post('/register', [UserManagementController::class, 'register']);

// Email verification
Route::get('/verify/{token}', [UserManagementController::class, 'verifyEmail'])->name('email.verify');

// Forgot password form submission from modal
Route::post('/password/forgot', [UserManagementController::class, 'sendPasswordResetLink'])->name('password.email');

// Show password reset form from link (logs simulate this)
Route::get('/reset-password/{token}', function ($token, \Illuminate\Http\Request $request) {
    $email = $request->query('email');
    return view('manageUser.reset_password', compact('token', 'email'));
})->name('password.reset');

// Handle form submission to reset password
Route::post('/reset-password', [UserManagementController::class, 'handleResetPassword'])->name('password.reset.submit');


// ---------------------------------------------------
// Public User Routes (Guard: auth:public)
// ---------------------------------------------------
Route::middleware(['auth:public'])->group(function () {
    Route::get('/public/profile', [UserManagementController::class, 'showProfile'])->name('public.profile');
    Route::post('/public/profile', [UserManagementController::class, 'updateProfile'])->name('public.profile.update');
});


// ---------------------------------------------------
// Agency User Routes (Guard: auth:agency)
// ---------------------------------------------------
Route::middleware(['auth:agency'])->group(function () {
    // Dashboard
    Route::get('/agency/dashboard', function () {
        return view('manageUser.dashboard', ['role' => 'agency']);
    })->name('agency.dashboard');
    // Profile
    Route::get('/agency/profile', [UserManagementController::class, 'showProfile'])->name('agency.profile');
    Route::post('/agency/profile', [UserManagementController::class, 'updateProfile'])->name('agency.profile.update');

    // First-time password reset
    Route::get('/agency/password-reset', [UserManagementController::class, 'showFirstLoginReset'])->name('agency.password.reset');
    Route::post('/agency/password-reset', [UserManagementController::class, 'enforceFirstLoginReset'])->name('agency.password.reset.submit');
});


// ---------------------------------------------------
// MCMC User Routes (Guard: auth:mcmc)
// ---------------------------------------------------
Route::middleware(['auth:mcmc'])->group(function () {
    // Dashboard
    Route::get('/mcmc/dashboard', function () {
    return view('manageUser.dashboard', [
        'role' => 'mcmc',
        'publicCount' => \App\Models\PublicUser::count(),
        'agencyCount' => \App\Models\AgencyUser::count(),
        'mcmcCount' => \App\Models\McmcUser::count(),
        ]);
    })->name('mcmc.dashboard');

    // Profile
    Route::get('/mcmc/profile', [UserManagementController::class, 'showProfile'])->name('mcmc.profile');
    Route::post('/mcmc/profile', [UserManagementController::class, 'updateProfile'])->name('mcmc.profile.update');

    //Manage Users
    Route::get('/mcmc/manage-user', [UserManagementController::class, 'showAllUsers'])->name('mcmc.manageUser');
    Route::post('/mcmc/register-agency', [UserManagementController::class, 'registerAgency'])->name('mcmc.register.agency');

    // User report
    Route::get('/manageUser/report', [UserManagementController::class, 'generateReport'])->name('mcmc.report');
    Route::get('/manageUser/export/{type}/{format}', [UserManagementController::class, 'exportReport'])->name('mcmc.export');

});