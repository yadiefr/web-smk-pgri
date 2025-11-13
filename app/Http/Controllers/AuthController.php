<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{    /**
     * Tampilkan halaman login
     */    public function showLoginForm()
    {
        // Cek semua guard yang mungkin aktif
        if (\Auth::guard('web')->check()) {
            $user = \Auth::guard('web')->user();
            // Redirect berdasarkan role
            switch ($user->role) {
                case 'tata_usaha':
                case 'tu':
                    return redirect()->route('tata-usaha.index');
                case 'kesiswaan':
                    return redirect()->route('kesiswaan.dashboard');
                default:
                    return redirect()->route('admin.dashboard');
            }
        } elseif (\Auth::guard('guru')->check()) {
            return redirect()->route('guru.dashboard');
        } elseif (\Auth::guard('siswa')->check()) {
            return redirect()->route('siswa.dashboard');
        }
        return view('auth.login');
    }    /**
     * Proses login user (admin, tata usaha, guru, siswa)
     */
    public function login(LoginRequest $request)
    {
        // Rate limiting - 5 attempts per minute per IP
        $key = 'login.' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return redirect()->back()
                ->with('error', "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.")
                ->withInput($request->except('password'));
        }

        $login = $request->input('username');
        $password = $request->input('password');
        $remember = $request->filled('remember');

        // Admin login attempt (email only)
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            if (Auth::guard('web')->attempt(['email' => $login, 'password' => $password], $remember)) {
                $user = Auth::guard('web')->user();
                if ($user->status === 'nonaktif') {
                    Auth::guard('web')->logout();
                    return redirect()->route('login')->with('error', 'Akun Anda dinonaktifkan.');
                }
                
                // Clear rate limiter on successful login
                RateLimiter::clear($key);
                
                $request->session()->regenerate();
                
                // Log successful login
                \Log::info('Successful login', [
                    'user_id' => $user->id,
                    'role' => $user->role,
                    'ip' => $request->ip(),
                    'timestamp' => now()
                ]);
                
                // Cek role untuk mengarahkan ke dashboard yang tepat
                switch ($user->role) {
                    case 'tata_usaha':
                    case 'tu':
                        return redirect()->intended(route('tata-usaha.index'));
                    case 'kesiswaan':
                        return redirect()->intended(route('kesiswaan.dashboard'));
                    default:
                        return redirect()->intended(route('admin.dashboard'));
                }
            }
        }

        // Guru login attempt
        if (Auth::guard('guru')->attempt(['nip' => $login, 'password' => $password], $remember) || 
            Auth::guard('guru')->attempt(['email' => $login, 'password' => $password], $remember)) {
            $user = Auth::guard('guru')->user();
            if (!$user->is_active) {
                Auth::guard('guru')->logout();
                return redirect()->route('login')->with('error', 'Akun Anda dinonaktifkan.');
            }
            
            // Clear rate limiter on successful login
            RateLimiter::clear($key);
            
            $request->session()->regenerate();
            
            // Log successful guru login
            \Log::info('Successful guru login', [
                'user_id' => $user->id,
                'nip' => $user->nip,
                'ip' => $request->ip(),
                'timestamp' => now()
            ]);
            
            return redirect()->intended(route('guru.dashboard'));
        }

        // Siswa login attempt
        if (Auth::guard('siswa')->attempt(['nis' => $login, 'password' => $password], $remember) || 
            Auth::guard('siswa')->attempt(['email' => $login, 'password' => $password], $remember)) {
            $user = Auth::guard('siswa')->user();
            if ($user->status !== 'aktif') {
                Auth::guard('siswa')->logout();
                return redirect()->route('login')->with('error', 'Akun Anda dinonaktifkan.');
            }
            
            // Clear rate limiter on successful login
            RateLimiter::clear($key);
            
            $request->session()->regenerate();
            
            // Log successful siswa login
            \Log::info('Successful siswa login', [
                'user_id' => $user->id,
                'nis' => $user->nis,
                'ip' => $request->ip(),
                'timestamp' => now()
            ]);
            
            return redirect()->intended(route('siswa.dashboard'));
        }

        // Increment rate limiter on failed attempt
        RateLimiter::hit($key, 60); // 60 seconds lockout period
        
        // Log failed login attempt
        \Log::warning('Login failed for all guards', [
            'login' => $login,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()
        ]);

        return redirect()->back()
            ->with('error', 'Email/NIS/NIP atau password yang Anda masukkan salah.')
            ->withInput($request->except('password'));
    }    /**
     * Logout semua guard (admin, tata usaha, guru, siswa)
     */
    public function logout(Request $request)
    {
        $guards = ['web', 'guru', 'siswa'];
        $loggedOutFromAnyGuard = false;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout(); // This handles remember token invalidation in DB
                $loggedOutFromAnyGuard = true;
            }
        }

        if ($loggedOutFromAnyGuard) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        
        $response = redirect()->route('login')->with('success', 'Anda berhasil logout.');
        $response->withCookie(\Illuminate\Support\Facades\Cookie::forget(config('session.cookie')));
        
        return $response;
    }

    /**
     * Tampilkan halaman lupa password
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Proses reset password
     */
    public function processForgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Proses reset password akan diimplementasikan lebih lanjut
        // dengan email notification

        return redirect()->route('login')
            ->with('success', 'Link reset password telah dikirim ke email Anda.');
    }

    /**
     * Tampilkan halaman profil
     */
    public function showProfile()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    /**
     * Update profil user
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->hasFile('photo')) {
            // Handle file upload
            $file = $request->file('photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profiles'), $fileName);
            
            // Delete old photo if exists
            if ($user->photo && file_exists(public_path('uploads/profiles/' . $user->photo))) {
                unlink(public_path('uploads/profiles/' . $user->photo));
            }
            
            $user->photo = $fileName;
        }

        $user->save();

        return redirect()->back()
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Tampilkan halaman ubah password
     */
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    /**
     * Proses ubah password
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Password saat ini tidak cocok.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()
            ->with('success', 'Password berhasil diubah.');
    }
}
