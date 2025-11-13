<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PendaftarAuthController extends Controller
{    public function __construct()
    {
        $this->middleware('ppdb.open')->only(['showRegistrationForm', 'register']);
        $this->middleware('guest:pendaftar,web,guru,siswa')->only(['showLoginForm', 'login', 'showRegistrationForm', 'register']);
        $this->middleware('auth:pendaftar')->only('logout');
    }public function showRegistrationForm()
    {
        // Check if already logged in as pendaftar
        if (Auth::guard('pendaftar')->check()) {
            return redirect()->route('pendaftaran.check');
        }
        
        return view('auth.ppdb.register');
    }public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:pendaftaran',
            'nisn' => 'required|string|size:10|unique:pendaftaran',
            'whatsapp' => 'required|string|regex:/^[0-9]{10,15}$/|unique:pendaftaran',
        ], [
            'username.unique' => 'Username sudah digunakan',
            'nisn.unique' => 'NISN sudah terdaftar',
            'whatsapp.unique' => 'Nomor WhatsApp sudah terdaftar',
            'whatsapp.regex' => 'Format nomor WhatsApp tidak valid. Masukkan antara 10-15 digit angka (contoh: 081234567890)',
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
            'whatsapp' => $request->whatsapp,
            'password' => $request->nisn, // Use NISN as password
            'is_active' => true,
            'status' => 'menunggu',
            'tahun_ajaran' => \App\Models\Settings::getValue('ppdb_year', date('Y').'/'.((int)date('Y')+1)),
        ]);

        // Auto login setelah registrasi
        Auth::guard('pendaftar')->login($pendaftaran);

        return redirect()
            ->route('pendaftaran.form')
            ->with('success', 'Akun berhasil dibuat. Silakan lengkapi formulir pendaftaran PPDB.');
    }    public function showLoginForm()
    {
        // Check if already logged in as pendaftar
        if (Auth::guard('pendaftar')->check()) {
            return redirect()->route('pendaftaran.check');
        }
        
        return view('auth.ppdb.login');
    }public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'whatsapp.regex' => 'Format nomor WhatsApp tidak valid. Masukkan minimal 10 digit dan maksimal 15 digit, diawali dengan 0. misal: 08123456789',
        ]);        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::guard('pendaftar')->attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect ke dashboard atau halaman check
            return redirect()->route('pendaftaran.check');
        }

        return back()
            ->withErrors([                'username' => 'Username atau password salah.',
            ])
            ->withInput($request->only('username'));
    }    public function logout(Request $request)
    {
        Auth::guard('pendaftar')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('pendaftar.login')
            ->with('success', 'Anda telah berhasil logout dari sistem PPDB.');
    }
}
