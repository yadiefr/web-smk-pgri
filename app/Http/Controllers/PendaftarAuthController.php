<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PendaftarAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('ppdb.open')->except(['showLoginForm', 'login', 'showForgotPasswordForm', 'forgotPassword', 'logout']);
    }

    public function showRegistrationForm()
    {
        return view('auth.pendaftar-register');
    }

    public function showLoginForm()
    {
        return view('auth.pendaftar-login');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'nisn' => 'required|string|size:10|unique:pendaftaran',
            'username' => 'required|string|max:255|unique:pendaftaran',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        // Buat akun pendaftar baru di tabel pendaftaran
        $pendaftaran = Pendaftaran::create([
            'nama_lengkap' => $request->name,
            'nisn' => $request->nisn,
            'username' => $request->username,
            'password' => $request->password, // akan di-hash otomatis oleh mutator
            'is_active' => true,
            'status' => 'menunggu',
            'tahun_ajaran' => \App\Models\Settings::getValue('ppdb_year', date('Y').'/'.((int)date('Y')+1)),
        ]);

        // Auto login setelah registrasi
        Auth::guard('pendaftar')->login($pendaftaran);

        // Redirect ke form untuk melengkapi data
        return redirect()
            ->route('pendaftaran.form')
            ->with('success', 'Akun berhasil dibuat! Sekarang lengkapi data diri Anda.');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        if (Auth::guard('pendaftar')->attempt($validator->validated())) {
            $request->session()->regenerate();

            // User sekarang langsung adalah pendaftaran
            $pendaftaran = Auth::guard('pendaftar')->user();
            
            return redirect()->route('pendaftar.dashboard');
        }

        return back()
            ->withErrors(['username' => 'Username atau password salah.'])
            ->withInput($request->except('password'));
    }    public function logout(Request $request)
    {
        Auth::guard('pendaftar')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('pendaftar.login');
    }
}
