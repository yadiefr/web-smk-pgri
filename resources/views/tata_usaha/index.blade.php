@extends('layouts.tata_usaha')

@section('page-header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard Tata Usaha</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Selamat datang, {{ auth()->user()->name }}. Berikut adalah ringkasan data terkini.</p>
        </div>
        <div class="flex items-center space-x-3">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                <div class="font-medium">{{ \Carbon\Carbon::now()->format('l, d F Y') }}</div>
                <div class="text-xs">{{ \Carbon\Carbon::now()->format('H:i') }} WIB</div>
            </div>
            <div class="h-8 w-8 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-user-tie text-white text-sm"></i>
            </div>
        </div>
    </div>
@endsection

@section('content')
<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Input Pembayaran -->
    <a href="#" class="group block">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 rounded-xl shadow-sm p-6 transition-all duration-300 transform hover:scale-105">
            <div class="flex items-center justify-between text-white">
                <div class="flex items-center">
                    <div class="p-3 bg-white/20 rounded-xl">
                        <i class="fas fa-credit-card text-2xl"></i>
                    </div>
                </div>
                <i class="fas fa-arrow-right opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
            </div>
            <div class="mt-4 text-white">
                <h3 class="text-lg font-semibold">Input Pembayaran</h3>
                <p class="text-blue-100 text-sm mt-1">Catat pembayaran siswa baru</p>
            </div>
        </div>
    </a>

    <!-- Data Siswa -->
    <a href="#" class="group block">
        <div class="bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 rounded-xl shadow-sm p-6 transition-all duration-300 transform hover:scale-105">
            <div class="flex items-center justify-between text-white">
                <div class="flex items-center">
                    <div class="p-3 bg-white/20 rounded-xl">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                </div>
                <i class="fas fa-arrow-right opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
            </div>
            <div class="mt-4 text-white">
                <h3 class="text-lg font-semibold">Data Siswa</h3>
                <p class="text-green-100 text-sm mt-1">Kelola informasi siswa</p>
            </div>
        </div>
    </a>

    <!-- Laporan Keuangan -->
    <a href="{{ route('tata-usaha.laporan') }}" class="group block">
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 rounded-xl shadow-sm p-6 transition-all duration-300 transform hover:scale-105">
            <div class="flex items-center justify-between text-white">
                <div class="flex items-center">
                    <div class="p-3 bg-white/20 rounded-xl">
                        <i class="fas fa-chart-bar text-2xl"></i>
                    </div>
                </div>
                <i class="fas fa-arrow-right opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
            </div>
            <div class="mt-4 text-white">
                <h3 class="text-lg font-semibold">Laporan</h3>
                <p class="text-purple-100 text-sm mt-1">Analisis data keuangan</p>
            </div>
        </div>
    </a>

    <!-- Administrasi -->
    <a href="#" class="group block">
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 rounded-xl shadow-sm p-6 transition-all duration-300 transform hover:scale-105">
            <div class="flex items-center justify-between text-white">
                <div class="flex items-center">
                    <div class="p-3 bg-white/20 rounded-xl">
                        <i class="fas fa-folder-open text-2xl"></i>
                    </div>
                </div>
                <i class="fas fa-arrow-right opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
            </div>
            <div class="mt-4 text-white">
                <h3 class="text-lg font-semibold">Administrasi</h3>
                <p class="text-orange-100 text-sm mt-1">Kelola dokumen sekolah</p>
            </div>
        </div>
    </a>
</div>

<!-- Dashboard Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Recent Activities -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg mr-3">
                    <i class="fas fa-history text-indigo-600 dark:text-indigo-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Aktivitas Terbaru</h3>
            </div>
            <button class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300">
                Lihat Semua
            </button>
        </div>
        
        <div class="space-y-4">
            <!-- Activity Item -->
            <div class="flex items-start space-x-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <div class="flex-shrink-0 w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-green-600 dark:text-green-400 text-xs"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Pembayaran SPP berhasil</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Ahmad Rizki - Kelas XII RPL 1 - Rp 500.000</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500">2 menit yang lalu</p>
                </div>
            </div>

            <div class="flex items-start space-x-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <div class="flex-shrink-0 w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-plus text-blue-600 dark:text-blue-400 text-xs"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Siswa baru terdaftar</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Siti Nurhaliza - Kelas X TKJ 2</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500">15 menit yang lalu</p>
                </div>
            </div>

            <div class="flex items-start space-x-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <div class="flex-shrink-0 w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                    <i class="fas fa-file-alt text-purple-600 dark:text-purple-400 text-xs"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Dokumen diupdate</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Laporan keuangan bulan September</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500">1 jam yang lalu</p>
                </div>
            </div>

            <div class="flex items-start space-x-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <div class="flex-shrink-0 w-8 h-8 bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-orange-600 dark:text-orange-400 text-xs"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Tunggakan perlu ditagih</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">5 siswa memiliki tunggakan lebih dari 3 bulan</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500">2 jam yang lalu</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Payment Chart -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg mr-3">
                    <i class="fas fa-chart-line text-green-600 dark:text-green-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Trend Pembayaran ({{ date('Y') }})</h3>
            </div>
        </div>
        <div class="relative h-64">
            <canvas id="monthlyPaymentChart"></canvas>
        </div>
    </div>
</div>

<!-- Recent Transactions & Outstanding Students -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Transactions -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg mr-3">
                    <i class="fas fa-receipt text-green-600 dark:text-green-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Transaksi Terbaru</h3>
            </div>
            <a href="#" class="text-sm text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300">
                Lihat Semua
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Siswa</th>
                        <th class="px-2 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($transaksiTerbaru as $transaksi)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                        <td class="px-2 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M') }}
                        </td>
                        <td class="px-2 py-3 text-sm">
                            <div class="font-medium text-gray-900 dark:text-gray-100">{{ $transaksi->siswa->nama_lengkap ?? 'Tidak ada data' }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $transaksi->keterangan }}</div>
                        </td>
                        <td class="px-2 py-3 whitespace-nowrap text-sm text-right">
                            <span class="font-semibold text-green-600 dark:text-green-400">Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-2 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                            <i class="fas fa-receipt text-2xl text-gray-300 dark:text-gray-600 mb-2 block"></i>
                            Tidak ada transaksi terbaru
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Outstanding Students -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 dark:bg-red-900/30 rounded-lg mr-3">
                    <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tunggakan Terbesar</h3>
            </div>
            <a href="#" class="text-sm text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300">
                Lihat Semua
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Siswa</th>
                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kelas</th>
                        <th class="px-2 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tunggakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($siswaWithTunggakan as $siswa)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                        <td class="px-2 py-3 text-sm">
                            <div class="font-medium text-gray-900 dark:text-gray-100">{{ $siswa->nama_lengkap }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $siswa->nis }}</div>
                        </td>
                        <td class="px-2 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            {{ $siswa->kelas->nama_kelas ?? 'Tidak ada kelas' }}
                        </td>
                        <td class="px-2 py-3 whitespace-nowrap text-sm text-right">
                            <span class="font-semibold text-red-600 dark:text-red-400">Rp {{ number_format($siswa->tunggakan, 0, ',', '.') }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-2 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                            <i class="fas fa-smile text-2xl text-green-300 dark:text-green-600 mb-2 block"></i>
                            Semua siswa sudah lunas!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data grafik dari controller
    const monthlyData = {
        labels: @json($dataBulan),
        datasets: [{
            label: 'Total Pembayaran (Rp)',
            data: @json($dataJumlah),
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            borderColor: 'rgb(16, 185, 129)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    };

    // Konfigurasi grafik
    const config = {
        type: 'line',
        data: monthlyData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        }
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += 'Rp ' + context.raw.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                            return label;
                        }
                    }
                }
            }
        }
    };

    // Membuat grafik
    const ctx = document.getElementById('monthlyPaymentChart').getContext('2d');
    new Chart(ctx, config);
});
</script>
@endpush
