<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            'pin' => 'required|digits:6|confirmed',
            'first_name' => 'required',
            'last_name' => 'required'
        ]);

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'pin' => Hash::make($request->pin),
            'balance' => 0
        ]);

        Auth::login($user);
        return redirect()->route('dashboard.overview');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard.overview');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/auth/login');
    }
}