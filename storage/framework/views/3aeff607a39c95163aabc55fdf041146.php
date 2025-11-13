

<?php $__env->startSection('page-header'); ?>
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manajemen Inventaris</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Kelola inventaris dan aset sekolah</p>
        </div>
        <div class="flex items-center space-x-3">
            <div class="flex items-center bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden">
                <input type="text" placeholder="Cari inventaris..." 
                       class="px-4 py-2 border-0 focus:ring-0 bg-transparent text-sm text-gray-700 dark:text-gray-300 placeholder-gray-500 dark:placeholder-gray-400 w-64">
                <button class="px-4 py-2 bg-gray-50 dark:bg-gray-700 border-l border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                    <i class="fas fa-search text-gray-500 dark:text-gray-400"></i>
                </button>
            </div>
            <button class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Tambah Item
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
                <p class="text-blue-100 text-sm font-medium">Total Item</p>
                <p class="text-2xl font-bold">1,245</p>
                <div class="flex items-center mt-2">
                    <i class="fas fa-arrow-up text-green-300 mr-1"></i>
                    <span class="text-green-300 text-sm">+25</span>
                    <span class="text-blue-100 text-sm ml-2">bulan ini</span>
                </div>
            </div>
            <div class="p-3 bg-blue-400 rounded-xl">
                <i class="fas fa-boxes text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium">Kondisi Baik</p>
                <p class="text-2xl font-bold">1,089</p>
                <div class="flex items-center mt-2">
                    <span class="text-green-100 text-sm">87.5% dari total</span>
                </div>
            </div>
            <div class="p-3 bg-green-400 rounded-xl">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-yellow-100 text-sm font-medium">Perlu Perbaikan</p>
                <p class="text-2xl font-bold">89</p>
                <div class="flex items-center mt-2">
                    <span class="text-yellow-100 text-sm">7.1% dari total</span>
                </div>
            </div>
            <div class="p-3 bg-yellow-400 rounded-xl">
                <i class="fas fa-exclamation-triangle text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-red-100 text-sm font-medium">Rusak</p>
                <p class="text-2xl font-bold">67</p>
                <div class="flex items-center mt-2">
                    <span class="text-red-100 text-sm">5.4% dari total</span>
                </div>
            </div>
            <div class="p-3 bg-red-400 rounded-xl">
                <i class="fas fa-times-circle text-xl"></i>
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
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Kategori:</label>
                    <select class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="">Semua</option>
                        <option value="elektronik">Elektronik</option>
                        <option value="furniture">Furniture</option>
                        <option value="kendaraan">Kendaraan</option>
                        <option value="peralatan">Peralatan</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
                
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Kondisi:</label>
                    <select class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="">Semua</option>
                        <option value="baik">Baik</option>
                        <option value="perbaikan">Perlu Perbaikan</option>
                        <option value="rusak">Rusak</option>
                    </select>
                </div>
                
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Lokasi:</label>
                    <select class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="">Semua</option>
                        <option value="lab-komputer">Lab Komputer</option>
                        <option value="kantor">Kantor</option>
                        <option value="kelas">Kelas</option>
                        <option value="perpustakaan">Perpustakaan</option>
                        <option value="gudang">Gudang</option>
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

        <!-- Inventory Items -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Inventaris</h2>
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kode/Nama Item</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Lokasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kondisi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal Beli</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nilai</th>
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
                                    <div class="h-10 w-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-laptop text-blue-600 dark:text-blue-400"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">LAPTOP-001</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Laptop Dell Inspiron 15</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                                    Elektronik
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                Lab Komputer 1
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                    Baik
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                15 Jan 2023
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900 dark:text-gray-100">
                                Rp 8.500.000
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
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
                                    <div class="h-10 w-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-chair text-green-600 dark:text-green-400"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">KURSI-025</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Kursi Kantor Ergonomis</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                    Furniture
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                Ruang Guru
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300">
                                    Perlu Perbaikan
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                05 Mar 2022
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900 dark:text-gray-100">
                                Rp 1.200.000
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
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
                                    <div class="h-10 w-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-tv text-purple-600 dark:text-purple-400"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">PROJ-008</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Projector Epson EB-X41</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300">
                                    Elektronik
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                Kelas XII RPL 1
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                    Baik
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                20 Aug 2023
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900 dark:text-gray-100">
                                Rp 4.500.000
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
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
                                    <div class="h-10 w-10 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-print text-red-600 dark:text-red-400"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">PRINT-012</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Printer Canon Pixma G3010</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">
                                    Elektronik
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                Kantor TU
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">
                                    Rusak
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                10 Jun 2021
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900 dark:text-gray-100">
                                Rp 2.800.000
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
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
                        Menampilkan 1-10 dari 1,245 item
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
                            <button class="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded">125</button>
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
        <!-- Quick Stats -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center mb-4">
                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg mr-3">
                    <i class="fas fa-chart-pie text-blue-600 dark:text-blue-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Kategori Item</h3>
            </div>
            
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Elektronik</span>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">456</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Furniture</span>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">324</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-purple-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Kendaraan</span>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">89</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-orange-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Peralatan</span>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">245</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-gray-500 rounded-full mr-3"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Lainnya</span>
                    </div>
                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">131</span>
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
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Item baru ditambahkan</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Laptop Dell Inspiron 15</div>
                        <div class="text-xs text-gray-400 dark:text-gray-500">2 jam lalu</div>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="h-2 w-2 bg-yellow-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                    <div class="flex-1">
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Status diperbarui</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">KURSI-025 butuh perbaikan</div>
                        <div class="text-xs text-gray-400 dark:text-gray-500">5 jam lalu</div>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="h-2 w-2 bg-green-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                    <div class="flex-1">
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Perbaikan selesai</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">AC-005 sudah diperbaiki</div>
                        <div class="text-xs text-gray-400 dark:text-gray-500">1 hari lalu</div>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="h-2 w-2 bg-red-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                    <div class="flex-1">
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Item dihapus</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">MEJA-089 sudah tidak terpakai</div>
                        <div class="text-xs text-gray-400 dark:text-gray-500">2 hari lalu</div>
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
                    Tambah Item Baru
                </button>
                
                <button class="w-full px-4 py-3 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                    <i class="fas fa-file-import mr-2"></i>
                    Import Data
                </button>
                
                <button class="w-full px-4 py-3 bg-orange-50 dark:bg-orange-900/20 text-orange-700 dark:text-orange-300 rounded-lg hover:bg-orange-100 dark:hover:bg-orange-900/30 transition-colors">
                    <i class="fas fa-qrcode mr-2"></i>
                    Generate QR Code
                </button>
                
                <button class="w-full px-4 py-3 bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-300 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-colors">
                    <i class="fas fa-wrench mr-2"></i>
                    Jadwal Maintenance
                </button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tata_usaha', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\website-smk3\resources\views\tata_usaha\inventaris\index.blade.php ENDPATH**/ ?>