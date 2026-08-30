<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Show Password-based Login Form (For Admin)
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            if (in_array(Auth::user()->role, ['super_admin', 'sub_admin'])) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    /**
     * Admin Email/Password Login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if (in_array($user->role, ['super_admin', 'sub_admin'])) {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Welcome back, ' . $user->name . '!');
            }

            return redirect()->intended(route('home'))
                ->with('success', 'Logged in successfully.');
        }

        return back()->withErrors([
            'email' => 'Invalid email credentials or password.',
        ])->withInput($request->only('email', 'remember'));
    }

    /**
     * 1. Send OTP (Fake OTP for development: 1234)
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^[6-9]\d{9}$/',
            'name'  => 'nullable|string|max:100',
        ], [
            'phone.regex' => 'Please enter a valid 10-digit Indian mobile number.'
        ]);

        $phone = $request->phone;
        $name  = $request->name ?? 'Student';
        $otp   = '1234'; // Fake OTP for testing

        // Store OTP and Temp Info in Session
        session([
            'auth_phone' => $phone,
            'auth_name'  => $name,
            'auth_otp'   => $otp,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'OTP sent successfully! Use code 1234 to verify.',
            'otp'     => $otp
        ]);
    }

    /**
     * 2. Verify OTP & Auto Sign In / Register
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp'   => 'required|string|size:4',
            'phone' => 'required|string',
        ]);

        $savedOtp   = session('auth_otp', '1234');
        $savedPhone = session('auth_phone', $request->phone);
        $savedName  = session('auth_name', $request->name ?? 'Student');

        // Verify OTP (Accepts session OTP or default fallback 1234)
        if ($request->otp !== $savedOtp && $request->otp !== '1234') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid OTP. Please enter 1234.'
            ], 422);
        }

        // Find or create student user
        $user = User::where('phone', $savedPhone)->first();

        if (!$user) {
            $user = User::create([
                'name'     => $savedName ?: 'Student ' . substr($savedPhone, -4),
                'phone'    => $savedPhone,
                'email'    => $savedPhone . '@growpec.local',
                'role'     => 'student',
                'password' => Hash::make('student_' . $savedPhone),
            ]);
        } else if (!empty($savedName) && $user->name === 'Student') {
            $user->update(['name' => $savedName]);
        }

        // Log user in
        Auth::login($user, true);

        // Clear OTP session
        session()->forget(['auth_otp', 'auth_phone', 'auth_name']);

        return response()->json([
            'status'  => 'success',
            'message' => 'Login successful! Welcome ' . $user->name,
            'user'    => [
                'id'    => $user->id,
                'name'  => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'role'  => $user->role,
            ]
        ]);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Logged out successfully.');
    }
}
