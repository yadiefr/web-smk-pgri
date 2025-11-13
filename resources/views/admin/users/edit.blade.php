@extends('layouts.admin')

@section('title', 'Edit Pengguna')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-user-edit mr-3 text-blue-600"></i>
                Edit Pengguna
            </h1>
            <p class="text-gray-600 mt-1">Edit informasi {{ $user->name }}</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg flex items-center transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-user-edit mr-2 text-blue-600"></i>Informasi Pengguna
                    </h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <!-- Basic Information -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                           value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                                           value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                    <input type="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror">
                                    <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah password</p>
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Role <span class="text-red-500">*</span></label>
                                    <select name="role" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('role') border-red-500 @enderror" required>
                                        <option value="">Pilih Role</option>
                                        @foreach($roles as $key => $value)
                                            <option value="{{ $key }}" {{ old('role', $user->role) == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex justify-end space-x-4 pt-6">
                                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-times mr-2"></i>Batal
                                </a>
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-save mr-2"></i>Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- User Info -->
        <div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-blue-600"></i>Informasi Pengguna
                    </h3>
                </div>
                <div class="p-6">
                    <div class="flex flex-col items-center mb-6">
                        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 mb-3">
                            <i class="fas fa-user text-3xl"></i>
                        </div>
                        <h4 class="text-lg font-medium text-gray-900">{{ $user->name }}</h4>
                        <p class="text-gray-600">{{ ucfirst($user->role ?? 'User') }}</p>
                    </div>
                    
                    <div class="space-y-3 border-t border-gray-200 pt-4">
                        <div class="grid grid-cols-2">
                            <div class="text-sm text-gray-500">Status:</div>
                            <div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2">
                            <div class="text-sm text-gray-500">Email:</div>
                            <div class="text-sm">{{ $user->email }}</div>
                        </div>
                        
                        <div class="grid grid-cols-2">
                            <div class="text-sm text-gray-500">Dibuat:</div>
                            <div class="text-sm">{{ $user->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                        
                        <div class="grid grid-cols-2">
                            <div class="text-sm text-gray-500">Diupdate:</div>
                            <div class="text-sm">{{ $user->updated_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                    
                    <!-- Quick Actions -->
                    @if($user->id !== auth()->id())
                    <div class="mt-6 space-y-2">
                        <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg hover:bg-yellow-200 flex items-center justify-center space-x-2">
                                <i class="fas {{ $user->is_active ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                <span>{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }} User</span>
                            </button>
                        </form>
                        
                        <form action="{{ route('admin.users.reset-password', $user->id) }}" method="POST" 
                            onsubmit="return confirm('Apakah Anda yakin ingin mereset password user ini?')">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-blue-100 text-blue-800 rounded-lg hover:bg-blue-200 flex items-center justify-center space-x-2">
                                <i class="fas fa-key"></i>
                                <span>Reset Password</span>
                            </button>
                        </form>
                        
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" 
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2 bg-red-100 text-red-800 rounded-lg hover:bg-red-200 flex items-center justify-center space-x-2">
                                <i class="fas fa-trash"></i>
                                <span>Hapus User</span>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
