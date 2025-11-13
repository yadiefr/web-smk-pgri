

<?php $__env->startSection('title', 'Edit Pelanggaran - ' . $pelanggaran->siswa->nama_lengkap); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-edit mr-3 text-yellow-600"></i>
                    Edit Pelanggaran Siswa
                </h1>
                <p class="text-gray-600 mt-1">Ubah informasi pelanggaran dan sanksi yang diberikan</p>
            </div>
            <div class="flex gap-3">
                <a href="<?php echo e(route('kesiswaan.pelanggaran.show', $pelanggaran)); ?>" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-eye mr-2"></i>
                    Lihat Detail
                </a>
                <a href="<?php echo e(route('kesiswaan.pelanggaran.index')); ?>" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Status Current -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
            <i class="fas fa-info-circle mr-2 text-blue-600"></i>
            Status Saat Ini
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?php echo e($pelanggaran->getStatusBadgeColor()); ?>">
                    <i class="fas fa-circle mr-1 text-xs"></i>
                    <?php echo e(ucfirst($pelanggaran->status)); ?>

                </span>
                <p class="text-xs text-gray-500 mt-1">Status</p>
            </div>
            <div class="text-center">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?php echo e($pelanggaran->getUrgencyBadgeColor()); ?>">
                    <i class="fas fa-exclamation-triangle mr-1 text-xs"></i>
                    <?php echo e(ucwords(str_replace('_', ' ', $pelanggaran->tingkat_urgensi))); ?>

                </span>
                <p class="text-xs text-gray-500 mt-1">Urgensi</p>
            </div>
            <div class="text-center">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?php echo e($pelanggaran->jenisPelanggaran->getBadgeColor()); ?>">
                    <?php echo e($pelanggaran->jenisPelanggaran->poin_pelanggaran); ?> Poin
                </span>
                <p class="text-xs text-gray-500 mt-1">Poin Pelanggaran</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="<?php echo e(route('kesiswaan.pelanggaran.update', $pelanggaran)); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <!-- Informasi Dasar -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                    Informasi Dasar
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Pilih Siswa -->
                    <div>
                        <label for="siswa_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Siswa <span class="text-red-500">*</span>
                        </label>
                        <select name="siswa_id" id="siswa_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 <?php $__errorArgs = ['siswa_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">Pilih Siswa</option>
                            <?php $__currentLoopData = $siswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($s->id); ?>" <?php echo e((old('siswa_id', $pelanggaran->siswa_id) == $s->id) ? 'selected' : ''); ?>>
                                    <?php echo e($s->nama_lengkap); ?> - <?php echo e($s->nis); ?> (<?php echo e($s->kelas->nama_kelas ?? 'N/A'); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['siswa_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Jenis Pelanggaran -->
                    <div>
                        <label for="jenis_pelanggaran_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Pelanggaran <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_pelanggaran_id" id="jenis_pelanggaran_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 <?php $__errorArgs = ['jenis_pelanggaran_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">Pilih Jenis Pelanggaran</option>
                            <?php $__currentLoopData = $jenisPelanggaran->groupBy('kategori'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kategori => $jenisGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <optgroup label="<?php echo e(ucfirst($kategori)); ?>">
                                    <?php $__currentLoopData = $jenisGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($jenis->id); ?>" 
                                                data-sanksi="<?php echo e($jenis->sanksi_default); ?>"
                                                data-poin="<?php echo e($jenis->poin_pelanggaran); ?>"
                                                <?php echo e((old('jenis_pelanggaran_id', $pelanggaran->jenis_pelanggaran_id) == $jenis->id) ? 'selected' : ''); ?>>
                                            <?php echo e($jenis->nama_pelanggaran); ?> (<?php echo e($jenis->poin_pelanggaran); ?> poin)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </optgroup>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['jenis_pelanggaran_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Tanggal Pelanggaran -->
                    <div>
                        <label for="tanggal_pelanggaran" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Pelanggaran <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_pelanggaran" id="tanggal_pelanggaran" 
                               value="<?php echo e(old('tanggal_pelanggaran', $pelanggaran->tanggal_pelanggaran)); ?>" required
                               max="<?php echo e(date('Y-m-d')); ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 <?php $__errorArgs = ['tanggal_pelanggaran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['tanggal_pelanggaran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Jam Pelanggaran -->
                    <div>
                        <label for="jam_pelanggaran" class="block text-sm font-medium text-gray-700 mb-2">
                            Jam Pelanggaran
                        </label>
                        <input type="time" name="jam_pelanggaran" id="jam_pelanggaran" 
                               value="<?php echo e(old('jam_pelanggaran', $pelanggaran->jam_pelanggaran)); ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 <?php $__errorArgs = ['jam_pelanggaran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['jam_pelanggaran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Pelapor -->
                    <div>
                        <label for="guru_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Dilaporkan oleh (Guru)
                        </label>
                        <select name="guru_id" id="guru_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 <?php $__errorArgs = ['guru_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">Pilih Guru</option>
                            <?php $__currentLoopData = $guru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($g->id); ?>" <?php echo e((old('guru_id', $pelanggaran->guru_id) == $g->id) ? 'selected' : ''); ?>>
                                    <?php echo e($g->nama); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['guru_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Tingkat Urgensi -->
                    <div>
                        <label for="tingkat_urgensi" class="block text-sm font-medium text-gray-700 mb-2">
                            Tingkat Urgensi <span class="text-red-500">*</span>
                        </label>
                        <select name="tingkat_urgensi" id="tingkat_urgensi" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 <?php $__errorArgs = ['tingkat_urgensi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">Pilih Tingkat Urgensi</option>
                            <option value="rendah" <?php echo e((old('tingkat_urgensi', $pelanggaran->tingkat_urgensi) == 'rendah') ? 'selected' : ''); ?>>Rendah</option>
                            <option value="sedang" <?php echo e((old('tingkat_urgensi', $pelanggaran->tingkat_urgensi) == 'sedang') ? 'selected' : ''); ?>>Sedang</option>
                            <option value="tinggi" <?php echo e((old('tingkat_urgensi', $pelanggaran->tingkat_urgensi) == 'tinggi') ? 'selected' : ''); ?>>Tinggi</option>
                            <option value="sangat_tinggi" <?php echo e((old('tingkat_urgensi', $pelanggaran->tingkat_urgensi) == 'sangat_tinggi') ? 'selected' : ''); ?>>Sangat Tinggi</option>
                        </select>
                        <?php $__errorArgs = ['tingkat_urgensi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="aktif" <?php echo e((old('status', $pelanggaran->status) == 'aktif') ? 'selected' : ''); ?>>Aktif</option>
                            <option value="selesai" <?php echo e((old('status', $pelanggaran->status) == 'selesai') ? 'selected' : ''); ?>>Selesai</option>
                            <option value="banding" <?php echo e((old('status', $pelanggaran->status) == 'banding') ? 'selected' : ''); ?>>Banding</option>
                        </select>
                        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <!-- Detail Kejadian -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-file-alt mr-2 text-green-600"></i>
                    Detail Kejadian
                </h3>

                <div class="space-y-4">
                    <!-- Deskripsi Kejadian -->
                    <div>
                        <label for="deskripsi_kejadian" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Kejadian <span class="text-red-500">*</span>
                        </label>
                        <textarea name="deskripsi_kejadian" id="deskripsi_kejadian" rows="4" required
                                  placeholder="Jelaskan secara detail pelanggaran yang terjadi, kapan, dimana, dan bagaimana kejadiannya..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 resize-none <?php $__errorArgs = ['deskripsi_kejadian'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('deskripsi_kejadian', $pelanggaran->deskripsi_kejadian)); ?></textarea>
                        <?php $__errorArgs = ['deskripsi_kejadian'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Bukti Foto -->
                    <div>
                        <label for="bukti_foto" class="block text-sm font-medium text-gray-700 mb-2">
                            Bukti Foto
                        </label>
                        
                        <?php if($pelanggaran->bukti_foto): ?>
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Foto saat ini:</p>
                            <div class="inline-block relative">
                                <img src="<?php echo e(Storage::url($pelanggaran->bukti_foto)); ?>" 
                                     alt="Bukti Pelanggaran" 
                                     class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                                <div class="mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="hapus_foto" value="1" class="form-checkbox">
                                        <span class="ml-2 text-sm text-red-600">Hapus foto ini</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <input type="file" name="bukti_foto" id="bukti_foto" 
                               accept="image/jpeg,image/png,image/jpg"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 <?php $__errorArgs = ['bukti_foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Maksimal 2MB. Biarkan kosong jika tidak ingin mengubah foto.</p>
                        <?php $__errorArgs = ['bukti_foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <!-- Sanksi dan Tindak Lanjut -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-gavel mr-2 text-orange-600"></i>
                    Sanksi dan Tindak Lanjut
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Sanksi Diberikan -->
                    <div class="md:col-span-2">
                        <label for="sanksi_diberikan" class="block text-sm font-medium text-gray-700 mb-2">
                            Sanksi yang Diberikan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="sanksi_diberikan" id="sanksi_diberikan" rows="3" required
                                  placeholder="Contoh: Teguran tertulis, pembersihan lingkungan sekolah selama 3 hari, panggilan orang tua..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 resize-none <?php $__errorArgs = ['sanksi_diberikan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('sanksi_diberikan', $pelanggaran->sanksi_diberikan)); ?></textarea>
                        <?php $__errorArgs = ['sanksi_diberikan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Tanggal Selesai Sanksi -->
                    <div>
                        <label for="tanggal_selesai_sanksi" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Selesai Sanksi
                        </label>
                        <input type="date" name="tanggal_selesai_sanksi" id="tanggal_selesai_sanksi" 
                               value="<?php echo e(old('tanggal_selesai_sanksi', $pelanggaran->tanggal_selesai_sanksi)); ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 <?php $__errorArgs = ['tanggal_selesai_sanksi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['tanggal_selesai_sanksi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Catatan Tambahan -->
                    <div>
                        <label for="catatan_tambahan" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan Tambahan
                        </label>
                        <textarea name="catatan_tambahan" id="catatan_tambahan" rows="3"
                                  placeholder="Catatan khusus tentang pelanggaran atau sanksi..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 resize-none <?php $__errorArgs = ['catatan_tambahan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('catatan_tambahan', $pelanggaran->catatan_tambahan)); ?></textarea>
                        <?php $__errorArgs = ['catatan_tambahan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <!-- Komunikasi dengan Orang Tua -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-phone mr-2 text-purple-600"></i>
                    Komunikasi dengan Orang Tua
                </h3>

                <div class="space-y-4">
                    <!-- Sudah Dihubungi Orang Tua -->
                    <div class="flex items-center">
                        <input type="checkbox" name="sudah_dihubungi_ortu" id="sudah_dihubungi_ortu" value="1"
                               <?php echo e(old('sudah_dihubungi_ortu', $pelanggaran->sudah_dihubungi_ortu) ? 'checked' : ''); ?>

                               class="h-4 w-4 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded">
                        <label for="sudah_dihubungi_ortu" class="ml-2 block text-sm text-gray-900">
                            Sudah menghubungi orang tua/wali siswa
                        </label>
                    </div>

                    <!-- Respon Orang Tua -->
                    <div id="respon_ortu_container" <?php echo e(!old('sudah_dihubungi_ortu', $pelanggaran->sudah_dihubungi_ortu) ? 'style=display:none;' : ''); ?>>
                        <label for="respon_ortu" class="block text-sm font-medium text-gray-700 mb-2">
                            Respon Orang Tua
                        </label>
                        <textarea name="respon_ortu" id="respon_ortu" rows="3"
                                  placeholder="Jelaskan respon orang tua terhadap pelanggaran anaknya..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 resize-none <?php $__errorArgs = ['respon_ortu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('respon_ortu', $pelanggaran->respon_ortu)); ?></textarea>
                        <?php $__errorArgs = ['respon_ortu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-yellow-600 text-white font-medium rounded-lg hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Update Pelanggaran
                </button>
                <a href="<?php echo e(route('kesiswaan.pelanggaran.show', $pelanggaran)); ?>" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                    <i class="fas fa-eye mr-2"></i>
                    Lihat Detail
                </a>
                <a href="<?php echo e(route('kesiswaan.pelanggaran.index')); ?>" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-fill sanksi berdasarkan jenis pelanggaran (hanya jika kosong)
    const jenisPelanggaranSelect = document.getElementById('jenis_pelanggaran_id');
    const sanksiTextarea = document.getElementById('sanksi_diberikan');
    
    jenisPelanggaranSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.dataset.sanksi && sanksiTextarea.value.trim() === '') {
            sanksiTextarea.value = selectedOption.dataset.sanksi;
        }
    });

    // Toggle respon orang tua
    const hubungiOrtuCheckbox = document.getElementById('sudah_dihubungi_ortu');
    const responOrtuContainer = document.getElementById('respon_ortu_container');
    
    hubungiOrtuCheckbox.addEventListener('change', function() {
        if (this.checked) {
            responOrtuContainer.style.display = 'block';
        } else {
            responOrtuContainer.style.display = 'none';
            document.getElementById('respon_ortu').value = '';
        }
    });

    // Set minimum date for tanggal selesai sanksi
    const tanggalPelanggaranInput = document.getElementById('tanggal_pelanggaran');
    const tanggalSelesaiSanksiInput = document.getElementById('tanggal_selesai_sanksi');
    
    tanggalPelanggaranInput.addEventListener('change', function() {
        tanggalSelesaiSanksiInput.min = this.value;
    });

    // Set initial min date
    if (tanggalPelanggaranInput.value) {
        tanggalSelesaiSanksiInput.min = tanggalPelanggaranInput.value;
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.kesiswaan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\website-smk3\resources\views\kesiswaan\pelanggaran\edit.blade.php ENDPATH**/ ?>