<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Mail\PublicUserVerificationMail;
use App\Models\PublicUser;
use App\Models\AgencyUser;
use App\Models\McmcUser;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\{PublicUsersExport, AgencyUsersExport, McmcUsersExport};

class UserManagementController extends Controller
{
    // ------------------------
    // Show Login Form
    // ------------------------
    public function showLogin()
    {
        return view('manageUser.login');
    }

    // ------------------------
    // Login (role-aware)
    // ------------------------
    public function login(Request $request)
    {
        $request->validate([
            'role' => 'required|in:public,agency,mcmc',
            'identifier' => 'required',
            'password' => 'required',
        ]);

        $map = [
            'public' => [PublicUser::class, 'PublicEmail', 'PublicPassword', 'public', '/public/profile'],
            'agency' => [AgencyUser::class, 'AgencyUserName', 'AgencyPassword', 'agency', '/agency/dashboard'],
            'mcmc'   => [McmcUser::class, 'MCMCUserName', 'MCMCPassword', 'mcmc', '/mcmc/dashboard'],
        ];

        [$model, $loginField, $passwordField, $guard, $redirect] = $map[$request->role];
        $user = $model::where($loginField, $request->identifier)->first();

        if (!$user || !Hash::check($request->password, $user->{$passwordField})) {
            return back()->with('error', 'Invalid credentials');
        }

        // Email verification check for public users
        if ($request->role === 'public' && !$user->PublicStatusVerify) {
            return back()->with('error', 'Please verify your email before logging in.');
        }

        Auth::guard($guard)->login($user);
        session(['role' => $request->role]);

        // First-time password reset check for agency
        if ($request->role === 'agency' && $user->AgencyFirstLogin) {
        Auth::guard('agency')->login($user); // Still log them in

        session(['role' => 'agency']);

        return redirect()
            ->route('login')
            ->with([
                'first_time_login' => true,
                'agency_id' => $user->AgencyID,
            ]);
        }

        return redirect($redirect);
    }

    // ------------------------
    // Logout
    // ------------------------
    public function logout(Request $request)
    {
        $role = $request->input('role');

        if (in_array($role, ['public', 'agency', 'mcmc'])) {
            Auth::guard($role)->logout();
        }

        session()->forget('role');
        return redirect('/login')->with('message', 'Logged out successfully.');
    }

    // ------------------------
    // Public User Registration
    // ------------------------
    public function showRegister()
    {
        return view('manageUser.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'PublicName' => 'required|string|max:255',
            'PublicEmail' => 'required|email|unique:public_users,PublicEmail',
            'PublicPassword' => 'required|string|min:8|confirmed',
            'PublicContact' => 'required|string',
        ]);

        $token = bin2hex(random_bytes(16));
        $user = PublicUser::create([
            'PublicName' => $request->PublicName,
            'PublicEmail' => $request->PublicEmail,
            'PublicPassword' => Hash::make($request->PublicPassword),
            'PublicContact' => $request->PublicContact,
            'PublicStatusVerify' => false,
            'RoleID' => 3,
        ]);

        $user->remember_token = $token;
        $user->save();

        Auth::guard('public')->login($user);
        Mail::to($user->PublicEmail)->send(new PublicUserVerificationMail($user));

        return redirect()->route('login')->with('message', 'Registration successful. Please check your email to verify.');
    }

    // ------------------------
    // View/Edit Profile (All roles)
    // ------------------------
    public function showProfile()
    {
        $guards = ['public', 'agency', 'mcmc'];
        foreach ($guards as $role) {
            if (Auth::guard($role)->check()) {
                $user = Auth::guard($role)->user();
                return view('manageUser.profile', compact('user', 'role'));
            }
        }

        return redirect('/login')->with('error', 'Unauthorized access.');
    }

    public function updateProfile(Request $request)
    {
        $map = [
            'public' => [PublicUser::class, 'PublicID'],
            'agency' => [AgencyUser::class, 'AgencyID'],
            'mcmc'   => [McmcUser::class,   'MCMCID'],
        ];

        $role = session('role');
        if (!isset($map[$role])) {
            return back()->with('error', 'Invalid role.');
        }

        $user = Auth::guard($role)->user();
        $user->fill($request->only($user->getFillable()));
        $user->save();

        return back()->with('message', 'Profile updated successfully.');
    }

    // ------------------------
    // Agency Registration (by MCMC)
    // ------------------------
    public function registerAgency(Request $request)
    {
        $request->validate([
            'AgencyUserName' => 'required|string|unique:agency_users',
            'AgencyEmail' => 'required|email|unique:agency_users',
            'AgencyPassword' => 'required|string|min:8',
            'AgencyContact' => 'required|string',
            'MCMCID' => 'required|exists:mcmc_users,MCMCID',
        ]);

        $agency = AgencyUser::create([
            'AgencyUserName' => $request->AgencyUserName,
            'AgencyEmail' => $request->AgencyEmail,
            'AgencyPassword' => Hash::make($request->AgencyPassword),
            'AgencyContact' => $request->AgencyContact,
            'AgencyFirstLogin' => true,
            'MCMCID' => $request->MCMCID,
            'RoleID' => 2,
        ]);

        return response()->json(['message' => 'Agency registered successfully', 'agency' => $agency]);
    }

    public function enforceFirstLoginReset(Request $request)
    {
        $user = Auth::guard('agency')->user();

        if ($user->AgencyFirstLogin) {
            $request->validate([
                'new_password' => 'required|min:8|confirmed',
            ]);

            $user->AgencyPassword = Hash::make($request->new_password);
            $user->AgencyFirstLogin = false;
            $user->save();

            return redirect()->route('agency.dashboard')->with('message', 'Password updated. Welcome!');
        }

        return redirect()->route('agency.dashboard');
    }

    // ------------------------
    // Verify Public User Email
    // ------------------------
    public function verifyEmail($token)
    {
        $user = PublicUser::where('remember_token', $token)->first();

        if (!$user) {
            return redirect('/login')->with('error', 'Invalid verification link.');
        }

        $user->PublicStatusVerify = true;
        $user->save();

        return redirect('/login')->with('message', 'Email verified. Please login.');
    }

    // ------------------------
    // Forgot Password (send reset link) [Stub]
    // ------------------------
    public function sendPasswordResetLink(Request $request)
    {
            $request->validate([
                'role' => 'required|in:public,agency,mcmc',
                'email' => 'required|email',
            ]);

            $map = [
                'public' => [PublicUser::class, 'PublicEmail'],
                'agency' => [AgencyUser::class, 'AgencyEmail'],
                'mcmc'   => [McmcUser::class, 'MCMCEmail'],
            ];

            [$model, $emailField] = $map[$request->role];
            $user = $model::where($emailField, $request->email)->first();

            if (!$user) {
                return back()->with('error', 'Email not found.');
            }

            $token = Str::random(64);
            $link = url("/reset-password/{$token}?email=" . urlencode($request->email));

            // Simulate email in log
            Log::info("
        📬 Simulated Password Reset Email

        To: {$request->email}
        Subject: Reset Your MySebenarnya Password

        Hello,

        We received a request to reset your password for your {$request->role} account.

        Please click the link below to reset your password:

        $link

        If you did not request a password reset, no further action is required.

        Regards,  
        MySebenarnya Team
            ");

            return back()->with('message', 'Password reset link has been sent to your email.');
    }

    //reset password form submission from modal
    public function handleResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $map = [
            'public' => [PublicUser::class, 'PublicEmail', 'PublicPassword'],
            'agency' => [AgencyUser::class, 'AgencyEmail', 'AgencyPassword'],
            'mcmc'   => [McmcUser::class, 'MCMCEmail', 'MCMCPassword'],
        ];

        $user = null;
        $matchedRole = null;
        $passwordField = null;

        foreach ($map as $role => [$model, $emailField, $pwField]) {
            $user = $model::where($emailField, $request->email)->first();
            if ($user) {
                $matchedRole = $role;
                $passwordField = $pwField;
                break;
            }
        }

        if (!$user) {
            return back()->with('error', 'User not found.');
        }

        $user->{$passwordField} = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('login')->with('message', 'Password successfully reset. You may now login.');
    }
    //mcmc view all users
    public function showAllUsers()
    {
        $publicUsers = PublicUser::all();
        $agencyUsers = AgencyUser::all();
        $mcmcUsers = McmcUser::all();

        return view('manageUser.manage_user', compact('publicUsers', 'agencyUsers', 'mcmcUsers'));
    }
    // ------------------------
    // Generate User Report (MCMC)
    // ------------------------
    public function generateReport(Request $request)
    {
        $type = $request->input('type', 'all');

        $data = match ($type) {
            'public' => PublicUser::all(),
            'agency' => AgencyUser::all(),
            'mcmc'   => McmcUser::all(),
            default  => collect([
                'public' => PublicUser::all(),
                'agency' => AgencyUser::all(),
                'mcmc'   => McmcUser::all(),
            ]),
        };

        return view('manageUser.user_report', compact('data', 'type'));
    }

    // Export User report
    public function exportReport(Request $request, $type, $format)
    {
        switch ($type) {
            case 'public':
                $data = PublicUser::all();
                $export = new PublicUsersExport;
                break;

            case 'agency':
                $data = AgencyUser::all();
                $export = new AgencyUsersExport;
                break;

            case 'mcmc':
                $data = McmcUser::all();
                $export = new McmcUsersExport;
                break;

            default:
                return back()->with('error', 'Invalid user type.');
        }

        $filename = $type . '_report_' . now()->format('Ymd_His');

        if ($format === 'excel') {
            return Excel::download($export, $filename . '.xlsx');
        }

        if ($format === 'pdf') {
            $pdf = PDF::loadView('manageUser.user_pdf', ['data' => $data, 'type' => $type]);
            return $pdf->download($filename . '.pdf');
        }

        return back()->with('error', 'Invalid export format.');
    } 
}
