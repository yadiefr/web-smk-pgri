

<?php $__env->startSection('page-header'); ?>
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Input Pembayaran</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Catat dan kelola pembayaran siswa</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="<?php echo e(route('tata-usaha.index')); ?>" class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200 border border-gray-300 dark:border-gray-600">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Payment Form -->
    <div class="lg:col-span-2">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center mb-6">
                <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-xl mr-4">
                    <i class="fas fa-credit-card text-green-600 dark:text-green-400 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Form Input Pembayaran</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Lengkapi data pembayaran siswa</p>
                </div>
            </div>

            <form class="space-y-6">
                <!-- Student Selection -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="siswa_search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Cari Siswa <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" id="siswa_search" name="siswa_search" 
                                   placeholder="Ketik nama siswa atau NIS..." 
                                   class="w-full px-4 py-3 pl-10 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:focus:ring-green-400 dark:focus:border-green-400 text-gray-900 dark:text-gray-100">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Minimal 3 karakter untuk pencarian</p>
                    </div>

                    <div>
                        <label for="kelas" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Kelas
                        </label>
                        <input type="text" id="kelas" name="kelas" readonly
                               class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100"
                               placeholder="Kelas akan terisi otomatis">
                    </div>
                </div>

                <!-- Student Info Display -->
                <div id="student-info" class="hidden bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="h-12 w-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-white text-lg"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-blue-900 dark:text-blue-100" id="student-name">-</div>
                            <div class="text-xs text-blue-600 dark:text-blue-300">
                                NIS: <span id="student-nis">-</span> | 
                                Kelas: <span id="student-class">-</span> |
                                Status: <span id="student-status">-</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="jenis_pembayaran" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Jenis Pembayaran <span class="text-red-500">*</span>
                        </label>
                        <select id="jenis_pembayaran" name="jenis_pembayaran" 
                                class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:focus:ring-green-400 dark:focus:border-green-400 text-gray-900 dark:text-gray-100">
                            <option value="">Pilih Jenis Pembayaran</option>
                            <option value="spp">SPP</option>
                            <option value="uang_pangkal">Uang Pangkal</option>
                            <option value="seragam">Seragam</option>
                            <option value="buku">Buku</option>
                            <option value="kegiatan">Kegiatan</option>
                            <option value="ujian">Ujian</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label for="periode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Periode
                        </label>
                        <input type="text" id="periode" name="periode" 
                               placeholder="Misal: September 2024"
                               class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:focus:ring-green-400 dark:focus:border-green-400 text-gray-900 dark:text-gray-100">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Jumlah Pembayaran <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" id="jumlah" name="jumlah" 
                                   placeholder="0"
                                   class="w-full px-4 py-3 pl-12 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:focus:ring-green-400 dark:focus:border-green-400 text-gray-900 dark:text-gray-100">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-400">Rp</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="tanggal_bayar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tanggal Pembayaran <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="tanggal_bayar" name="tanggal_bayar" 
                               value="<?php echo e(date('Y-m-d')); ?>"
                               class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:focus:ring-green-400 dark:focus:border-green-400 text-gray-900 dark:text-gray-100">
                    </div>
                </div>

                <div>
                    <label for="metode_pembayaran" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Metode Pembayaran <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <label class="flex items-center p-3 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <input type="radio" name="metode_pembayaran" value="tunai" class="text-green-600 focus:ring-green-500">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Tunai</span>
                        </label>
                        <label class="flex items-center p-3 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <input type="radio" name="metode_pembayaran" value="transfer" class="text-green-600 focus:ring-green-500">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Transfer</span>
                        </label>
                        <label class="flex items-center p-3 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <input type="radio" name="metode_pembayaran" value="kartu" class="text-green-600 focus:ring-green-500">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Kartu</span>
                        </label>
                        <label class="flex items-center p-3 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <input type="radio" name="metode_pembayaran" value="qris" class="text-green-600 focus:ring-green-500">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">QRIS</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label for="keterangan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Keterangan
                    </label>
                    <textarea id="keterangan" name="keterangan" rows="3" 
                              placeholder="Catatan tambahan..."
                              class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 dark:focus:ring-green-400 dark:focus:border-green-400 text-gray-900 dark:text-gray-100"></textarea>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="reset" class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                        <i class="fas fa-undo mr-2"></i>
                        Reset
                    </button>
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="space-y-6">
        <!-- Recent Payments -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center mb-4">
                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg mr-3">
                    <i class="fas fa-clock text-blue-600 dark:text-blue-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pembayaran Terbaru</h3>
            </div>
            
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div>
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Ahmad Rizki</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">SPP September</div>
                    </div>
                    <div class="text-sm font-medium text-green-600 dark:text-green-400">Rp 500.000</div>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div>
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Siti Nur</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Uang Seragam</div>
                    </div>
                    <div class="text-sm font-medium text-green-600 dark:text-green-400">Rp 300.000</div>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div>
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Budi Santoso</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">SPP September</div>
                    </div>
                    <div class="text-sm font-medium text-green-600 dark:text-green-400">Rp 500.000</div>
                </div>
            </div>
            
            <div class="mt-4">
                <a href="#" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">
                    Lihat semua pembayaran →
                </a>
            </div>
        </div>

        <!-- Payment Statistics -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center mb-4">
                <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg mr-3">
                    <i class="fas fa-chart-bar text-green-600 dark:text-green-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Statistik Hari Ini</h3>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600 dark:text-gray-400">Total Pembayaran</div>
                    <div class="text-lg font-semibold text-gray-900 dark:text-white">Rp 2.500.000</div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600 dark:text-gray-400">Jumlah Transaksi</div>
                    <div class="text-lg font-semibold text-gray-900 dark:text-white">12</div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600 dark:text-gray-400">Rata-rata</div>
                    <div class="text-lg font-semibold text-gray-900 dark:text-white">Rp 208.333</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center mb-4">
                <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg mr-3">
                    <i class="fas fa-bolt text-purple-600 dark:text-purple-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Aksi Cepat</h3>
            </div>
            
            <div class="space-y-3">
                <button class="w-full flex items-center justify-center px-4 py-3 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                    <i class="fas fa-receipt mr-2"></i>
                    Cetak Kwitansi
                </button>
                
                <button class="w-full flex items-center justify-center px-4 py-3 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
                    <i class="fas fa-file-excel mr-2"></i>
                    Export Excel
                </button>
                
                <button class="w-full flex items-center justify-center px-4 py-3 bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-300 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-colors">
                    <i class="fas fa-chart-line mr-2"></i>
                    Lihat Laporan
                </button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Format currency input
    const jumlahInput = document.getElementById('jumlah');
    jumlahInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^0-9]/g, '');
        if (value) {
            value = parseInt(value).toLocaleString('id-ID');
            e.target.value = value;
        }
    });

    // Student search simulation
    const siswaSearch = document.getElementById('siswa_search');
    const studentInfo = document.getElementById('student-info');
    
    siswaSearch.addEventListener('input', function(e) {
        if (e.target.value.length >= 3) {
            // Simulate student found
            setTimeout(() => {
                document.getElementById('student-name').textContent = 'Ahmad Rizki Pratama';
                document.getElementById('student-nis').textContent = '2024001';
                document.getElementById('student-class').textContent = 'XII RPL 1';
                document.getElementById('student-status').textContent = 'Aktif';
                document.getElementById('kelas').value = 'XII RPL 1';
                studentInfo.classList.remove('hidden');
            }, 500);
        } else {
            studentInfo.classList.add('hidden');
            document.getElementById('kelas').value = '';
        }
    });

    // Auto-fill amount based on payment type
    const jenisPembayaran = document.getElementById('jenis_pembayaran');
    jenisPembayaran.addEventListener('change', function(e) {
        const amounts = {
            'spp': '500000',
            'uang_pangkal': '2000000',
            'seragam': '300000',
            'buku': '150000',
            'kegiatan': '100000',
            'ujian': '200000'
        };
        
        if (amounts[e.target.value]) {
            const formattedAmount = parseInt(amounts[e.target.value]).toLocaleString('id-ID');
            jumlahInput.value = formattedAmount;
        }
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.tata_usaha', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\website-smk3\resources\views\tata_usaha\keuangan\pembayaran.blade.php ENDPATH**/ ?>