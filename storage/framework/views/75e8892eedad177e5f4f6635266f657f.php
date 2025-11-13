

<?php $__env->startSection('page-header'); ?>
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Laporan Keuangan</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Analisis dan laporan keuangan sekolah</p>
        </div>
        <div class="flex items-center space-x-3">
            <div class="flex items-center bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg">
                <button class="px-4 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 border-r border-gray-300 dark:border-gray-600 rounded-l-lg">
                    Harian
                </button>
                <button class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 border-r border-gray-300 dark:border-gray-600">
                    Bulanan
                </button>
                <button class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 rounded-r-lg">
                    Tahunan
                </button>
            </div>
            <button class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
                <i class="fas fa-download mr-2"></i>
                Export
            </button>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Total Pemasukan</p>
                <p class="text-2xl font-bold">Rp 125.500.000</p>
                <div class="flex items-center mt-2">
                    <i class="fas fa-arrow-up text-green-300 mr-1"></i>
                    <span class="text-green-300 text-sm">+12.5%</span>
                    <span class="text-blue-100 text-sm ml-2">vs bulan lalu</span>
                </div>
            </div>
            <div class="p-3 bg-blue-400 rounded-xl">
                <i class="fas fa-arrow-trend-up text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium">Total Pengeluaran</p>
                <p class="text-2xl font-bold">Rp 45.200.000</p>
                <div class="flex items-center mt-2">
                    <i class="fas fa-arrow-down text-red-300 mr-1"></i>
                    <span class="text-red-300 text-sm">-5.2%</span>
                    <span class="text-green-100 text-sm ml-2">vs bulan lalu</span>
                </div>
            </div>
            <div class="p-3 bg-green-400 rounded-xl">
                <i class="fas fa-arrow-trend-down text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm font-medium">Saldo Bersih</p>
                <p class="text-2xl font-bold">Rp 80.300.000</p>
                <div class="flex items-center mt-2">
                    <i class="fas fa-arrow-up text-green-300 mr-1"></i>
                    <span class="text-green-300 text-sm">+25.8%</span>
                    <span class="text-purple-100 text-sm ml-2">vs bulan lalu</span>
                </div>
            </div>
            <div class="p-3 bg-purple-400 rounded-xl">
                <i class="fas fa-wallet text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-orange-100 text-sm font-medium">Tunggakan</p>
                <p class="text-2xl font-bold">Rp 15.800.000</p>
                <div class="flex items-center mt-2">
                    <i class="fas fa-arrow-down text-green-300 mr-1"></i>
                    <span class="text-green-300 text-sm">-8.3%</span>
                    <span class="text-orange-100 text-sm ml-2">vs bulan lalu</span>
                </div>
            </div>
            <div class="p-3 bg-orange-400 rounded-xl">
                <i class="fas fa-exclamation-triangle text-xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Cash Flow Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Grafik Arus Kas</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Pemasukan vs Pengeluaran 12 bulan terakhir</p>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">Pemasukan</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">Pengeluaran</span>
                    </div>
                </div>
            </div>
            
            <div class="h-80">
                <canvas id="cashFlowChart"></canvas>
            </div>
        </div>

        <!-- Transaction Details -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Transaksi Terbaru</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Daftar transaksi dalam 30 hari terakhir</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button class="px-3 py-2 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600">
                            <i class="fas fa-filter mr-1"></i>
                            Filter
                        </button>
                        <button class="px-3 py-2 text-sm bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-900/50">
                            <i class="fas fa-download mr-1"></i>
                            Export
                        </button>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                15 Sep 2024
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Pembayaran SPP - Ahmad Rizki</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">XII RPL 1</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                                    SPP
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-green-600 dark:text-green-400">
                                +Rp 500.000
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                    Selesai
                                </span>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                14 Sep 2024
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Pembelian Alat Tulis Kantor</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Toko ATK Jaya</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">
                                    Operasional
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-red-600 dark:text-red-400">
                                -Rp 750.000
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                    Selesai
                                </span>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                13 Sep 2024
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Pembayaran Seragam - Siti Nur</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">XI AKL 2</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300">
                                    Seragam
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-green-600 dark:text-green-400">
                                +Rp 300.000
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                    Selesai
                                </span>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                12 Sep 2024
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Gaji Guru September</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Transfer Bank</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-300">
                                    Gaji
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-red-600 dark:text-red-400">
                                -Rp 25.000.000
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300">
                                    Proses
                                </span>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                11 Sep 2024
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Pembayaran SPP - Budi Santoso</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">X TKJ 1</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                                    SPP
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-green-600 dark:text-green-400">
                                +Rp 500.000
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                    Selesai
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        Menampilkan 5 dari 248 transaksi
                    </div>
                    <div class="flex items-center space-x-2">
                        <button class="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded">
                            Previous
                        </button>
                        <div class="flex items-center space-x-1">
                            <button class="px-3 py-1 text-sm bg-blue-600 text-white rounded">1</button>
                            <button class="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded">2</button>
                            <button class="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded">3</button>
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
        <!-- Payment Methods -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center mb-4">
                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg mr-3">
                    <i class="fas fa-credit-card text-blue-600 dark:text-blue-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Metode Pembayaran</h3>
            </div>
            
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Tunai</span>
                    </div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">65%</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Transfer</span>
                    </div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">25%</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-purple-500 rounded-full mr-3"></div>
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-100">QRIS</span>
                    </div>
                    <span class="text-sm text-gray-600 dark:text-gray-400">10%</span>
                </div>
            </div>
        </div>

        <!-- Top Paying Classes -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center mb-4">
                <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg mr-3">
                    <i class="fas fa-trophy text-green-600 dark:text-green-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Kelas Terbaik</h3>
            </div>
            
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 rounded-lg border border-yellow-200 dark:border-yellow-800">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-crown text-white text-sm"></i>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">XII RPL 1</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">100% terbayar</div>
                        </div>
                    </div>
                    <div class="text-sm font-semibold text-green-600 dark:text-green-400">Rp 15M</div>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-400 rounded-full flex items-center justify-center mr-3 text-white text-sm font-bold">2</div>
                        <div>
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">XI AKL 2</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">95% terbayar</div>
                        </div>
                    </div>
                    <div class="text-sm font-semibold text-green-600 dark:text-green-400">Rp 13.5M</div>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-orange-400 rounded-full flex items-center justify-center mr-3 text-white text-sm font-bold">3</div>
                        <div>
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">X TKJ 1</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">92% terbayar</div>
                        </div>
                    </div>
                    <div class="text-sm font-semibold text-green-600 dark:text-green-400">Rp 12.8M</div>
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
                <a href="<?php echo e(route('tata-usaha.keuangan.pembayaran')); ?>" class="block w-full px-4 py-3 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors text-center">
                    <i class="fas fa-plus mr-2"></i>
                    Input Pembayaran
                </a>
                
                <button class="w-full px-4 py-3 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                    <i class="fas fa-file-pdf mr-2"></i>
                    Export PDF
                </button>
                
                <button class="w-full px-4 py-3 bg-orange-50 dark:bg-orange-900/20 text-orange-700 dark:text-orange-300 rounded-lg hover:bg-orange-100 dark:hover:bg-orange-900/30 transition-colors">
                    <i class="fas fa-bell mr-2"></i>
                    Kirim Reminder
                </button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cash Flow Chart
    const ctx = document.getElementById('cashFlowChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Pemasukan',
                data: [85, 92, 78, 95, 102, 88, 94, 115, 125, 108, 98, 112],
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Pengeluaran',
                data: [45, 52, 48, 55, 62, 48, 54, 65, 45, 58, 48, 62],
                borderColor: 'rgb(239, 68, 68)',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': Rp ' + context.parsed.y + 'M';
                        }
                    }
                }
            },
            scales: {
                x: {
                    display: true,
                    grid: {
                        display: false
                    }
                },
                y: {
                    display: true,
                    grid: {
                        color: 'rgba(156, 163, 175, 0.1)'
                    },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value + 'M';
                        }
                    }
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            }
        }
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.tata_usaha', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\website-smk3\resources\views\tata_usaha\keuangan\laporan.blade.php ENDPATH**/ ?>