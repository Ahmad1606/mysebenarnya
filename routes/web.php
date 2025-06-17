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

// Password reset (initiate only)
Route::post('/password/forgot', [UserManagementController::class, 'sendPasswordResetLink'])->name('password.email');

// Profile (protected by role middleware)
Route::middleware('isPublicUser')->group(function () {
    Route::get('/manageUser/dashboard', fn() => view('manageUser.dashboard'));
    Route::get('/profile/public', [UserManagementController::class, 'showProfile']);
    Route::post('/profile/public', [UserManagementController::class, 'updateProfile']);
});

Route::middleware('isAgency')->group(function () {
    Route::get('/agency/dashboard', fn() => view('agency.dashboard'));
    Route::get('/profile/agency', [UserManagementController::class, 'showProfile']);
    Route::post('/profile/agency', [UserManagementController::class, 'updateProfile']);
    Route::post('/agency/first-login-reset', [UserManagementController::class, 'enforceFirstLoginReset']);
});

Route::middleware('isMcmc')->group(function () {
    Route::get('/mcmc/dashboard', fn() => view('mcmc.dashboard'));
    Route::get('/profile/mcmc', [UserManagementController::class, 'showProfile']);
    Route::post('/profile/mcmc', [UserManagementController::class, 'updateProfile']);
    Route::post('/register-agency', [UserManagementController::class, 'registerAgency']);
    Route::get('/report/users', [UserManagementController::class, 'generateReport']);
});
