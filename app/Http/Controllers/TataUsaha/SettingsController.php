<?php

namespace App\Http\Controllers\TataUsaha;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // General settings for tata usaha
        $settings = [
            'school_name' => config('app.name', 'SMK Negeri 3'),
            'school_address' => 'Jalan Raya Sekolah No. 123',
            'school_phone' => '(021) 12345678',
            'school_email' => 'info@smk3.sch.id',
            'academic_year' => '2024/2025',
            'semester' => 'Ganjil',
        ];

        return view('tata_usaha.settings.index', compact('user', 'settings'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate based on the type of update
        if ($request->has('update_profile')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,'.$user->id,
                'phone' => 'nullable|string|max:20',
            ]);

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            return redirect()->route('tata-usaha.settings')
                ->with('success', 'Profil berhasil diperbarui.');
        }

        if ($request->has('update_password')) {
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if (! Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
            }

            $user->update([
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('tata-usaha.settings')
                ->with('success', 'Password berhasil diperbarui.');
        }

        if ($request->has('update_school_settings')) {
            // This would typically update school settings in a settings table or config
            // For now, we'll just show a success message
            return redirect()->route('tata-usaha.settings')
                ->with('success', 'Pengaturan sekolah berhasil diperbarui.');
        }

        return redirect()->route('tata-usaha.settings')
            ->with('error', 'Tidak ada data yang diperbarui.');
    }
}
