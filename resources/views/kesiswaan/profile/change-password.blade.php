@extends('layouts.kesiswaan')

@section('title', 'Ubah Password')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-key mr-3 text-red-600"></i>
                    Ubah Password
                </h1>
                <p class="text-gray-600 mt-1">Update password untuk keamanan akun Anda</p>
            </div>
            
            <a href="{{ route('kesiswaan.profile.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Change Password Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('kesiswaan.profile.update-password') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Security Notice -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex">
                    <i class="fas fa-shield-alt text-yellow-600 mt-0.5 mr-3"></i>
                    <div>
                        <h3 class="text-sm font-medium text-yellow-800">Tips Keamanan Password</h3>
                        <div class="text-sm text-yellow-700 mt-1">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Gunakan kombinasi huruf besar, huruf kecil, angka, dan simbol</li>
                                <li>Minimal 8 karakter panjang</li>
                                <li>Jangan gunakan informasi personal yang mudah ditebak</li>
                                <li>Ubah password secara berkala</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Password -->
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password Saat Ini <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="password" 
                           name="current_password" 
                           id="current_password" 
                           class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('current_password') border-red-500 @enderror">
                    <button type="button" 
                            onclick="togglePassword('current_password')"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="current_password_icon"></i>
                    </button>
                </div>
                @error('current_password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- New Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password Baru <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="password" 
                           name="password" 
                           id="password" 
                           class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror">
                    <button type="button" 
                            onclick="togglePassword('password')"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="password_icon"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm New Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Konfirmasi Password Baru <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="password" 
                           name="password_confirmation" 
                           id="password_confirmation" 
                           class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <button type="button" 
                            onclick="togglePassword('password_confirmation')"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <i class="fas fa-eye text-gray-400 hover:text-gray-600" id="password_confirmation_icon"></i>
                    </button>
                </div>
            </div>

            <!-- Password Strength Indicator -->
            <div id="password-strength" class="hidden">
                <div class="flex items-center space-x-2 mb-2">
                    <span class="text-sm font-medium text-gray-700">Kekuatan Password:</span>
                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                        <div id="strength-bar" class="h-2 rounded-full transition-all duration-300"></div>
                    </div>
                    <span id="strength-text" class="text-sm font-medium"></span>
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
                            class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <i class="fas fa-key mr-2"></i>
                        Ubah Password
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '_icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.className = 'fas fa-eye-slash text-gray-400 hover:text-gray-600';
    } else {
        field.type = 'password';
        icon.className = 'fas fa-eye text-gray-400 hover:text-gray-600';
    }
}

// Password strength checker
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const strengthIndicator = document.getElementById('password-strength');
    const strengthBar = document.getElementById('strength-bar');
    const strengthText = document.getElementById('strength-text');
    
    if (password.length === 0) {
        strengthIndicator.classList.add('hidden');
        return;
    }
    
    strengthIndicator.classList.remove('hidden');
    
    let strength = 0;
    let feedback = [];
    
    // Length check
    if (password.length >= 8) strength += 1;
    else feedback.push('minimal 8 karakter');
    
    // Lowercase check
    if (/[a-z]/.test(password)) strength += 1;
    else feedback.push('huruf kecil');
    
    // Uppercase check
    if (/[A-Z]/.test(password)) strength += 1;
    else feedback.push('huruf besar');
    
    // Number check
    if (/\d/.test(password)) strength += 1;
    else feedback.push('angka');
    
    // Special character check
    if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength += 1;
    else feedback.push('simbol');
    
    // Update UI based on strength
    switch (strength) {
        case 0:
        case 1:
            strengthBar.style.width = '20%';
            strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-red-500';
            strengthText.textContent = 'Lemah';
            strengthText.className = 'text-sm font-medium text-red-600';
            break;
        case 2:
            strengthBar.style.width = '40%';
            strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-orange-500';
            strengthText.textContent = 'Kurang';
            strengthText.className = 'text-sm font-medium text-orange-600';
            break;
        case 3:
            strengthBar.style.width = '60%';
            strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-yellow-500';
            strengthText.textContent = 'Sedang';
            strengthText.className = 'text-sm font-medium text-yellow-600';
            break;
        case 4:
            strengthBar.style.width = '80%';
            strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-blue-500';
            strengthText.textContent = 'Baik';
            strengthText.className = 'text-sm font-medium text-blue-600';
            break;
        case 5:
            strengthBar.style.width = '100%';
            strengthBar.className = 'h-2 rounded-full transition-all duration-300 bg-green-500';
            strengthText.textContent = 'Kuat';
            strengthText.className = 'text-sm font-medium text-green-600';
            break;
    }
});
</script>
@endsection
