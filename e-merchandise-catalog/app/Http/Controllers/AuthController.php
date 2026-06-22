<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string'
        ]);

        $otp = rand(100000, 999999);
        
        $user = User::firstOrCreate(
            ['phone' => $request->phone],
            [
                'name' => 'User',
                'email' => 'temp_' . time() . '@example.com',
                'role' => 'customer',
                'otp' => $otp,
                'otp_expires_at' => now()->addMinutes(10)
            ]
        );

        if (!$user->wasRecentlyCreated) {
            $user->update([
                'otp' => $otp,
                'otp_expires_at' => now()->addMinutes(10)
            ]);
        }

        return response()->json(['success' => true, 'otp_sent' => true, 'user_id' => $user->id]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'otp' => 'required|digits:6'
        ]);

        $user = User::find($request->user_id);

        if (!$user || $user->otp != $request->otp || now() > $user->otp_expires_at) {
            return response()->json(['success' => false, 'message' => 'OTP tidak valid atau sudah kadaluarsa']);
        }

        Auth::login($user);
        $user->update(['otp' => null, 'otp_expires_at' => null]);

        return response()->json(['success' => true, 'redirect' => $user->is_verified ? route('home') : route('profile.complete')]);
    }

    public function showCompleteProfile()
    {
        if (auth()->user()->is_verified) {
            return redirect()->route('home');
        }
        return view('auth.complete-profile');
    }

    public function completeProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'type' => 'required|in:internal,external',
            'address' => 'nullable|required_if:type,external',
            'class' => 'nullable|required_if:type,internal',
            'phone' => 'required|string'
        ]);

        auth()->user()->update([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'address' => $request->address,
            'class' => $request->class,
            'phone' => $request->phone,
            'is_verified' => true
        ]);

        return redirect()->route('home')->with('success', 'Profil berhasil dilengkapi!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            if (auth()->user()->isAdmin() || auth()->user()->isPanitia()) {
                return redirect()->route('admin.dashboard');
            }
            Auth::logout();
        }

        return back()->withErrors(['email' => 'Kredensial tidak valid']);
    }
}
