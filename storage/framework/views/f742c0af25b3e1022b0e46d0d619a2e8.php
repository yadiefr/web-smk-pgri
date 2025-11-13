<?php $__env->startSection('title', 'Detail User'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-user mr-3 text-blue-600"></i>
                Detail User
            </h1>
            <p class="text-gray-600 mt-1">Informasi lengkap <?php echo e($user->name); ?></p>
        </div>
        <div class="mt-4 md:mt-0 flex space-x-3">
            <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="<?php echo e(route('admin.users.index')); ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <div class="text-center">
                    <img src="<?php echo e($user->photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=3b82f6&color=ffffff&size=120'); ?>" alt="<?php echo e($user->name); ?>" 
                         class="rounded-full mx-auto mb-4" width="120" height="120">
                    <h4 class="text-xl font-semibold text-gray-900 mb-2"><?php echo e($user->name); ?></h4>
                    <p class="text-gray-600 mb-3"><?php echo e($user->email); ?></p>
                    <span class="inline-block bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full mb-2">
                        <?php echo e(ucfirst(str_replace('_', ' ', $user->role))); ?>

                    </span>
                    <br>
                    <span class="inline-block <?php echo e($user->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?> text-sm font-medium px-3 py-1 rounded-full">
                        <?php echo e(ucfirst($user->status)); ?>

                    </span>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-bolt mr-2 text-blue-600"></i>Quick Actions
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg flex items-center justify-center transition-colors">
                            <i class="fas fa-edit mr-2"></i>Edit User
                        </a>
                        
                        <form action="<?php echo e(route('admin.users.reset-password', $user)); ?>" method="POST" 
                              onsubmit="return confirm('Reset password ke default?')">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center justify-center transition-colors">
                                <i class="fas fa-key mr-2"></i>Reset Password
                            </button>
                        </form>
                        
                        <?php if($user->id !== auth()->id()): ?>
                        <button type="button" class="w-full <?php echo e($user->status == 'aktif' ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600'); ?> text-white px-4 py-2 rounded-lg flex items-center justify-center transition-colors" 
                                onclick="toggleStatus(<?php echo e($user->id); ?>)">
                            <i class="fas fa-toggle-<?php echo e($user->status == 'aktif' ? 'off' : 'on'); ?> mr-2"></i>
                            <?php echo e($user->status == 'aktif' ? 'Nonaktifkan' : 'Aktifkan'); ?>

                        </button>
                        
                        <button type="button" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center justify-center transition-colors" onclick="deleteUser(<?php echo e($user->id); ?>)">
                            <i class="fas fa-trash mr-2"></i>Hapus User
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-user-circle mr-2 text-blue-600"></i>Informasi Personal
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <p class="text-gray-900 text-base"><?php echo e($user->name); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <p class="text-gray-900 text-base"><?php echo e($user->email); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                            <p class="text-gray-900 text-base"><?php echo e($user->nip ?? '-'); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                            <p class="text-gray-900 text-base"><?php echo e($user->phone ?? '-'); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                            <p class="text-gray-900 text-base">
                                <?php echo e($user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d F Y') : '-'); ?>

                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                            <p class="text-gray-900 text-base">
                                <?php if($user->gender == 'L'): ?>
                                    Laki-laki
                                <?php elseif($user->gender == 'P'): ?>
                                    Perempuan
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                            <p class="text-gray-900 text-base"><?php echo e($user->address ?? '-'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-cogs mr-2 text-blue-600"></i>Informasi Sistem
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                            <p class="text-gray-900 text-base">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800"><?php echo e(ucfirst(str_replace('_', ' ', $user->role))); ?></span>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <p class="text-gray-900 text-base">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium <?php echo e($user->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                    <?php echo e(ucfirst($user->status)); ?>

                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Dibuat</label>
                            <p class="text-gray-900 text-base"><?php echo e($user->created_at->format('d F Y, H:i')); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Terakhir Diupdate</label>
                            <p class="text-gray-900 text-base"><?php echo e($user->updated_at->format('d F Y, H:i')); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Last Login</label>
                            <p class="text-gray-900 text-base">
                                <?php if($user->last_login_at): ?>
                                    <?php echo e(\Carbon\Carbon::parse($user->last_login_at)->format('d F Y, H:i')); ?>

                                <?php else: ?>
                                    <span class="text-gray-500">Belum pernah login</span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Last Login IP</label>
                            <p class="text-gray-900 text-base"><?php echo e($user->last_login_ip ?? '-'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Log -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-history mr-2 text-blue-600"></i>Aktivitas Terakhir
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <?php if($user->last_login_at): ?>
                            <div class="flex items-center">
                                <i class="fas fa-sign-in-alt text-green-500 mr-3"></i>
                                <span class="text-gray-700">Login terakhir: <?php echo e(\Carbon\Carbon::parse($user->last_login_at)->diffForHumans()); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <div class="flex items-center">
                            <i class="fas fa-calendar-plus text-blue-500 mr-3"></i>
                            <span class="text-gray-700">Bergabung sejak: <?php echo e($user->created_at->diffForHumans()); ?></span>
                        </div>
                        
                        <div class="flex items-center">
                            <i class="fas fa-edit text-yellow-500 mr-3"></i>
                            <span class="text-gray-700">Terakhir diupdate: <?php echo e($user->updated_at->diffForHumans()); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900">Konfirmasi Hapus</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Apakah Anda yakin ingin menghapus user <strong><?php echo e($user->name); ?></strong>?
                    <br><small class="text-red-600">Tindakan ini tidak dapat dibatalkan!</small>
                </p>
            </div>
            <div class="flex justify-center space-x-4 mt-4">
                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 focus:outline-none">
                    Batal
                </button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
// Ensure DOM is loaded before setting up event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Setup modal event listener
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    }
});

// Global functions that can be called from onclick attributes
window.toggleStatus = function(userId) {
    if (confirm('Ubah status user ini?')) {
        fetch(`<?php echo e(url('admin/users')); ?>/${userId}/toggle-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Content-Type': 'application/json',
            }
        })
        .then(response => {
            if (response.ok) {
                location.reload();
            } else {
                alert('Terjadi kesalahan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }
}

window.deleteUser = function(userId) {
    const form = document.getElementById('deleteForm');
    if (form) {
        form.action = `<?php echo e(url('admin/users')); ?>/${userId}`;
        const deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            deleteModal.classList.remove('hidden');
        }
    }
}

window.closeDeleteModal = function() {
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.classList.add('hidden');
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\website-smk3\resources\views\admin\users\show.blade.php ENDPATH**/ ?>