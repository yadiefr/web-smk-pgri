@extends('layouts.guru')

@section('title', 'Rekap Keterlambatan Siswa - ' . $kelas->nama_kelas)

@section('content')
<div class="p-6">
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-file-excel mr-2"></i>
                    Rekap Keterlambatan Siswa
                </h1>
                <p class="text-gray-600 mt-1">Rekap data keterlambatan siswa dengan export Excel - Kelas {{ $kelas->nama_kelas }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('guru.wali-kelas.keterlambatan.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
                <button type="button" 
                        onclick="showExportModal()"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                    <i class="fas fa-file-excel mr-2"></i>Export Excel
                </button>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-4">
        <div class="p-4">
            <form method="GET" action="{{ route('guru.wali-kelas.keterlambatan.rekap') }}" id="filterForm">
                <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label for="bulan_select" class="block text-xs font-medium text-gray-700 mb-1">Bulan</label>
                            <select class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500" 
                                    id="bulan_select" name="bulan_select" onchange="setBulanTahun()">
                                <option value="">Manual</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div>
                            <label for="tahun_select" class="block text-xs font-medium text-gray-700 mb-1">Tahun</label>
                            <select class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500" 
                                    id="tahun_select" name="tahun_select" onchange="setBulanTahun()">
                                <option value="">Manual</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="tanggal_mulai" class="block text-xs font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                        <input type="date" 
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500" 
                               id="tanggal_mulai" 
                               name="tanggal_mulai" 
                               value="{{ $tanggalMulai }}" 
                               required>
                    </div>
                    <div>
                        <label for="tanggal_akhir" class="block text-xs font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                        <input type="date" 
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-blue-500 focus:border-blue-500" 
                               id="tanggal_akhir" 
                               name="tanggal_akhir" 
                               value="{{ $tanggalAkhir }}" 
                               required>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 text-sm rounded transition-colors duration-200">
                            <i class="fas fa-filter mr-1"></i>Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($hasFilter)
        @if($rekapData->count() > 0)
        <!-- Rekap Per Kelas -->
        @if($rekapPerKelas->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Rekap Kelas {{ $kelas->nama_kelas }}</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Siswa</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Total Keterlambatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($rekapPerKelas as $namaKelas => $data)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-center text-gray-900">1</td>
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $namaKelas }}</td>
                                <td class="px-4 py-3 text-center text-gray-900">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        {{ $data['jumlah_siswa'] }} siswa
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center text-gray-900">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        {{ $data['total_keterlambatan'] }} kali
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- Detail Data Keterlambatan -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Detail Data Keterlambatan</h3>
                    <span class="text-sm text-gray-600">
                        Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d M Y') }}
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Terlambat</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alasan</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($rekapData as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-center text-gray-900">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 text-gray-900">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                </td>
                                <td class="px-4 py-3">
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $item->siswa->nama_lengkap }}</div>
                                        <div class="text-xs text-gray-500">{{ $item->siswa->nis }}</div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-900">{{ $item->jam_terlambat }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $item->alasan_terlambat ?? '-' }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if($item->status == 'belum_ditindak')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Belum Di Tindak
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Sudah Di Tindak
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @else
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
            <div class="text-center">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-search text-4xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada data ditemukan</h3>
                <p class="text-gray-600">Tidak ada data keterlambatan untuk periode yang dipilih.</p>
            </div>
        </div>
        @endif
    @else
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
        <div class="text-center">
            <div class="text-gray-400 mb-4">
                <i class="fas fa-calendar text-4xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Pilih Periode</h3>
            <p class="text-gray-600">Silakan pilih tanggal mulai dan tanggal akhir untuk melihat rekap data keterlambatan.</p>
        </div>
    </div>
    @endif
</div>

<!-- Modal Export Excel -->
<div id="exportModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Export Data ke Excel</h3>
                <button type="button" onclick="hideExportModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="exportForm" method="POST" action="{{ route('guru.wali-kelas.keterlambatan.export') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Bulan & Tahun atau Manual</label>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                    id="export_bulan_select" name="bulan_select" onchange="setExportBulanTahun()">
                                <option value="">Pilih Bulan</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                    id="export_tahun_select" name="tahun_select" onchange="setExportBulanTahun()">
                                <option value="">Pilih Tahun</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="export_tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                    <input type="date" 
                           id="export_tanggal_mulai" 
                           name="tanggal_mulai" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div class="mb-4">
                    <label for="export_tanggal_akhir" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                    <input type="date" 
                           id="export_tanggal_akhir" 
                           name="tanggal_akhir" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Pilihan Tipe Export -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Pilih Jenis Export</label>
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <input id="export_per_tanggal" 
                                   name="export_type" 
                                   value="per_tanggal" 
                                   type="radio" 
                                   checked
                                   class="mt-0.5 mr-3 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <div>
                                <label for="export_per_tanggal" class="text-sm font-medium text-gray-700 cursor-pointer">
                                    <i class="fas fa-calendar-alt text-green-500 mr-2"></i>Export Per Tanggal (Multi-Sheet)
                                </label>
                                <p class="text-xs text-gray-500 mt-1">Multi-sheet: Satu sheet untuk setiap tanggal + sheet rekap total</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <input id="export_periode" 
                                   name="export_type" 
                                   value="periode" 
                                   type="radio" 
                                   class="mt-0.5 mr-3 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <div>
                                <label for="export_periode" class="text-sm font-medium text-gray-700 cursor-pointer">
                                    <i class="fas fa-list-ul text-purple-500 mr-2"></i>Export Per Periode (Single-Sheet)
                                </label>
                                <p class="text-xs text-gray-500 mt-1">Single-sheet: Semua data keterlambatan dalam satu sheet dengan kolom tanggal</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <input id="export_rekap_total" 
                                   name="export_type" 
                                   value="rekap_total" 
                                   type="radio" 
                                   class="mt-0.5 mr-3 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            <div>
                                <label for="export_rekap_total" class="text-sm font-medium text-gray-700 cursor-pointer">
                                    <i class="fas fa-chart-bar text-orange-500 mr-2"></i>Export Rekap Total (Summary)
                                </label>
                                <p class="text-xs text-gray-500 mt-1">Summary: Hanya menampilkan total keterlambatan per siswa</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-3">
                    <button type="button" 
                            onclick="hideExportModal()"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg transition-colors duration-200">
                        Batal
                    </button>
                    <button type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                        <i class="fas fa-file-excel mr-2"></i>Export
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showExportModal() {
    // Set default tanggal jika ada filter yang aktif
    const bulanSelect = document.getElementById('bulan_select').value;
    const tahunSelect = document.getElementById('tahun_select').value;
    const tanggalMulai = document.getElementById('tanggal_mulai').value;
    const tanggalAkhir = document.getElementById('tanggal_akhir').value;
    
    // Jika user sudah pilih bulan dan tahun di filter utama
    if (bulanSelect && tahunSelect) {
        document.getElementById('export_bulan_select').value = bulanSelect;
        document.getElementById('export_tahun_select').value = tahunSelect;
        setExportBulanTahun(); // Otomatis set tanggal dari bulan & tahun
    } else {
        // Jika tidak ada bulan/tahun, gunakan tanggal manual
        if (tanggalMulai) {
            document.getElementById('export_tanggal_mulai').value = tanggalMulai;
        }
        if (tanggalAkhir) {
            document.getElementById('export_tanggal_akhir').value = tanggalAkhir;
        }
    }
    
    document.getElementById('exportModal').classList.remove('hidden');
}

function hideExportModal() {
    document.getElementById('exportModal').classList.add('hidden');
}

function setBulanTahun() {
    const bulanSelect = document.getElementById('bulan_select');
    const tahunSelect = document.getElementById('tahun_select');
    const bulan = bulanSelect.value;
    const tahun = tahunSelect.value;
    
    if (bulan === '' || tahun === '') {
        // Jika salah satu tidak dipilih, biarkan user isi tanggal manual
        return;
    }
    
    // Set tanggal mulai (tanggal 1 dari bulan tersebut)
    const tanggalMulai = `${tahun}-${bulan}-01`;
    document.getElementById('tanggal_mulai').value = tanggalMulai;
    
    // Set tanggal akhir (hari terakhir dari bulan tersebut)
    const lastDay = new Date(parseInt(tahun), parseInt(bulan), 0).getDate();
    const tanggalAkhir = `${tahun}-${bulan}-${lastDay.toString().padStart(2, '0')}`;
    document.getElementById('tanggal_akhir').value = tanggalAkhir;
}

function setExportBulanTahun() {
    const bulanSelect = document.getElementById('export_bulan_select');
    const tahunSelect = document.getElementById('export_tahun_select');
    const bulan = bulanSelect.value;
    const tahun = tahunSelect.value;
    
    if (bulan === '' || tahun === '') {
        // Jika salah satu tidak dipilih, set required ke tanggal manual
        document.getElementById('export_tanggal_mulai').setAttribute('required', '');
        document.getElementById('export_tanggal_akhir').setAttribute('required', '');
        return;
    }
    
    // Set tanggal mulai (tanggal 1 dari bulan tersebut)
    const tanggalMulai = `${tahun}-${bulan}-01`;
    document.getElementById('export_tanggal_mulai').value = tanggalMulai;
    
    // Set tanggal akhir (hari terakhir dari bulan tersebut)
    const lastDay = new Date(parseInt(tahun), parseInt(bulan), 0).getDate();
    const tanggalAkhir = `${tahun}-${bulan}-${lastDay.toString().padStart(2, '0')}`;
    document.getElementById('export_tanggal_akhir').value = tanggalAkhir;
    
    // Hapus required dari tanggal manual karena bulan & tahun sudah dipilih
    document.getElementById('export_tanggal_mulai').removeAttribute('required');
    document.getElementById('export_tanggal_akhir').removeAttribute('required');
}

// Tutup modal jika klik di luar modal
document.getElementById('exportModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideExportModal();
    }
});

// Validasi tanggal sebelum submit
document.getElementById('exportForm').addEventListener('submit', function(e) {
    const bulan = document.getElementById('export_bulan_select').value;
    const tahun = document.getElementById('export_tahun_select').value;
    const tanggalMulai = document.getElementById('export_tanggal_mulai').value;
    const tanggalAkhir = document.getElementById('export_tanggal_akhir').value;
    
    // Jika tidak pilih bulan & tahun dan tanggal manual juga tidak diisi
    if ((!bulan || !tahun) && (!tanggalMulai || !tanggalAkhir)) {
        e.preventDefault();
        alert('Silakan pilih bulan & tahun atau isi tanggal mulai dan tanggal akhir secara manual!');
        return;
    }
    
    // Jika pilih manual, validasi tanggal
    if ((!bulan || !tahun) && tanggalMulai && tanggalAkhir) {
        if (new Date(tanggalMulai) > new Date(tanggalAkhir)) {
            e.preventDefault();
            alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir!');
            return;
        }
    }
});
</script>
@endpush
@endsection