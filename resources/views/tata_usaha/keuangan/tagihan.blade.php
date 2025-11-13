@extends('layouts.tata_usaha')

@section('page-title', 'Manajemen Tagihan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                <i class="fas fa-file-invoice text-green-600 mr-3"></i>
                Manajemen Tagihan
            </h1>
            <p class="text-gray-600 mt-1">Kelola tagihan siswa dan monitoring pembayaran</p>
        </div>
        
        <div class="mt-4 md:mt-0 flex space-x-3">
            <button class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200 shadow-sm">
                <i class="fas fa-plus mr-2"></i>
                Buat Tagihan Baru
            </button>
            <button class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200">
                <i class="fas fa-download mr-2"></i>
                Export Data
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-xl text-white shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-blue-100">Total Tagihan</h3>
                    <p class="text-2xl font-bold mt-1">{{ $tagihan->total() ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-400/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-invoice text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 rounded-xl text-white shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-green-100">Sudah Dibayar</h3>
                    <p class="text-2xl font-bold mt-1">{{ $tagihan->where('status_pembayaran', 'lunas')->count() ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-green-400/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 p-6 rounded-xl text-white shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-yellow-100">Belum Dibayar</h3>
                    <p class="text-2xl font-bold mt-1">{{ $tagihan->where('status_pembayaran', 'belum_bayar')->count() ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-400/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-red-500 to-red-600 p-6 rounded-xl text-white shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-red-100">Terlambat</h3>
                    <p class="text-2xl font-bold mt-1">{{ $tagihan->where('status_pembayaran', 'terlambat')->count() ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-red-400/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Tagihan</label>
                <div class="relative">
                    <input type="text" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Nama siswa, NIS, atau tagihan...">
                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-400"></i>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status Pembayaran</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <option value="">Semua Status</option>
                    <option value="lunas">Lunas</option>
                    <option value="belum_bayar">Belum Bayar</option>
                    <option value="terlambat">Terlambat</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <option value="">Semua Kelas</option>
                    <option value="X TKR 1">X TKR 1</option>
                    <option value="X TKR 2">X TKR 2</option>
                    <option value="XI TKR 1">XI TKR 1</option>
                    <option value="XII TKR 1">XII TKR 1</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Periode</label>
                <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <option value="">Semua Periode</option>
                    <option value="2024-09">September 2024</option>
                    <option value="2024-10">Oktober 2024</option>
                    <option value="2024-11">November 2024</option>
                </select>
            </div>
        </div>
        
        <div class="mt-4 flex justify-end space-x-2">
            <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors duration-200">
                <i class="fas fa-redo mr-2"></i>
                Reset Filter
            </button>
            <button class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
                <i class="fas fa-search mr-2"></i>
                Cari Data
            </button>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Daftar Tagihan</h2>
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <span>Menampilkan {{ $tagihan->firstItem() ?? 0 }} - {{ $tagihan->lastItem() ?? 0 }} dari {{ $tagihan->total() ?? 0 }} data</span>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tagihan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tagihan as $index => $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ ($tagihan->currentPage() - 1) * $tagihan->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-medium">
                                        {{ substr($item->siswa->nama ?? 'S', 0, 1) }}
                                    </span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->siswa->nama ?? 'Nama Siswa' }}</div>
                                    <div class="text-sm text-gray-500">{{ $item->siswa->nis ?? '12345678' }} • {{ $item->kelas->nama_kelas ?? 'X TKR 1' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $item->nama_tagihan ?? 'SPP Bulan September' }}</div>
                            <div class="text-sm text-gray-500">{{ $item->periode ?? '2024-09' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                            Rp {{ number_format($item->nominal ?? 350000, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo ?? now()->addDays(30))->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $status = $item->status_pembayaran ?? 'belum_bayar';
                                $statusClass = [
                                    'lunas' => 'bg-green-100 text-green-800 border-green-200',
                                    'belum_bayar' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    'terlambat' => 'bg-red-100 text-red-800 border-red-200'
                                ][$status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                
                                $statusText = [
                                    'lunas' => 'Lunas',
                                    'belum_bayar' => 'Belum Bayar',
                                    'terlambat' => 'Terlambat'
                                ][$status] ?? 'Unknown';
                                
                                $statusIcon = [
                                    'lunas' => 'fas fa-check-circle',
                                    'belum_bayar' => 'fas fa-clock',
                                    'terlambat' => 'fas fa-exclamation-triangle'
                                ][$status] ?? 'fas fa-question';
                            @endphp
                            
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $statusClass }}">
                                <i class="{{ $statusIcon }} mr-1"></i>
                                {{ $statusText }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <button class="text-green-600 hover:text-green-800 p-1.5 rounded-lg hover:bg-green-50 transition-colors" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="text-blue-600 hover:text-blue-800 p-1.5 rounded-lg hover:bg-blue-50 transition-colors" title="Edit Tagihan">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-purple-600 hover:text-purple-800 p-1.5 rounded-lg hover:bg-purple-50 transition-colors" title="Cetak">
                                    <i class="fas fa-print"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-800 p-1.5 rounded-lg hover:bg-red-50 transition-colors" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-file-invoice text-2xl text-gray-400"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada data tagihan</h3>
                                <p class="text-gray-500 mb-4">Mulai dengan membuat tagihan baru untuk siswa</p>
                                <button class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors duration-200">
                                    <i class="fas fa-plus mr-2"></i>
                                    Buat Tagihan Pertama
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($tagihan->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $tagihan->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    // Auto refresh untuk status realtime
    setInterval(function() {
        // Update clock atau status jika diperlukan
    }, 30000);

    // Filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const filterInputs = document.querySelectorAll('select, input[type="text"]');
        
        filterInputs.forEach(input => {
            input.addEventListener('change', function() {
                // Implement filter logic here
                console.log('Filter changed:', this.value);
            });
        });
    });
</script>
@endpush
