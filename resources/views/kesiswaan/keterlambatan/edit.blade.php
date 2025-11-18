@extends('layouts.kesiswaan')

@section('title', 'Edit Data Keterlambatan')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('kesiswaan.keterlambatan.show', $keterlambatan->id) }}" 
               class="text-gray-600 hover:text-gray-800 transition-colors">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Edit Data Keterlambatan</h1>
                <p class="text-gray-600 mt-1">Perbarui informasi keterlambatan siswa</p>
            </div>
        </div>
        
        <!-- Current Students Info Preview -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="mb-3">
                <h3 class="text-lg font-semibold text-blue-900 mb-2">Data Keterlambatan Saat Ini</h3>
                <p class="text-blue-700">Tanggal: {{ $keterlambatan->tanggal->format('d/m/Y') }} | Kelas: {{ $keterlambatan->kelas->nama_kelas }}</p>
            </div>
            <div class="flex items-center">
                <div class="flex-shrink-0 h-12 w-12">
                    <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold">
                        {{ substr($keterlambatan->siswa->nama_lengkap, 0, 2) }}
                    </div>
                </div>
                <div class="ml-4">
                    <h4 class="text-base font-semibold text-blue-900">{{ $keterlambatan->siswa->nama_lengkap }}</h4>
                    <p class="text-blue-700 text-sm">NIS: {{ $keterlambatan->siswa->nis }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('kesiswaan.keterlambatan.update', $keterlambatan->id) }}" method="POST" id="editKeterlambatanForm">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tanggal -->
                <div class="md:col-span-2">
                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           name="tanggal" 
                           id="tanggal"
                           value="{{ old('tanggal', $keterlambatan->tanggal->format('Y-m-d')) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tanggal') border-red-500 @enderror"
                           required>
                    @error('tanggal')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kelas Selection -->
                <div>
                    <label for="kelas_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Kelas <span class="text-red-500">*</span>
                    </label>
                    <select name="kelas_id" 
                            id="kelas_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kelas_id') border-red-500 @enderror"
                            required>
                        <option value="">Pilih Kelas</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id', $keterlambatan->kelas_id) == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                    @error('kelas_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Multiple Siswa Selection -->
                <div class="md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Siswa Terlambat <span class="text-red-500">*</span>
                    </label>
                    <div class="space-y-2" id="siswaContainer">
                        <!-- Current siswa will be populated here -->
                        <div class="siswa-item flex items-center gap-2 p-3 border border-gray-200 rounded-lg bg-gray-50">
                            <select name="siswa_ids[]" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent siswa-select" required>
                                <option value="">Pilih Siswa</option>
                                @foreach($siswaList as $s)
                                    <option value="{{ $s->id }}" {{ $s->id == $keterlambatan->siswa_id ? 'selected' : '' }}>
                                        {{ $s->nama_lengkap }} ({{ $s->nis }})
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" class="remove-siswa px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" style="display: none;">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="button" id="addSiswa" class="inline-flex items-center gap-2 px-4 py-2 text-sm bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                            <i class="fas fa-plus"></i>
                            Tambah Siswa
                        </button>
                    </div>
                    @error('siswa_ids')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    @error('siswa_ids.*')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jam Terlambat -->
                <div>
                    <label for="jam_terlambat" class="block text-sm font-medium text-gray-700 mb-2">
                        Jam Terlambat <span class="text-red-500">*</span>
                    </label>
                    <input type="time" 
                           name="jam_terlambat" 
                           id="jam_terlambat"
                           value="{{ old('jam_terlambat', $keterlambatan->jam_terlambat_format) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('jam_terlambat') border-red-500 @enderror"
                           required>
                    @error('jam_terlambat')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-1">Jam saat siswa tiba di sekolah</p>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" 
                            id="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror"
                            required>
                        <option value="">Pilih Status</option>
                        <option value="belum_ditindak" {{ old('status', $keterlambatan->status) == 'belum_ditindak' ? 'selected' : '' }}>
                            Belum Ditindak
                        </option>
                        <option value="sudah_ditindak" {{ old('status', $keterlambatan->status) == 'sudah_ditindak' || old('status', $keterlambatan->status) == 'selesai' ? 'selected' : '' }}>
                            Sudah Ditindak
                        </option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alasan Terlambat -->
                <div class="md:col-span-2">
                    <label for="alasan_terlambat" class="block text-sm font-medium text-gray-700 mb-2">
                        Alasan Terlambat <span class="text-red-500">*</span>
                    </label>
                    <textarea name="alasan_terlambat" 
                              id="alasan_terlambat"
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('alasan_terlambat') border-red-500 @enderror"
                              placeholder="Jelaskan alasan siswa terlambat..."
                              required>{{ old('alasan_terlambat', $keterlambatan->alasan_terlambat) }}</textarea>
                    @error('alasan_terlambat')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sanksi -->
                <div class="md:col-span-2">
                    <label for="sanksi" class="block text-sm font-medium text-gray-700 mb-2">
                        Sanksi/Tindakan
                    </label>
                    <textarea name="sanksi" 
                              id="sanksi"
                              rows="2"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('sanksi') border-red-500 @enderror"
                              placeholder="Sanksi atau tindakan yang diberikan (opsional)...">{{ old('sanksi', $keterlambatan->sanksi) }}</textarea>
                    @error('sanksi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Catatan Petugas -->
                <div class="md:col-span-2">
                    <label for="catatan_petugas" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan Petugas
                    </label>
                    <textarea name="catatan_petugas" 
                              id="catatan_petugas"
                              rows="2"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('catatan_petugas') border-red-500 @enderror"
                              placeholder="Catatan tambahan petugas (opsional)...">{{ old('catatan_petugas', $keterlambatan->catatan_petugas) }}</textarea>
                    @error('catatan_petugas')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('kesiswaan.keterlambatan.show', $keterlambatan->id) }}" 
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    Perbarui Data
                </button>
            </div>
        </form>
    </div>

    <!-- Additional Info -->
    <div class="mt-6 bg-gray-50 rounded-xl p-4 border border-gray-200">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
            </div>
            <div class="ml-3">
                <h4 class="text-sm font-medium text-gray-800 mb-1">Informasi Perubahan</h4>
                <div class="text-sm text-gray-600 space-y-1">
                    <p>• Data siswa dan kelas tidak dapat diubah untuk menjaga integritas data</p>
                    <p>• Perubahan akan otomatis mencatat waktu pembaruan</p>
                    <p>• Pastikan informasi yang dimasukkan sudah benar sebelum menyimpan</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editKeterlambatanForm');
    const kelasSelect = document.getElementById('kelas_id');
    const siswaContainer = document.getElementById('siswaContainer');
    const addSiswaBtn = document.getElementById('addSiswa');
    let siswaOptions = @json($siswaList->toArray());
    
    // Function to update siswa options based on selected kelas
    function updateSiswaOptions(kelasId = null) {
        const siswaSelects = document.querySelectorAll('.siswa-select');
        siswaSelects.forEach(select => {
            const currentValue = select.value;
            select.innerHTML = '<option value="">Pilih Siswa</option>';
            
            siswaOptions.forEach(siswa => {
                if (!kelasId || siswa.kelas_id == kelasId) {
                    const option = document.createElement('option');
                    option.value = siswa.id;
                    option.textContent = `${siswa.nama_lengkap} (${siswa.nis})`;
                    if (siswa.id == currentValue) {
                        option.selected = true;
                    }
                    select.appendChild(option);
                }
            });
        });
        
        updateRemoveButtons();
    }
    
    // Function to update remove button visibility
    function updateRemoveButtons() {
        const siswaItems = document.querySelectorAll('.siswa-item');
        siswaItems.forEach((item, index) => {
            const removeBtn = item.querySelector('.remove-siswa');
            if (siswaItems.length > 1) {
                removeBtn.style.display = 'block';
            } else {
                removeBtn.style.display = 'none';
            }
        });
    }
    
    // Function to create new siswa item
    function createSiswaItem() {
        const newItem = document.createElement('div');
        newItem.className = 'siswa-item flex items-center gap-2 p-3 border border-gray-200 rounded-lg bg-white';
        
        const kelasId = kelasSelect.value;
        let optionsHTML = '<option value="">Pilih Siswa</option>';
        
        siswaOptions.forEach(siswa => {
            if (!kelasId || siswa.kelas_id == kelasId) {
                optionsHTML += `<option value="${siswa.id}">${siswa.nama_lengkap} (${siswa.nis})</option>`;
            }
        });
        
        newItem.innerHTML = `
            <select name="siswa_ids[]" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent siswa-select" required>
                ${optionsHTML}
            </select>
            <button type="button" class="remove-siswa px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        // Add remove event listener
        newItem.querySelector('.remove-siswa').addEventListener('click', function() {
            newItem.remove();
            updateRemoveButtons();
            validateSiswaSelection();
        });
        
        // Add change event listener for validation
        newItem.querySelector('.siswa-select').addEventListener('change', validateSiswaSelection);
        
        return newItem;
    }
    
    // Function to validate siswa selection (no duplicates)
    function validateSiswaSelection() {
        const selectedValues = [];
        const siswaSelects = document.querySelectorAll('.siswa-select');
        let hasDuplicates = false;
        
        siswaSelects.forEach(select => {
            if (select.value) {
                if (selectedValues.includes(select.value)) {
                    hasDuplicates = true;
                    select.classList.add('border-red-500');
                } else {
                    selectedValues.push(select.value);
                    select.classList.remove('border-red-500');
                }
            } else {
                select.classList.remove('border-red-500');
            }
        });
        
        // Show/hide duplicate warning
        let warningElement = document.getElementById('duplicate-warning');
        if (hasDuplicates) {
            if (!warningElement) {
                warningElement = document.createElement('p');
                warningElement.id = 'duplicate-warning';
                warningElement.className = 'text-red-500 text-sm mt-1';
                warningElement.textContent = 'Tidak boleh memilih siswa yang sama!';
                siswaContainer.parentNode.appendChild(warningElement);
            }
        } else if (warningElement) {
            warningElement.remove();
        }
        
        return !hasDuplicates;
    }
    
    // Event listeners
    kelasSelect.addEventListener('change', function() {
        updateSiswaOptions(this.value);
    });
    
    addSiswaBtn.addEventListener('click', function() {
        const newItem = createSiswaItem();
        siswaContainer.appendChild(newItem);
        updateRemoveButtons();
    });
    
    // Add event listeners to existing remove buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-siswa')) {
            e.target.closest('.siswa-item').remove();
            updateRemoveButtons();
            validateSiswaSelection();
        }
    });
    
    // Add event listeners to existing siswa selects
    document.querySelectorAll('.siswa-select').forEach(select => {
        select.addEventListener('change', validateSiswaSelection);
    });
    
    // Form submission validation
    form.addEventListener('submit', function(e) {
        if (!validateSiswaSelection()) {
            e.preventDefault();
            alert('Harap perbaiki kesalahan pada pemilihan siswa sebelum menyimpan.');
            return;
        }
        
        const siswaSelects = document.querySelectorAll('.siswa-select');
        let hasSelectedSiswa = false;
        
        siswaSelects.forEach(select => {
            if (select.value) {
                hasSelectedSiswa = true;
            }
        });
        
        if (!hasSelectedSiswa) {
            e.preventDefault();
            alert('Minimal harus memilih satu siswa!');
            return;
        }
        
        const confirmEdit = confirm('Apakah Anda yakin ingin memperbarui data keterlambatan ini?');
        if (!confirmEdit) {
            e.preventDefault();
        }
    });
    
    // Initialize
    updateRemoveButtons();
    updateSiswaOptions(kelasSelect.value);
});
</script>
@endpush
@endsection
