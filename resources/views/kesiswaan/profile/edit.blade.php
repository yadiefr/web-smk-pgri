@extends('layouts.kesiswaan')

@section('title', 'Edit Profile')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-user-edit mr-3 text-blue-600"></i>
                    Edit Profile
                </h1>
                <p class="text-gray-600 mt-1">Perbarui informasi profile Anda</p>
            </div>
            
            <a href="{{ route('kesiswaan.profile.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('kesiswaan.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Photo Upload -->
            <div class="flex items-center space-x-6">
                <div class="shrink-0">
                    @if($user->photo)
                        <img id="photoPreview" src="{{ asset('storage/profiles/' . $user->photo) }}" 
                             alt="{{ $user->name }}" 
                             class="w-20 h-20 rounded-full object-cover border-4 border-gray-200">
                    @else
                        <div id="photoPreview" class="w-20 h-20 rounded-full bg-gray-300 flex items-center justify-center border-4 border-gray-200">
                            <i class="fas fa-user text-gray-500 text-xl"></i>
                        </div>
                    @endif
                </div>
                <div class="flex-1">
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Foto Profile</label>
                    <input type="file" 
                           name="photo" 
                           id="photo" 
                           accept="image/*"
                           onchange="previewPhoto(event)"
                           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">JPG, JPEG, atau PNG. Maksimal 2MB.</p>
                    @error('photo')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-user-circle mr-2 text-blue-600"></i>
                        Informasi Dasar
                    </h3>
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name', $user->name) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email', $user->email) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-phone mr-2 text-blue-600"></i>
                        Informasi Kontak
                    </h3>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            No. Telepon
                        </label>
                        <input type="text" 
                               name="phone" 
                               id="phone" 
                               value="{{ old('phone', $user->phone) }}"
                               placeholder="Contoh: 08123456789"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat
                        </label>
                        <textarea name="address" 
                                  id="address" 
                                  rows="3"
                                  placeholder="Masukkan alamat lengkap"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('address') border-red-500 @enderror">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Account Information (Read Only) -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-cog mr-2 text-gray-600"></i>
                    Informasi Akun
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                        <input type="text" 
                               value="{{ ucfirst($user->role) }}" 
                               readonly
                               class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <input type="text" 
                               value="{{ ucfirst($user->status) }}" 
                               readonly
                               class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Terdaftar</label>
                        <input type="text" 
                               value="{{ $user->created_at->format('d/m/Y') }}" 
                               readonly
                               class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <div class="text-sm text-gray-600">
                    <span class="text-red-500">*</span> Field wajib diisi
                </div>
                
                <div class="flex items-center space-x-3">
                    <a href="{{ route('kesiswaan.profile.index') }}" 
                       class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function previewPhoto(event) {
    const input = event.target;
    const preview = document.getElementById('photoPreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-20 h-20 rounded-full object-cover border-4 border-gray-200">`;
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
