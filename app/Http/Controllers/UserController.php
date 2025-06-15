<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\PublicUser;
use App\Models\McmcUser;
use App\Models\AgencyUser;

class UserController extends Controller
{
    // Show login form
    public function showLogin()
    {
        return view('auth.login');
    }

    // Handle login for all roles
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:public,agency,mcmc',
        ]);

        $role = $request->input('role');
        $email = $request->input('email');
        $password = $request->input('password');

        if ($role === 'public') {
            $user = PublicUser::where('PubEmail', $email)->first();
            if ($user && Hash::check($password, $user->PubPassword)) {
                Auth::login($user);
                return redirect()->route('public.dashboard');
            }
        }

        if ($role === 'agency') {
            $user = AgencyUser::where('AgenEmail', $email)->first();
            if ($user && Hash::check($password, $user->AgenPassword)) {
                if ($user->AgenFirstLogin) {
                    Auth::login($user);
                    return redirect()->route('agency.change-password');
                }
                Auth::login($user);
                return redirect()->route('agency.dashboard');
            }
        }

        if ($role === 'mcmc') {
            $user = McmcUser::where('MCEmail', $email)->first();
            if ($user && Hash::check($password, $user->MCPassword)) {
                Auth::login($user);
                return redirect()->route('mcmc.dashboard');
            }
        }

        return back()->withErrors(['login' => 'Invalid credentials or role.']);
    }

    // Show registration form
    public function showRegister()
    {
        return view('auth.register');
    }

    // Handle registration (public & agency)
    public function register(Request $request)
    {
        $request->validate([
            'role' => 'required|in:public,agency',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $role = $request->role;

        if ($role === 'public') {
            $request->validate([
                'email' => 'unique:public_users,PubEmail',
            ]);

            PublicUser::create([
                'PubName' => $request->name,
                'PubEmail' => $request->email,
                'PubPassword' => Hash::make($request->password),
                'PubContact' => $request->phone,
                'PubStatusVerify' => false,
            ]);

            return redirect()->route('login')->with('success', 'Registration successful.');
        }

        if ($role === 'agency') {
            $request->validate([
                'email' => 'unique:agency_users,AgenEmail',
                'position' => 'required|string|max:100',
                'mcmcid' => 'required|exists:mcmc_users,MCUser_id',
            ]);

            AgencyUser::create([
                'AgenName' => $request->name,
                'AgenUsername' => strtolower(str_replace(' ', '_', $request->name)) . rand(100, 999),
                'AgenEmail' => $request->email,
                'AgenPassword' => Hash::make($request->password),
                'AgenContact' => $request->phone,
                'AgenPosition' => $request->position ?? '',
                'AgenFirstLogin' => true,
                'MCMCID' => $request->mcmcid,
            ]);

            return redirect()->route('login')->with('success', 'Agency registered. Credentials will be emailed.');
        }

        return back()->withErrors(['register' => 'Invalid registration role.']);
    }

    // Show first-time password reset for agency
    public function showForcePasswordChange()
    {
        return view('agency.force_password_change');
    }

    public function forcePasswordChange(Request $request)
    {
        $user = Auth::user();

        if (!($user instanceof AgencyUser)) {
            return redirect()->route('login');
        }

        $request->validate([
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user->AgenPassword = Hash::make($request->new_password);
        $user->AgenFirstLogin = false;
        $user->save();

        return redirect()->route('agency.dashboard')->with('success', 'Password changed.');
    }

    // Show profile
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    // Update profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        if ($user instanceof PublicUser) {
            $user->PubName = $request->name;
            $user->PubContact = $request->phone;
        } elseif ($user instanceof AgencyUser) {
            $user->AgenName = $request->name;
            $user->AgenContact = $request->phone;
        } elseif ($user instanceof McmcUser) {
            $user->MCName = $request->name;
            $user->MCContact = $request->phone;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated.');
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    // Admin user reporting (MCMC only)
    public function userReport()
    {
        $public = PublicUser::all();
        $agency = AgencyUser::with('mcmcUser')->get();

        return view('admin.report', [
            'publicUsers' => $public,
            'agencyUsers' => $agency,
        ]);
    }
}
