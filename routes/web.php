<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

// 👋 Welcome page (Landing)
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('profile'); // or role-based dashboard
    }
    return view('welcome');
})->name('home');

// 🔐 Login Routes
Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'login']);

// 📝 Register Routes
Route::get('/register', [UserController::class, 'showRegister'])->name('register');
Route::post('/register', [UserController::class, 'register']);

// 🚪 Logout
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// 🙍‍♂️ Profile Routes (only after login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
});

// 🧭 (Optional) Role-Based Dashboards
Route::middleware('auth')->group(function () {
    Route::get('/dashboard/public', function () {
        return view('dashboards.public');
    })->name('public.dashboard');

    Route::get('/dashboard/agency', function () {
        return view('dashboards.agency');
    })->name('agency.dashboard');

    Route::get('/dashboard/mcmc', function () {
        return view('dashboards.mcmc');
    })->name('mcmc.dashboard');
});
