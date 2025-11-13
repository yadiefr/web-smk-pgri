@extends('layouts.kesiswaan')

@section('title', 'Tambah Pelanggaran Siswa')

@push('styles')
<style>
.siswa-kelas-header {
    position: sticky;
    top: 0;
    z-index: 10;
    background: #f3f4f6;
}

#siswa-container {
    position: relative;
}

.siswa-item {
    border-left: 3px solid transparent;
}

.siswa-item:hover {
    border-left-color: #ef4444;
}

.select-siswa-btn.selected {
    background-color: #dcfce7;
    color: #166534;
    border: 1px solid #22c55e;
}

.selected-student-item {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideOut {
    from {
        opacity: 1;
        transform: translateX(0);
    }
    to {
        opacity: 0;
        transform: translateX(100px);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(100px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideOutRight {
    from {
        opacity: 1;
        transform: translateX(0);
    }
    to {
        opacity: 0;
        transform: translateX(100px);
    }
}

.selected-preview-collapsed {
    max-height: 120px;
    overflow: hidden;
}

.selected-preview-expanded {
    max-height: none;
}
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-plus-circle mr-3 text-red-600"></i>
                    Tambah Pelanggaran Siswa
                </h1>
                <p class="text-gray-600 mt-1">Catat pelanggaran siswa dan tentukan sanksi yang diberikan</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('kesiswaan.pelanggaran.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Informasi Dasar -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                    Informasi Dasar
                </h3>

                <div class="space-y-6">
                    <!-- Pilih Siswa -->
                    <div>
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2 gap-1 sm:gap-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Pilih Siswa yang Melanggar <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-2 text-sm">
                                <span id="selected-count" class="text-blue-600 font-medium">0 dipilih</span>
                                <span class="text-gray-300">|</span>
                                <button type="button" onclick="clearAllSelected()" class="text-red-600 hover:text-red-800">
                                    <span class="hidden sm:inline">Hapus Semua</span>
                                    <i class="fas fa-trash sm:hidden"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Daftar Siswa yang Dipilih -->
                        <div id="selected-students-preview" class="mb-3 hidden">
                            <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-sm font-medium text-green-800">
                                        <i class="fas fa-check-circle mr-2"></i>Siswa yang Dipilih
                                    </h4>
                                    <button type="button" onclick="toggleSelectedPreview()" class="text-green-600 hover:text-green-800 text-sm" id="toggle-preview-btn">
                                        <i class="fas fa-chevron-up"></i>
                                    </button>
                                </div>
                                <div id="selected-students-list" class="space-y-1">
                                    <!-- Daftar siswa akan muncul di sini -->
                                </div>
                            </div>
                        </div>
                        
                        <!-- Search dan Filter Container -->
                        <div class="bg-gray-50 p-3 rounded-lg mb-3 space-y-3">
                            <div class="flex flex-col sm:flex-row gap-3">
                                <!-- Search Input -->
                                <div class="flex-1 relative">
                                    <input type="text" 
                                           id="search_siswa" 
                                           placeholder="Cari nama siswa atau NIS..."
                                           class="w-full px-3 py-2 pl-10 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400 text-sm"></i>
                                    </div>
                                    <button type="button" id="clear-search" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 hidden">
                                        <i class="fas fa-times text-sm"></i>
                                    </button>
                                </div>
                                
                                <!-- Filter Kelas -->
                                <div class="w-full sm:w-48">
                                    <select id="filter_kelas" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm">
                                        <option value="">Semua Kelas</option>
                                        @php
                                            $uniqueKelas = $siswa->pluck('kelas.nama_kelas')->unique()->filter()->sort();
                                        @endphp
                                        @foreach($uniqueKelas as $namaKelas)
                                            <option value="{{ $namaKelas }}">{{ $namaKelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Container Daftar Siswa -->
                        <div id="siswa-container" class="border border-gray-300 rounded-lg bg-white max-h-80 overflow-y-auto">
                            <div id="siswa-loading" class="text-center py-8 hidden">
                                <div class="flex items-center justify-center text-gray-500 text-sm">
                                    <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-red-500 mr-3"></div>
                                    Memuat data siswa...
                                </div>
                            </div>
                            
                            <div id="siswa-list">
                                @if($siswa && $siswa->count() > 0)
                                    @php
                                        // Urutkan siswa berdasarkan kelas dan nama A-Z
                                        $siswaGrouped = $siswa->sortBy([
                                            ['kelas.nama_kelas', 'asc'],
                                            ['nama_lengkap', 'asc']
                                        ])->groupBy(function($item) {
                                            return optional($item->kelas)->nama_kelas ?? 'Tanpa Kelas';
                                        });
                                    @endphp
                                    
                                    @foreach($siswaGrouped as $namaKelas => $siswaList)
                                        <!-- Header Kelas -->
                                        <div class="siswa-kelas-header px-3 py-2 bg-gray-100 border-b border-gray-200" data-kelas="{{ $namaKelas }}">
                                            <div class="flex items-center justify-between">
                                                <h4 class="text-sm font-semibold text-gray-700">{{ $namaKelas }}</h4>
                                                <span class="text-xs text-gray-500">{{ $siswaList->count() }} siswa</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Daftar Siswa dalam Kelas -->
                                        @foreach($siswaList as $s)
                                        <div class="flex items-center p-3 border-b border-gray-100 hover:bg-red-50 transition-colors cursor-pointer siswa-item" 
                                             data-siswa-id="{{ $s->id }}"
                                             data-siswa-name="{{ $s->nama_lengkap }}"
                                             data-siswa-nis="{{ $s->nis }}"
                                             data-siswa-kelas="{{ optional($s->kelas)->nama_kelas ?? '' }}"
                                             data-siswa-kelas-sort="{{ optional($s->kelas)->nama_kelas ?? 'ZZZ' }}">
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex-1 min-w-0">
                                                        <div class="text-sm font-medium text-gray-900 truncate">{{ $s->nama_lengkap }}</div>
                                                        <div class="flex items-center gap-2 mt-0.5">
                                                            <span class="text-xs text-gray-500">NIS: {{ $s->nis }}</span>
                                                            @if($s->kelas)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                {{ $s->kelas->nama_kelas }}
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="ml-3 flex-shrink-0">
                                                        <button type="button" class="select-btn px-3 py-1 text-xs font-medium rounded-full transition-colors bg-red-100 text-red-700 hover:bg-red-200" 
                                                                data-siswa-id="{{ $s->id }}"
                                                                data-siswa-nama="{{ $s->nama_lengkap }}"
                                                                data-siswa-nis="{{ $s->nis }}"
                                                                data-siswa-kelas="{{ optional($s->kelas)->nama_kelas ?? '' }}"
                                                                onclick="toggleSelectSiswaById(this)">
                                                            Pilih
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @endforeach
                                @else
                                    <div id="siswa-empty" class="text-center text-gray-500 py-8">
                                        <i class="fas fa-search text-3xl mb-2"></i>
                                        <p class="text-base">Tidak ada siswa yang ditemukan</p>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Dynamic empty state for filtering -->
                            <div id="filter-empty-state" class="text-center text-gray-500 py-8 hidden">
                                <i class="fas fa-filter text-3xl mb-2"></i>
                                <p class="text-base">Tidak ada siswa yang sesuai dengan filter</p>
                                <button type="button" onclick="clearFilters()" class="mt-2 px-3 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600">
                                    Reset Filter
                                </button>
                            </div>
                        </div>
                        
                        @error('siswa_data')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Selected Students Details -->
                    <div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700">
                                Detail Pelanggaran Siswa <span class="text-red-500">*</span>
                            </label>
                            <p class="text-sm text-gray-500 mt-1">Isi detail pelanggaran untuk setiap siswa yang dipilih</p>
                        </div>
                        
                        <div id="selected-students-details" class="space-y-4 min-h-[100px] border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <!-- Batch controls -->
                            <div id="batch-controls" class="hidden bg-white p-3 rounded border border-gray-300">
                                <div class="text-sm font-medium text-gray-700 mb-2">Atur untuk Semua Siswa:</div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Jam Pelanggaran</label>
                                        <input type="time" id="batch-jam" class="w-full px-2 py-1 text-sm border border-gray-300 rounded">
                                    </div>
                                    <div class="flex items-end">
                                        <button type="button" onclick="applyBatchTime()" class="px-3 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                                            Terapkan ke Semua
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Individual student details will be inserted here -->
                            <div id="no-students-selected" class="text-center text-gray-500 py-8">
                                <i class="fas fa-users text-3xl mb-2"></i>
                                <p>Belum ada siswa yang dipilih</p>
                                <p class="text-sm mt-1">Pilih siswa dari daftar di atas untuk menambahkan detail pelanggaran</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Fields Lainnya -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Jenis Pelanggaran -->
                        <div>
                        <label for="jenis_pelanggaran_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Pelanggaran <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_pelanggaran_id" id="jenis_pelanggaran_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('jenis_pelanggaran_id') border-red-500 @enderror">
                            <option value="">Pilih Jenis Pelanggaran</option>
                            @foreach($jenisPelanggaran->groupBy('kategori') as $kategori => $jenisGroup)
                                <optgroup label="{{ ucfirst($kategori) }}">
                                    @foreach($jenisGroup as $jenis)
                                        <option value="{{ $jenis->id }}" 
                                                data-sanksi="{{ $jenis->sanksi_default }}"
                                                data-poin="{{ $jenis->poin_pelanggaran }}"
                                                {{ old('jenis_pelanggaran_id') == $jenis->id ? 'selected' : '' }}>
                                            {{ $jenis->nama_pelanggaran }} ({{ $jenis->poin_pelanggaran }} poin)
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('jenis_pelanggaran_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Pelanggaran -->
                    <div>
                        <label for="tanggal_pelanggaran" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Pelanggaran <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_pelanggaran" id="tanggal_pelanggaran" 
                               value="{{ old('tanggal_pelanggaran', date('Y-m-d')) }}" required
                               max="{{ date('Y-m-d') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('tanggal_pelanggaran') border-red-500 @enderror">
                        @error('tanggal_pelanggaran')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jam Pelanggaran -->
                    <div>
                        <label for="jam_pelanggaran" class="block text-sm font-medium text-gray-700 mb-2">
                            Jam Pelanggaran
                        </label>
                        <input type="time" name="jam_pelanggaran" id="jam_pelanggaran" 
                               value="{{ old('jam_pelanggaran') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('jam_pelanggaran') border-red-500 @enderror">
                        @error('jam_pelanggaran')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pelapor (Searchable) -->
                    <div>
                        <label for="guru_search" class="block text-sm font-medium text-gray-700 mb-2">
                            Dilaporkan oleh (Guru)
                        </label>
                        <div class="relative">
                            <input type="text"
                                   id="guru_search"
                                   placeholder="Ketik nama guru untuk mencari..."
                                   autocomplete="off"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                   value="{{ old('guru_id') ? ($guru->firstWhere('id', old('guru_id'))->nama ?? '') : '' }}"
                                   onkeyup="searchGuru(this.value)"
                                   onfocus="showAllGuru()">

                            {{-- Hidden input to store selected guru id --}}
                            <input type="hidden" name="guru_id" id="guru_id" value="{{ old('guru_id') }}">

                            {{-- Results dropdown --}}
                            <div id="guru_results" 
                                 class="absolute left-0 right-0 mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-auto z-50" 
                                 style="display: none;"></div>
                        </div>
                        @error('guru_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tingkat Urgensi -->
                    <div>
                        <label for="tingkat_urgensi" class="block text-sm font-medium text-gray-700 mb-2">
                            Tingkat Urgensi <span class="text-red-500">*</span>
                        </label>
                        <select name="tingkat_urgensi" id="tingkat_urgensi" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('tingkat_urgensi') border-red-500 @enderror">
                            <option value="">Pilih Tingkat Urgensi</option>
                            <option value="rendah" {{ old('tingkat_urgensi') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                            <option value="sedang" {{ old('tingkat_urgensi') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="tinggi" {{ old('tingkat_urgensi') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                            <option value="sangat_tinggi" {{ old('tingkat_urgensi') == 'sangat_tinggi' ? 'selected' : '' }}>Sangat Tinggi</option>
                        </select>
                        @error('tingkat_urgensi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
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
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 resize-none @error('deskripsi_kejadian') border-red-500 @enderror">{{ old('deskripsi_kejadian') }}</textarea>
                        @error('deskripsi_kejadian')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bukti Foto -->
                    <div>
                        <label for="bukti_foto" class="block text-sm font-medium text-gray-700 mb-2">
                            Bukti Foto (Opsional)
                        </label>
                        <input type="file" name="bukti_foto" id="bukti_foto" 
                               accept="image/jpeg,image/png,image/jpg"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('bukti_foto') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Maksimal 2MB</p>
                        @error('bukti_foto')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
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
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 resize-none @error('sanksi_diberikan') border-red-500 @enderror">{{ old('sanksi_diberikan') }}</textarea>
                        @error('sanksi_diberikan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Selesai Sanksi -->
                    <div>
                        <label for="tanggal_selesai_sanksi" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Selesai Sanksi
                        </label>
                        <input type="date" name="tanggal_selesai_sanksi" id="tanggal_selesai_sanksi" 
                               value="{{ old('tanggal_selesai_sanksi') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('tanggal_selesai_sanksi') border-red-500 @enderror">
                        @error('tanggal_selesai_sanksi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Catatan Tambahan -->
                    <div>
                        <label for="catatan_tambahan" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan Tambahan
                        </label>
                        <textarea name="catatan_tambahan" id="catatan_tambahan" rows="3"
                                  placeholder="Catatan khusus tentang pelanggaran atau sanksi..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 resize-none @error('catatan_tambahan') border-red-500 @enderror">{{ old('catatan_tambahan') }}</textarea>
                        @error('catatan_tambahan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
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
                               {{ old('sudah_dihubungi_ortu') ? 'checked' : '' }}
                               class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <label for="sudah_dihubungi_ortu" class="ml-2 block text-sm text-gray-900">
                            Sudah menghubungi orang tua/wali siswa
                        </label>
                    </div>

                    <!-- Respon Orang Tua -->
                    <div id="respon_ortu_container" style="display: none;">
                        <label for="respon_ortu" class="block text-sm font-medium text-gray-700 mb-2">
                            Respon Orang Tua
                        </label>
                        <textarea name="respon_ortu" id="respon_ortu" rows="3"
                                  placeholder="Jelaskan respon orang tua terhadap pelanggaran anaknya..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 resize-none @error('respon_ortu') border-red-500 @enderror">{{ old('respon_ortu') }}</textarea>
                        @error('respon_ortu')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Pelanggaran
                </button>
                <a href="{{ route('kesiswaan.pelanggaran.index') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Global variables for selected students
let selectedStudents = {};
let studentCount = 0;

// Fungsi untuk toggle select siswa berdasarkan ID (multiple selection)
function toggleSelectSiswaById(button) {
    const studentId = parseInt(button.dataset.siswaId);
    const studentName = button.dataset.siswaNama;
    const studentNis = button.dataset.siswaNis;
    const studentKelas = button.dataset.siswaKelas;
    
    const studentData = {
        id: studentId,
        nama_lengkap: studentName,
        nis: studentNis,
        kelas: studentKelas
    };
    
    if (selectedStudents[studentId]) {
        // Remove student
        delete selectedStudents[studentId];
        button.textContent = 'Pilih';
        button.className = 'select-btn px-3 py-1 text-xs font-medium rounded-full transition-colors bg-red-100 text-red-700 hover:bg-red-200';
        
        // Remove highlight
        const item = button.closest('.siswa-item');
        item.classList.remove('bg-green-50', 'border-green-200');
        
        showNotification(`${studentName} dihapus dari daftar`, 'warning');
    } else {
        // Add student
        selectedStudents[studentId] = {
            ...studentData,
            jam_pelanggaran: '',
            alasan_detail: ''
        };
        button.textContent = '✓ Dipilih';
        button.className = 'select-btn px-3 py-1 text-xs font-medium rounded-full transition-colors bg-green-100 text-green-700';
        
        // Add highlight
        const item = button.closest('.siswa-item');
        item.classList.add('bg-green-50', 'border-green-200');
        
        showNotification(`${studentName} ditambahkan ke daftar`, 'success');
    }
    
    updateSelectedCount();
    renderSelectedStudents();
};

// Show notification toast
function showNotification(message, type = 'info') {
    // Remove existing notification
    const existing = document.querySelector('.toast-notification');
    if (existing) {
        existing.remove();
    }
    
    const notification = document.createElement('div');
    notification.className = `toast-notification fixed top-4 right-4 px-4 py-2 rounded-lg shadow-lg text-white text-sm z-50 ${
        type === 'success' ? 'bg-green-500' : 
        type === 'warning' ? 'bg-yellow-500' : 
        type === 'error' ? 'bg-red-500' : 'bg-blue-500'
    }`;
    
    notification.style.animation = 'slideInRight 0.3s ease-out';
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 300);
    }, 3000);
};

// Update jumlah siswa yang dipilih
function updateSelectedCount() {
    studentCount = Object.keys(selectedStudents).length;
    const countElement = document.getElementById('selected-count');
    if (countElement) {
        countElement.textContent = studentCount + ' dipilih';
    }
    
    // Show/hide selected students preview
    const previewContainer = document.getElementById('selected-students-preview');
    if (previewContainer) {
        if (studentCount > 0) {
            previewContainer.classList.remove('hidden');
            updateSelectedPreview();
        } else {
            previewContainer.classList.add('hidden');
        }
    }
    
    // Show/hide batch controls
    const batchControls = document.getElementById('batch-controls');
    if (batchControls) {
        if (studentCount > 1) {
            batchControls.classList.remove('hidden');
        } else {
            batchControls.classList.add('hidden');
        }
    }
};

// Render daftar siswa yang dipilih
function renderSelectedStudents() {
    const container = document.getElementById('selected-students-details');
    const noStudentsDiv = document.getElementById('no-students-selected');
    
    if (!container) return;
    
    if (studentCount === 0) {
        if (noStudentsDiv) noStudentsDiv.style.display = 'block';
        // Hide all individual student details
        container.querySelectorAll('.student-detail-card').forEach(card => card.remove());
        return;
    }
    
    if (noStudentsDiv) noStudentsDiv.style.display = 'none';
    
    // Clear existing cards
    container.querySelectorAll('.student-detail-card').forEach(card => card.remove());
    
    // Create cards for each selected student
    Object.values(selectedStudents).forEach(function(student) {
        const card = createStudentDetailCard(student);
        container.appendChild(card);
    });
};

// Update preview daftar siswa yang dipilih
function updateSelectedPreview() {
    const listContainer = document.getElementById('selected-students-list');
    if (!listContainer) return;
    
    listContainer.innerHTML = '';
    
    Object.values(selectedStudents).forEach(function(student, index) {
        const item = document.createElement('div');
        item.className = 'selected-student-item flex items-center justify-between py-1 px-2 bg-white rounded text-sm';
        
        item.innerHTML = `
            <div class="flex items-center gap-2">
                <span class="w-5 h-5 bg-green-100 text-green-700 rounded-full flex items-center justify-center text-xs font-medium">
                    ${index + 1}
                </span>
                <div>
                    <span class="font-medium text-gray-900">${student.nama_lengkap}</span>
                    <span class="text-gray-500 ml-2">
                        ${student.nis} | ${student.kelas || 'Tidak diketahui'}
                    </span>
                </div>
            </div>
            <button type="button" onclick="removeStudentFromPreview(${student.id})" class="text-red-500 hover:text-red-700 ml-2">
                <i class="fas fa-times text-xs"></i>
            </button>
        `;
        
        listContainer.appendChild(item);
    });
    
    // Update counter di preview header
    const previewHeader = document.querySelector('#selected-students-preview h4');
    if (previewHeader) {
        previewHeader.innerHTML = `<i class="fas fa-check-circle mr-2"></i>${studentCount} Siswa Dipilih`;
    }
    
    // Auto-collapse if more than 3 students
    if (studentCount > 3 && !listContainer.classList.contains('selected-preview-collapsed')) {
        listContainer.classList.add('selected-preview-collapsed');
        const toggleBtn = document.getElementById('toggle-preview-btn');
        if (toggleBtn) {
            const icon = toggleBtn.querySelector('i');
            if (icon) icon.className = 'fas fa-chevron-down';
        }
    }
};

// Fungsi pencarian siswa
function initSiswaSearch() {
    const searchInput = document.getElementById('search_siswa');
    const filterKelas = document.getElementById('filter_kelas');
    const clearBtn = document.getElementById('clear-search');
    const siswaItems = document.querySelectorAll('.siswa-item');
    const emptyState = document.getElementById('filter-empty-state');
    
    // Event listener untuk search input
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        filterSiswa();
        
        // Toggle clear button
        if (searchTerm) {
            clearBtn.classList.remove('hidden');
        } else {
            clearBtn.classList.add('hidden');
        }
    });
    
    // Event listener untuk filter kelas
    filterKelas.addEventListener('change', function() {
        filterSiswa();
    });
    
    // Event listener untuk clear button
    clearBtn.addEventListener('click', function() {
        searchInput.value = '';
        this.classList.add('hidden');
        filterSiswa();
        searchInput.focus();
    });
    
    function filterSiswa() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedKelas = filterKelas.value;
        let visibleCount = 0;
        let visibleKelas = new Set();
        
        // Filter siswa items
        siswaItems.forEach(function(item) {
            const nama = item.dataset.siswaName.toLowerCase();
            const nis = item.dataset.siswaNis.toLowerCase();
            const kelas = item.dataset.siswaKelas;
            
            const matchSearch = !searchTerm || nama.includes(searchTerm) || nis.includes(searchTerm);
            const matchKelas = !selectedKelas || kelas === selectedKelas;
            
            if (matchSearch && matchKelas) {
                item.style.display = '';
                visibleCount++;
                visibleKelas.add(kelas || 'Tanpa Kelas');
            } else {
                item.style.display = 'none';
            }
        });
        
        // Show/hide kelas headers berdasarkan apakah ada siswa yang terlihat di kelas tersebut
        const kelasHeaders = document.querySelectorAll('.siswa-kelas-header');
        kelasHeaders.forEach(function(header) {
            const kelasName = header.dataset.kelas;
            if (visibleKelas.has(kelasName) && visibleCount > 0) {
                header.style.display = '';
            } else {
                header.style.display = 'none';
            }
        });
        
        // Show/hide empty state
        if (visibleCount === 0) {
            emptyState.classList.remove('hidden');
        } else {
            emptyState.classList.add('hidden');
        }
    }
}

// Show notification toast
function showNotification(message, type = 'info') {
    // Remove existing notification
    const existing = document.querySelector('.toast-notification');
    if (existing) {
        existing.remove();
    }
    
    const notification = document.createElement('div');
    notification.className = `toast-notification fixed top-4 right-4 px-4 py-2 rounded-lg shadow-lg text-white text-sm z-50 ${
        type === 'success' ? 'bg-green-500' : 
        type === 'warning' ? 'bg-yellow-500' : 
        type === 'error' ? 'bg-red-500' : 'bg-blue-500'
    }`;
    
    notification.style.animation = 'slideInRight 0.3s ease-out';
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease-out';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 300);
    }, 3000);
}

// Update jumlah siswa yang dipilih
function updateSelectedCount() {
    studentCount = Object.keys(selectedStudents).length;
    document.getElementById('selected-count').textContent = studentCount + ' dipilih';
    
    // Show/hide selected students preview
    const previewContainer = document.getElementById('selected-students-preview');
    if (studentCount > 0) {
        previewContainer.classList.remove('hidden');
        updateSelectedPreview();
    } else {
        previewContainer.classList.add('hidden');
    }
    
    // Show/hide batch controls
    const batchControls = document.getElementById('batch-controls');
    if (studentCount > 1) {
        batchControls.classList.remove('hidden');
    } else {
        batchControls.classList.add('hidden');
    }
}

// Update preview daftar siswa yang dipilih
function updateSelectedPreview() {
    const listContainer = document.getElementById('selected-students-list');
    listContainer.innerHTML = '';
    
    Object.values(selectedStudents).forEach(function(student, index) {
        const item = document.createElement('div');
        item.className = 'selected-student-item flex items-center justify-between py-1 px-2 bg-white rounded text-sm';
        
        item.innerHTML = `
            <div class="flex items-center gap-2">
                <span class="w-5 h-5 bg-green-100 text-green-700 rounded-full flex items-center justify-center text-xs font-medium">
                    ${index + 1}
                </span>
                <div>
                    <span class="font-medium text-gray-900">${student.nama_lengkap}</span>
                    <span class="text-gray-500 ml-2">
                        ${student.nis} | ${student.kelas || 'Tidak diketahui'}
                    </span>
                </div>
            </div>
            <button type="button" onclick="removeStudentFromPreview(${student.id})" class="text-red-500 hover:text-red-700 ml-2">
                <i class="fas fa-times text-xs"></i>
            </button>
        `;
        
        listContainer.appendChild(item);
    });
    
    // Update counter di preview header
    const previewHeader = document.querySelector('#selected-students-preview h4');
    previewHeader.innerHTML = `<i class="fas fa-check-circle mr-2"></i>${studentCount} Siswa Dipilih`;
    
    // Auto-collapse if more than 3 students
    if (studentCount > 3 && !listContainer.classList.contains('selected-preview-collapsed')) {
        listContainer.classList.add('selected-preview-collapsed');
        const toggleBtn = document.getElementById('toggle-preview-btn');
        const icon = toggleBtn.querySelector('i');
        icon.className = 'fas fa-chevron-down';
    }
}

// Remove siswa dari preview (sama dengan removeStudent tapi dengan animasi)
function removeStudentFromPreview(studentId) {
    const item = event.target.closest('.selected-student-item');
    item.style.animation = 'slideOut 0.3s ease-out';
    
    setTimeout(() => {
        removeStudent(studentId);
    }, 200);
}

// Toggle collapse/expand preview
function toggleSelectedPreview() {
    const listContainer = document.getElementById('selected-students-list');
    const toggleBtn = document.getElementById('toggle-preview-btn');
    const icon = toggleBtn.querySelector('i');
    
    if (listContainer.classList.contains('selected-preview-collapsed')) {
        listContainer.classList.remove('selected-preview-collapsed');
        listContainer.classList.add('selected-preview-expanded');
        icon.className = 'fas fa-chevron-up';
    } else {
        listContainer.classList.add('selected-preview-collapsed');
        listContainer.classList.remove('selected-preview-expanded');
        icon.className = 'fas fa-chevron-down';
    }
}

// Render daftar siswa yang dipilih
function renderSelectedStudents() {
    const container = document.getElementById('selected-students-details');
    const noStudentsDiv = document.getElementById('no-students-selected');
    
    if (studentCount === 0) {
        noStudentsDiv.style.display = 'block';
        // Hide all individual student details
        container.querySelectorAll('.student-detail-card').forEach(card => card.remove());
        return;
    }
    
    noStudentsDiv.style.display = 'none';
    
    // Clear existing cards
    container.querySelectorAll('.student-detail-card').forEach(card => card.remove());
    
    // Create cards for each selected student
    Object.values(selectedStudents).forEach(function(student) {
        const card = createStudentDetailCard(student);
        container.appendChild(card);
    });
}

// Create detail card untuk siswa
function createStudentDetailCard(student) {
    const card = document.createElement('div');
    card.className = 'student-detail-card bg-white border border-gray-300 rounded p-3';
    
    card.innerHTML = `
        <div class="flex justify-between items-start mb-3">
            <div>
                <h4 class="font-medium text-gray-900">${student.nama_lengkap}</h4>
                <p class="text-sm text-gray-500">NIS: ${student.nis} | Kelas: ${student.kelas || 'Tidak diketahui'}</p>
            </div>
            <button type="button" onclick="removeStudent(${student.id})" class="text-red-600 hover:text-red-800 text-sm">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Jam Pelanggaran</label>
                <input type="time" 
                       name="siswa_data[${student.id}][jam_pelanggaran]"
                       value="${student.jam_pelanggaran}"
                       onchange="updateStudentData(${student.id}, 'jam_pelanggaran', this.value)"
                       class="w-full px-2 py-1 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-red-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Detail Tambahan</label>
                <input type="text" 
                       name="siswa_data[${student.id}][alasan_detail]"
                       value="${student.alasan_detail}"
                       onchange="updateStudentData(${student.id}, 'alasan_detail', this.value)"
                       placeholder="Detail pelanggaran..."
                       class="w-full px-2 py-1 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-red-500">
            </div>
        </div>
        
        <!-- Hidden inputs -->
        <input type="hidden" name="siswa_data[${student.id}][siswa_id]" value="${student.id}">
        <input type="hidden" name="siswa_data[${student.id}][nama]" value="${student.nama_lengkap}">
        <input type="hidden" name="siswa_data[${student.id}][nis]" value="${student.nis}">
        <input type="hidden" name="siswa_data[${student.id}][kelas]" value="${student.kelas || ''}">
    `;
    
    return card;
}

// Update data siswa
function updateStudentData(studentId, field, value) {
    if (selectedStudents[studentId]) {
        selectedStudents[studentId][field] = value;
    }
}

// Remove siswa dari selection
function removeStudent(studentId) {
    delete selectedStudents[studentId];
    
    // Update button di list
    const button = document.querySelector(`[data-siswa-id="${studentId}"]`);
    if (button) {
        button.textContent = 'Pilih';
        button.className = 'select-btn px-3 py-1 text-xs font-medium rounded-full transition-colors bg-red-100 text-red-700 hover:bg-red-200';
        
        const item = button.closest('.siswa-item');
        item.classList.remove('bg-green-50', 'border-green-200');
    }
    
    updateSelectedCount();
    renderSelectedStudents();
}

// Clear semua siswa yang dipilih
function clearAllSelected() {
    // Animate removal of all items
    document.querySelectorAll('.selected-student-item').forEach(function(item, index) {
        setTimeout(() => {
            item.style.animation = 'slideOut 0.3s ease-out';
        }, index * 100);
    });
    
    setTimeout(() => {
        selectedStudents = {};
        
        // Reset semua button
        document.querySelectorAll('.select-btn').forEach(function(btn) {
            btn.textContent = 'Pilih';
            btn.className = 'select-btn px-3 py-1 text-xs font-medium rounded-full transition-colors bg-red-100 text-red-700 hover:bg-red-200';
        });
        
        // Remove highlights
        document.querySelectorAll('.siswa-item').forEach(function(item) {
            item.classList.remove('bg-green-50', 'border-green-200');
        });
        
        updateSelectedCount();
        renderSelectedStudents();
    }, Object.keys(selectedStudents).length * 100 + 200);
}

// Apply batch time ke semua siswa
function applyBatchTime() {
    const batchTime = document.getElementById('batch-jam').value;
    if (!batchTime) {
        showNotification('Masukkan jam terlebih dahulu', 'warning');
        return;
    }
    
    Object.keys(selectedStudents).forEach(function(studentId) {
        selectedStudents[studentId].jam_pelanggaran = batchTime;
    });
    
    renderSelectedStudents();
    showNotification('Jam pelanggaran berhasil diterapkan ke semua siswa', 'success');
}

// Select semua siswa yang terlihat
function selectAllVisibleStudents() {
    const visibleItems = document.querySelectorAll('.siswa-item[style=""], .siswa-item:not([style*="display: none"])');
    let addedCount = 0;
    
    visibleItems.forEach(function(item) {
        const button = item.querySelector('.select-btn');
        if (button && button.textContent === 'Pilih') {
            const studentData = {
                id: parseInt(button.dataset.siswaId || item.dataset.siswaId),
                nama_lengkap: button.dataset.siswaNama || item.dataset.siswaName,
                nis: button.dataset.siswaNis || item.dataset.siswaNis,
                kelas: button.dataset.siswaKelas || item.dataset.siswaKelas
            };
            
            selectedStudents[studentData.id] = {
                ...studentData,
                jam_pelanggaran: '',
                alasan_detail: ''
            };
            
            button.textContent = '✓ Dipilih';
            button.className = 'select-btn px-3 py-1 text-xs font-medium rounded-full transition-colors bg-green-100 text-green-700';
            item.classList.add('bg-green-50', 'border-green-200');
            addedCount++;
        }
    });
    
    if (addedCount > 0) {
        updateSelectedCount();
        renderSelectedStudents();
        showNotification(`${addedCount} siswa ditambahkan ke daftar`, 'success');
    }
}

// Fungsi untuk clear filters
function clearFilters() {
    document.getElementById('search_siswa').value = '';
    document.getElementById('filter_kelas').value = '';
    document.getElementById('clear-search').classList.add('hidden');
    
    // Show semua siswa dan header kelas
    document.querySelectorAll('.siswa-item').forEach(function(item) {
        item.style.display = '';
    });
    document.querySelectorAll('.siswa-kelas-header').forEach(function(header) {
        header.style.display = '';
    });
    document.getElementById('filter-empty-state').classList.add('hidden');
}

// Inisialisasi saat DOM ready
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi pencarian siswa
    initSiswaSearch();
    
    // Form validation
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (Object.keys(selectedStudents).length === 0) {
                e.preventDefault();
                showNotification('Pilih minimal 1 siswa untuk melanjutkan!', 'error');
                return false;
            }
        });
    }
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl + A untuk select all visible students
        if (e.ctrlKey && e.key === 'a' && e.target.closest('.siswa-container')) {
            e.preventDefault();
            selectAllVisibleStudents();
        }
        
        // Escape untuk clear selection
        if (e.key === 'Escape') {
            if (Object.keys(selectedStudents).length > 0) {
                clearAllSelected();
            }
        }
    });
}
    
    // Auto-fill sanksi berdasarkan jenis pelanggaran
    const jenisPelanggaranSelect = document.getElementById('jenis_pelanggaran_id');
    const sanksiTextarea = document.getElementById('sanksi_diberikan');
    
    if (jenisPelanggaranSelect && sanksiTextarea) {
        jenisPelanggaranSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.dataset.sanksi) {
                sanksiTextarea.value = selectedOption.dataset.sanksi;
            }
        });
    }

    // Toggle respon orang tua
    const hubungiOrtuCheckbox = document.getElementById('sudah_dihubungi_ortu');
    const responOrtuContainer = document.getElementById('respon_ortu_container');
    
    if (hubungiOrtuCheckbox && responOrtuContainer) {
        hubungiOrtuCheckbox.addEventListener('change', function() {
            if (this.checked) {
                responOrtuContainer.style.display = 'block';
            } else {
                responOrtuContainer.style.display = 'none';
                document.getElementById('respon_ortu').value = '';
            }
        });

        // Show respon container if checkbox is already checked (for old input)
        if (hubungiOrtuCheckbox.checked) {
            responOrtuContainer.style.display = 'block';
        }
    }

    // Set minimum date for tanggal selesai sanksi
    const tanggalPelanggaranInput = document.getElementById('tanggal_pelanggaran');
    const tanggalSelesaiSanksiInput = document.getElementById('tanggal_selesai_sanksi');
    
    if (tanggalPelanggaranInput && tanggalSelesaiSanksiInput) {
        tanggalPelanggaranInput.addEventListener('change', function() {
            tanggalSelesaiSanksiInput.min = this.value;
        });

        // Set initial min date
        if (tanggalPelanggaranInput.value) {
            tanggalSelesaiSanksiInput.min = tanggalPelanggaranInput.value;
        }
    }
});
</script>
@endpush