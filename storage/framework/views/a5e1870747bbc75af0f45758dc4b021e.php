

<?php $__env->startSection('page-header'); ?>
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Data Guru</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Kelola data guru dan tenaga pengajar</p>
        </div>
        <div class="flex items-center space-x-3">
            <div class="flex items-center bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                <input type="text" placeholder="Cari guru..." 
                       class="px-4 py-2 border-0 focus:ring-0 bg-transparent text-sm text-gray-700 dark:text-gray-300 placeholder-gray-500 dark:placeholder-gray-400 w-64">
                <button class="px-4 py-2 bg-gray-50 dark:bg-gray-700 border-l border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                    <i class="fas fa-search text-gray-500 dark:text-gray-400"></i>
                </button>
            </div>
            <button class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                <i class="fas fa-file-import mr-2"></i>
                Import
            </button>
            <button class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Tambah Guru
            </button>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Total Guru</p>
                <p class="text-2xl font-bold">48</p>
                <div class="flex items-center mt-2">
                    <i class="fas fa-arrow-up text-green-300 mr-1"></i>
                    <span class="text-green-300 text-sm">+2</span>
                    <span class="text-blue-100 text-sm ml-2">bulan ini</span>
                </div>
            </div>
            <div class="p-3 bg-blue-400 rounded-xl">
                <i class="fas fa-chalkboard-teacher text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium">Guru Aktif</p>
                <p class="text-2xl font-bold">45</p>
                <div class="flex items-center mt-2">
                    <span class="text-green-100 text-sm">93.8% dari total</span>
                </div>
            </div>
            <div class="p-3 bg-green-400 rounded-xl">
                <i class="fas fa-user-check text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm font-medium">Guru Tetap</p>
                <p class="text-2xl font-bold">32</p>
                <div class="flex items-center mt-2">
                    <span class="text-purple-100 text-sm">66.7% dari total</span>
                </div>
            </div>
            <div class="p-3 bg-purple-400 rounded-xl">
                <i class="fas fa-id-badge text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-orange-100 text-sm font-medium">Guru Honorer</p>
                <p class="text-2xl font-bold">16</p>
                <div class="flex items-center mt-2">
                    <span class="text-orange-100 text-sm">33.3% dari total</span>
                </div>
            </div>
            <div class="p-3 bg-orange-400 rounded-xl">
                <i class="fas fa-user-tie text-xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-3">
        <!-- Filter Bar -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Status:</label>
                    <select class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="">Semua</option>
                        <option value="aktif">Aktif</option>
                        <option value="non-aktif">Non-Aktif</option>
                        <option value="cuti">Cuti</option>
                    </select>
                </div>
                
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Jenis:</label>
                    <select class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="">Semua</option>
                        <option value="tetap">Tetap</option>
                        <option value="honorer">Honorer</option>
                        <option value="kontrak">Kontrak</option>
                    </select>
                </div>
                
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Mata Pelajaran:</label>
                    <select class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="">Semua</option>
                        <option value="matematika">Matematika</option>
                        <option value="bahasa-indonesia">Bahasa Indonesia</option>
                        <option value="bahasa-inggris">Bahasa Inggris</option>
                        <option value="produktif">Produktif</option>
                    </select>
                </div>
                
                <div class="flex-1"></div>
                
                <button class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                    <i class="fas fa-filter mr-2"></i>Reset Filter
                </button>
                
                <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-download mr-2"></i>Export
                </button>
            </div>
        </div>

        <!-- Teachers List -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Guru</h2>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Tampilkan per halaman:</span>
                        <select class="px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Guru</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">NIP</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Mata Pelajaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jenis</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kontak</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-4">
                                        <span class="text-white font-medium text-sm">DR</span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Drs. Rahman, M.Pd</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Kepala Sekolah</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                196508121990031003
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-100">Kepemimpinan</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Manajemen</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                    Aktif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                                    PNS
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                <div>081234567890</div>
                                <div class="text-gray-500 dark:text-gray-400">rahman@smk3.sch.id</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300" title="Reset Password">
                                        <i class="fas fa-key"></i>
                                    </button>
                                    <button class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 bg-gradient-to-br from-green-500 to-teal-600 rounded-full flex items-center justify-center mr-4">
                                        <span class="text-white font-medium text-sm">SA</span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Siti Aminah, S.Kom</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Guru Produktif RPL</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                198503152010012001
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-100">RPL</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Pemrograman Web</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                    Aktif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300">
                                    Tetap
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                <div>081298765432</div>
                                <div class="text-gray-500 dark:text-gray-400">aminah@smk3.sch.id</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300" title="Reset Password">
                                        <i class="fas fa-key"></i>
                                    </button>
                                    <button class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-full flex items-center justify-center mr-4">
                                        <span class="text-white font-medium text-sm">BP</span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Budi Prasetyo, S.Pd</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Guru Matematika</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                198712102015031002
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-100">Matematika</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Aljabar, Geometri</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                    Aktif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-300">
                                    Honorer
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                <div>081387654321</div>
                                <div class="text-gray-500 dark:text-gray-400">budi@smk3.sch.id</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300" title="Reset Password">
                                        <i class="fas fa-key"></i>
                                    </button>
                                    <button class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 bg-gradient-to-br from-pink-500 to-purple-600 rounded-full flex items-center justify-center mr-4">
                                        <span class="text-white font-medium text-sm">DF</span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Dewi Fatimah, S.S</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Guru Bahasa Inggris</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                199001052018012001
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-100">Bahasa Inggris</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Conversation, Grammar</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300">
                                    Cuti
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-900/30 text-gray-800 dark:text-gray-300">
                                    Kontrak
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                <div>081456789012</div>
                                <div class="text-gray-500 dark:text-gray-400">dewi@smk3.sch.id</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300" title="Reset Password">
                                        <i class="fas fa-key"></i>
                                    </button>
                                    <button class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        Menampilkan 1-10 dari 48 guru
                    </div>
                    <div class="flex items-center space-x-2">
                        <button class="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded">
                            Previous
                        </button>
                        <div class="flex items-center space-x-1">
                            <button class="px-3 py-1 text-sm bg-blue-600 text-white rounded">1</button>
                            <button class="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded">2</button>
                            <button class="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded">3</button>
                            <span class="px-2 text-gray-500">...</span>
                            <button class="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded">5</button>
                        </div>
                        <button class="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Department Stats -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center mb-4">
                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg mr-3">
                    <i class="fas fa-building text-blue-600 dark:text-blue-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Jurusan</h3>
            </div>
            
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">RPL</span>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">12 guru</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">TKJ</span>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">10 guru</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-purple-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">AKL</span>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">8 guru</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-orange-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">UMUM</span>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">18 guru</span>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center mb-4">
                <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg mr-3">
                    <i class="fas fa-history text-green-600 dark:text-green-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Aktivitas Terbaru</h3>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="h-2 w-2 bg-blue-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                    <div class="flex-1">
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Data guru diperbarui</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Siti Aminah - profil lengkap</div>
                        <div class="text-xs text-gray-400 dark:text-gray-500">2 jam lalu</div>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="h-2 w-2 bg-green-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                    <div class="flex-1">
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Guru baru ditambahkan</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Ahmad Fauzi - Guru TKJ</div>
                        <div class="text-xs text-gray-400 dark:text-gray-500">1 hari lalu</div>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="h-2 w-2 bg-yellow-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                    <div class="flex-1">
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Status diubah</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Dewi Fatimah - Cuti melahirkan</div>
                        <div class="text-xs text-gray-400 dark:text-gray-500">3 hari lalu</div>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="h-2 w-2 bg-purple-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                    <div class="flex-1">
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Import data berhasil</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">25 data guru terupdate</div>
                        <div class="text-xs text-gray-400 dark:text-gray-500">1 minggu lalu</div>
                    </div>
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
                <button class="w-full px-4 py-3 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Guru Baru
                </button>
                
                <button class="w-full px-4 py-3 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                    <i class="fas fa-file-import mr-2"></i>
                    Import Data Excel
                </button>
                
                <button class="w-full px-4 py-3 bg-orange-50 dark:bg-orange-900/20 text-orange-700 dark:text-orange-300 rounded-lg hover:bg-orange-100 dark:hover:bg-orange-900/30 transition-colors">
                    <i class="fas fa-id-card mr-2"></i>
                    Generate ID Card
                </button>
                
                <button class="w-full px-4 py-3 bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-300 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-colors">
                    <i class="fas fa-chart-bar mr-2"></i>
                    Laporan Kehadiran
                </button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tata_usaha', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\website-smk3\resources\views\tata_usaha\guru\index.blade.php ENDPATH**/ ?>