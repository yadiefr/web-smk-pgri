<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\AdminUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = AdminUser::query();

        // Filter by search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && ! is_null($request->status)) {
            $query->where('status', $request->status === '1' ? 'aktif' : 'nonaktif');
        }

        $users = $query->orderBy('name')->paginate(10);
        $adminUsers = AdminUser::all(); // Tambahkan untuk menghitung statistik
        $roles = AdminUser::ROLES;

        return view('admin.users.index', compact('users', 'adminUsers', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Exclude 'guru' and 'siswa' roles from create form as they're managed in their respective modules
        $roles = collect(AdminUser::ROLES)->except(['guru', 'siswa'])->toArray();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        
        // Set default status if not provided
        $validated['status'] = $validated['status'] ?? 'aktif';
        
        // Hash password
        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }
        
        // Handle photo upload if provided
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('users', 'public');
            $validated['photo'] = $path;
        }

        $user = AdminUser::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AdminUser $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AdminUser $user)
    {
        // If current user is guru or siswa, show all roles for editing
        // Otherwise exclude 'guru' and 'siswa' roles from edit form
        $roles = in_array($user->role, ['guru', 'siswa']) ? AdminUser::ROLES : collect(AdminUser::ROLES)->except(['guru', 'siswa'])->toArray();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, AdminUser $user)
    {
        $validated = $request->validated();

        // Don't update password if not provided
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        // Set default status if not provided
        $validated['status'] = $validated['status'] ?? $user->status;

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdminUser $user)
    {
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    /**
     * Toggle user active status
     */
    public function toggleStatus(AdminUser $user)
    {
        // Prevent self-deactivation
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menonaktifkan akun sendiri.');
        }

        $user->status = $user->status === 'aktif' ? 'nonaktif' : 'aktif';
        $user->save();

        return redirect()->back()->with('success', 'Status user berhasil diperbarui.');
    }

    /**
     * Reset user password
     */
    public function resetPassword(AdminUser $user)
    {
        $password = 'password123'; // Default password
        $user->password = $password;
        $user->save();

        return redirect()->back()->with('success', 'Password user berhasil direset. Password baru: '.$password);
    }
}
