

<?php $__env->startSection('title', 'Profile'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-user mr-3 text-blue-600"></i>
                    Profile Saya
                </h1>
                <p class="text-gray-600 mt-1">Kelola informasi profile Anda</p>
            </div>
            
            <div class="flex items-center space-x-3">
                <a href="<?php echo e(route('kesiswaan.profile.edit')); ?>" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Profile
                </a>
                <a href="<?php echo e(route('kesiswaan.profile.change-password')); ?>" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-key mr-2"></i>
                    Ubah Password
                </a>
            </div>
        </div>
    </div>

    <!-- Profile Information -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
            <div class="flex items-center space-x-4">
                <?php if($user->photo): ?>
                    <img src="<?php echo e(asset('storage/profiles/' . $user->photo)); ?>" 
                         alt="<?php echo e($user->name); ?>" 
                         class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-lg">
                <?php else: ?>
                    <div class="w-20 h-20 rounded-full bg-blue-500 flex items-center justify-center border-4 border-white shadow-lg">
                        <i class="fas fa-user text-white text-2xl"></i>
                    </div>
                <?php endif; ?>
                
                <div>
                    <h2 class="text-2xl font-bold text-gray-900"><?php echo e($user->name); ?></h2>
                    <p class="text-blue-600 font-medium"><?php echo e(ucfirst($user->role)); ?></p>
                    <div class="flex items-center mt-1">
                        <?php if($user->status === 'aktif'): ?>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>
                                Aktif
                            </span>
                        <?php else: ?>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                <i class="fas fa-times-circle mr-1"></i>
                                Nonaktif
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Personal Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-user-circle mr-2 text-blue-600"></i>
                        Informasi Personal
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-24 text-sm font-medium text-gray-600">Nama:</div>
                            <div class="flex-1 text-sm text-gray-900"><?php echo e($user->name); ?></div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-24 text-sm font-medium text-gray-600">Email:</div>
                            <div class="flex-1 text-sm text-gray-900"><?php echo e($user->email); ?></div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-24 text-sm font-medium text-gray-600">No. HP:</div>
                            <div class="flex-1 text-sm text-gray-900"><?php echo e($user->phone ?? '-'); ?></div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-24 text-sm font-medium text-gray-600">Alamat:</div>
                            <div class="flex-1 text-sm text-gray-900"><?php echo e($user->address ?? '-'); ?></div>
                        </div>
                    </div>
                </div>

                <!-- Account Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-cog mr-2 text-blue-600"></i>
                        Informasi Akun
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-32 text-sm font-medium text-gray-600">Role:</div>
                            <div class="flex-1">
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                                    <?php echo e(ucfirst($user->role)); ?>

                                </span>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-32 text-sm font-medium text-gray-600">Status:</div>
                            <div class="flex-1">
                                <?php if($user->status === 'aktif'): ?>
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                        Nonaktif
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-32 text-sm font-medium text-gray-600">Terdaftar:</div>
                            <div class="flex-1 text-sm text-gray-900"><?php echo e($user->created_at->format('d F Y H:i')); ?></div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-32 text-sm font-medium text-gray-600">Terakhir Update:</div>
                            <div class="flex-1 text-sm text-gray-900"><?php echo e($user->updated_at->format('d F Y H:i')); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Security Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-shield-alt mr-2 text-red-600"></i>
            Keamanan Akun
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                <div class="flex items-start">
                    <i class="fas fa-key text-yellow-600 mt-1 mr-3"></i>
                    <div>
                        <h4 class="font-medium text-yellow-800">Password</h4>
                        <p class="text-sm text-yellow-700 mt-1">
                            Ubah password secara berkala untuk menjaga keamanan akun Anda.
                        </p>
                        <a href="<?php echo e(route('kesiswaan.profile.change-password')); ?>" 
                           class="mt-2 inline-flex items-center text-sm text-yellow-800 hover:text-yellow-900">
                            Ubah Password
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                <div class="flex items-start">
                    <i class="fas fa-user-edit text-blue-600 mt-1 mr-3"></i>
                    <div>
                        <h4 class="font-medium text-blue-800">Informasi Profile</h4>
                        <p class="text-sm text-blue-700 mt-1">
                            Pastikan informasi profile Anda selalu update dan akurat.
                        </p>
                        <a href="<?php echo e(route('kesiswaan.profile.edit')); ?>" 
                           class="mt-2 inline-flex items-center text-sm text-blue-800 hover:text-blue-900">
                            Edit Profile
                            <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.kesiswaan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\website-smk3\resources\views\kesiswaan\profile\index.blade.php ENDPATH**/ ?>