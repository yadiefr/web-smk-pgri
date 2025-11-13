<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('kesiswaan.profile.index', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();

        return view('kesiswaan.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('admin_users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update basic info
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && Storage::disk('public')->exists('profiles/'.$user->photo)) {
                Storage::disk('public')->delete('profiles/'.$user->photo);
            }

            $file = $request->file('photo');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->storeAs('profiles', $fileName, 'public');
            $user->photo = $fileName;
        }

        $user->save();

        return redirect()->route('kesiswaan.profile.index')
            ->with('success', 'Profile berhasil diperbarui');
    }

    public function showChangePasswordForm()
    {
        return view('kesiswaan.profile.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'password.required' => 'Password baru wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $user = auth()->user();

        // Check current password
        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak cocok']);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('kesiswaan.profile.index')
            ->with('success', 'Password berhasil diubah');
    }
}
