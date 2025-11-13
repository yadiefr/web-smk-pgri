<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TataUsahaAuthController extends Controller
{
    /**
     * Show the login form for Tata Usaha
     */
    public function showLoginForm()
    {
        return view('auth.tata-usaha-login');
    }
    
    /**
     * Handle login request for Tata Usaha
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        
        $credentials = $request->only('username', 'password');
        
        if (Auth::attempt($credentials)) {
            // Check if user has tata_usaha role
            if (Auth::user()->role === 'tata_usaha' || Auth::user()->role === 'tu') {
                return redirect()->route('admin.tata-usaha.index');
            }
            
            // If user is not tata_usaha, logout and return with error
            Auth::logout();
            return back()->withErrors([
                'username' => 'Anda tidak memiliki akses sebagai Tata Usaha',
            ]);
        }
        
        return back()->withErrors([
            'username' => 'Username atau password salah',
        ]);
    }
    
    /**
     * Logout tata usaha user
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('tata-usaha.login');
    }
}
