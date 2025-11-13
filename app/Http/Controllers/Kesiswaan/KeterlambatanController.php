<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\SiswaKeterlambatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KeterlambatanMultiSheetExport;
use App\Exports\KeterlambatanRekapTotalExport;
use App\Exports\KeterlambatanPeriodeExport;

class KeterlambatanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data keterlambatan yang dikelompokkan per batch (tanggal + petugas + created_at)
        $query = SiswaKeterlambatan::with(['siswa', 'kelas', 'petugas']);

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
        } elseif ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        } else {
            // Default: 3 bulan terakhir untuk menampilkan data yang lebih relevan
            $query->where('tanggal', '>=', now()->subMonths(3)->startOfMonth())
                  ->where('tanggal', '<=', now()->endOfMonth());
        }

        // Filter berdasarkan kelas
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pencarian siswa
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        // Ambil semua data keterlambatan
        $allKeterlambatan = $query->orderBy('created_at', 'desc')->get();

        // Kelompokkan berdasarkan tanggal, petugas, dan waktu pembuatan (dalam 5 menit)
        $groupedKeterlambatan = $allKeterlambatan->groupBy(function ($item) {
            // Group berdasarkan tanggal, petugas_id, dan created_at (dibulatkan ke 5 menit)
            $createdAt = $item->created_at;
            $roundedTime = $createdAt->format('Y-m-d H:i');
            // Bulatkan ke 5 menit terdekat untuk mengelompokkan data yang dibuat bersamaan
            $minutes = intval($createdAt->format('i'));
            $roundedMinutes = floor($minutes / 5) * 5;
            $roundedTime = $createdAt->format('Y-m-d H:') . str_pad($roundedMinutes, 2, '0', STR_PAD_LEFT);
            
            return $item->tanggal->format('Y-m-d') . '_' . $item->petugas_id . '_' . $roundedTime;
        });

        // Konversi ke collection dengan informasi batch
        $batchKeterlambatan = $groupedKeterlambatan->map(function ($items) {
            $firstItem = $items->first();
            $siswaList = $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama' => $item->siswa->nama_lengkap,
                    'nis' => $item->siswa->nis,
                    'kelas' => $item->kelas->nama_kelas,
                    'jam_terlambat' => $item->jam_terlambat,
                    'alasan_terlambat' => $item->alasan_terlambat,
                    'status' => $item->status,
                ];
            });

            return (object) [
                'id' => $firstItem->id, // ID dari item pertama untuk referensi
                'tanggal' => $firstItem->tanggal,
                'petugas' => $firstItem->petugas,
                'created_at' => $firstItem->created_at,
                'updated_at' => $firstItem->updated_at,
                'jumlah_siswa' => $items->count(),
                'siswa_list' => $siswaList,
                'status_umum' => $firstItem->status, // Status dari item pertama
                'kelas_terlibat' => $items->pluck('kelas.nama_kelas')->unique()->implode(', '),
                'jam_tercepat' => $items->min('jam_terlambat'),
                'jam_terlambat_paling' => $items->max('jam_terlambat'),
            ];
        });

        // Tidak ada pagination - tampilkan semua data
        $keterlambatanBatch = $batchKeterlambatan;

        // Data untuk filter
        $kelas = Kelas::orderBy('nama_kelas')->get();

        // Kirim informasi filter yang aktif ke view
        $filterInfo = [
            'tanggal_mulai' => $request->filled('tanggal_mulai') ? $request->tanggal_mulai : now()->subMonths(3)->startOfMonth()->format('Y-m-d'),
            'tanggal_akhir' => $request->filled('tanggal_akhir') ? $request->tanggal_akhir : now()->endOfMonth()->format('Y-m-d'),
            'kelas_id' => $request->kelas_id,
            'is_default_filter' => !$request->filled('tanggal_mulai') && !$request->filled('tanggal_akhir')
        ];

        return view('kesiswaan.keterlambatan.index', compact('keterlambatanBatch', 'kelas', 'filterInfo'));
    }

    public function create(Request $request)
    {
        // Pre-fill tanggal hari ini
        $tanggal = $request->filled('tanggal') ? $request->tanggal : today()->format('Y-m-d');

        $kelas = Kelas::with('jurusan')->orderBy('nama_kelas')->get();
        
        // Debug: check if we have any kelas
        if ($kelas->isEmpty()) {
            \Log::warning('No kelas found in create method');
        }
        
        // Ambil semua siswa dengan data kelasnya, urutkan berdasarkan kelas dulu kemudian nama
        $siswaQuery = Siswa::with('kelas')
            ->whereHas('kelas')
            ->join('kelas', 'siswa.kelas_id', '=', 'kelas.id')
            ->orderBy('kelas.nama_kelas', 'asc')
            ->orderBy('siswa.nama_lengkap', 'asc')
            ->select('siswa.*');
            
        \Log::info('Siswa query SQL: ' . $siswaQuery->toSql());
        \Log::info('Siswa query bindings: ', $siswaQuery->getBindings());
        
        $siswaCollection = $siswaQuery->get();
        
        \Log::info('Siswa collection count: ' . $siswaCollection->count());
        
        $siswa = $siswaCollection->map(function ($s) {
                return [
                    'id' => $s->id,
                    'nama' => $s->nama_lengkap,
                    'nis' => $s->nis,
                    'kelas_id' => $s->kelas_id,
                    'kelas_nama' => $s->kelas->nama_kelas ?? '',
                ];
            });

        \Log::info('Final siswa array count: ' . $siswa->count());
        \Log::info('Sample siswa data: ', $siswa->take(3)->toArray());

        return view('kesiswaan.keterlambatan.create', compact('kelas', 'tanggal', 'siswa'));
    }

    public function debugSiswa()
    {
        $siswa = Siswa::with('kelas')
            ->whereHas('kelas')
            ->join('kelas', 'siswa.kelas_id', '=', 'kelas.id')
            ->orderBy('kelas.nama_kelas', 'asc')
            ->orderBy('siswa.nama_lengkap', 'asc')
            ->select('siswa.*')
            ->get()
            ->map(function ($s) {
                return [
                    'id' => $s->id,
                    'nama' => $s->nama_lengkap,
                    'nis' => $s->nis,
                    'kelas_id' => $s->kelas_id,
                    'kelas_nama' => $s->kelas->nama_kelas ?? '',
                ];
            });

        return response()->json([
            'count' => $siswa->count(),
            'data' => $siswa->take(5),
            'success' => true
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_data' => 'required|array|min:1',
            'siswa_data.*.siswa_id' => 'required|exists:siswa,id',
            'siswa_data.*.kelas_id' => 'required|exists:kelas,id',
            'siswa_data.*.jam_terlambat' => 'required|date_format:H:i',
            'siswa_data.*.alasan_terlambat' => 'required|string|max:500',
            'tanggal' => 'required|date',
            'status' => 'required|in:belum_ditindak,sudah_ditindak,selesai',
            'sanksi' => 'nullable|string|max:500',
            'catatan_petugas' => 'nullable|string|max:500',
        ], [
            'siswa_data.required' => 'Minimal pilih satu siswa',
            'siswa_data.min' => 'Minimal pilih satu siswa',
            'siswa_data.*.siswa_id.exists' => 'Salah satu siswa tidak ditemukan',
            'siswa_data.*.kelas_id.exists' => 'Salah satu kelas tidak ditemukan',
            'siswa_data.*.jam_terlambat.required' => 'Jam terlambat harus diisi untuk semua siswa',
            'siswa_data.*.jam_terlambat.date_format' => 'Format jam tidak valid (HH:MM)',
            'siswa_data.*.alasan_terlambat.required' => 'Alasan terlambat harus diisi untuk semua siswa',
            'siswa_data.*.alasan_terlambat.max' => 'Alasan terlambat maksimal 500 karakter',
            'tanggal.required' => 'Tanggal harus diisi',
            'status.required' => 'Status harus dipilih',
            'sanksi.max' => 'Sanksi maksimal 500 karakter',
            'catatan_petugas.max' => 'Catatan petugas maksimal 500 karakter',
        ]);

        $berhasilDicatat = 0;
        $sudahAda = [];
        
        foreach ($request->siswa_data as $siswaData) {
            $siswaId = $siswaData['siswa_id'];
            
            // Ambil data siswa untuk nama
            $siswa = Siswa::find($siswaId);
            
            if (!$siswa) {
                continue;
            }

            // Cek apakah siswa sudah tercatat terlambat pada tanggal yang sama
            $cekDuplikat = SiswaKeterlambatan::where('siswa_id', $siswaId)
                ->whereDate('tanggal', $request->tanggal)
                ->exists();

            if ($cekDuplikat) {
                $sudahAda[] = $siswa->nama_lengkap;
                continue;
            }

            // Simpan data keterlambatan dengan data individual siswa
            SiswaKeterlambatan::create([
                'siswa_id' => $siswaId,
                'kelas_id' => $siswaData['kelas_id'],
                'tanggal' => $request->tanggal,
                'jam_terlambat' => $siswaData['jam_terlambat'],
                'alasan_terlambat' => $siswaData['alasan_terlambat'],
                'status' => $request->status,
                'sanksi' => $request->sanksi,
                'petugas_id' => auth()->id(),
                'catatan_petugas' => $request->catatan_petugas,
            ]);

            $berhasilDicatat++;
        }

        // Prepare success/error messages
        $messages = [];
        
        if ($berhasilDicatat > 0) {
            $messages[] = "Berhasil mencatat {$berhasilDicatat} siswa terlambat";
        }
        
        if (!empty($sudahAda)) {
            $namaList = implode(', ', $sudahAda);
            $messages[] = "Siswa berikut sudah tercatat terlambat hari ini: {$namaList}";
        }

        if ($berhasilDicatat > 0) {
            return redirect()->route('kesiswaan.keterlambatan.index')
                ->with('success', $messages[0])
                ->with('warning', $messages[1] ?? null);
        } else {
            return back()
                ->withErrors(['siswa_data' => 'Semua siswa yang dipilih sudah tercatat terlambat pada tanggal ini'])
                ->withInput();
        }
    }

    public function show(SiswaKeterlambatan $keterlambatan)
    {
        $keterlambatan->load(['siswa', 'kelas', 'petugas']);

        return view('kesiswaan.keterlambatan.show', compact('keterlambatan'));
    }

    public function editBatch($tanggal, $petugas_id, $created_at)
    {
        // Decode timestamp dari URL
        $created_at = \Carbon\Carbon::parse($created_at);
        $tanggal = \Carbon\Carbon::parse($tanggal)->format('Y-m-d');
        
        // Handle null petugas_id
        $petugas_id = $petugas_id === 'null' ? null : $petugas_id;
        
        // Ambil semua record keterlambatan dalam batch yang sama
        $query = SiswaKeterlambatan::with(['siswa', 'kelas', 'petugas'])
            ->where('tanggal', $tanggal)
            ->whereRaw('ABS(TIMESTAMPDIFF(MINUTE, created_at, ?)) <= 5', [$created_at]);
            
        if ($petugas_id) {
            $query->where('petugas_id', $petugas_id);
        } else {
            $query->whereNull('petugas_id');
        }
        
        $keterlambatanBatch = $query->get();

        if ($keterlambatanBatch->isEmpty()) {
            return redirect()->route('kesiswaan.keterlambatan.index')
                ->with('error', 'Batch keterlambatan tidak ditemukan');
        }

        $kelas = Kelas::with('jurusan')->orderBy('nama_kelas')->get();
        
        // Data batch untuk form
        $batchData = [
            'tanggal' => $tanggal,
            'petugas_id' => $petugas_id,
            'created_at' => $created_at->format('Y-m-d H:i:s'),
            'jumlah_siswa' => $keterlambatanBatch->count(),
            'kelas_terlibat' => $keterlambatanBatch->pluck('kelas.nama_kelas')->unique()->implode(', '),
            'jam_tercepat' => $keterlambatanBatch->min('jam_terlambat'),
            'jam_terlambat_paling' => $keterlambatanBatch->max('jam_terlambat'),
            'status_umum' => $keterlambatanBatch->first()->status,
        ];

        return view('kesiswaan.keterlambatan.edit_batch', compact('keterlambatanBatch', 'kelas', 'batchData'));
    }

    public function updateBatch(Request $request, $tanggal, $petugas_id, $created_at)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'status_batch' => 'required|in:belum_ditindak,sudah_ditindak,selesai',
            'catatan_batch' => 'nullable|string|max:1000',
            'sanksi_batch' => 'nullable|string|max:1000',
            'siswa' => 'required|array',
            'siswa.*.jam_terlambat' => 'required|date_format:H:i',
            'siswa.*.alasan_terlambat' => 'required|string|max:500',
            'siswa.*.status' => 'required|in:belum_ditindak,sudah_ditindak,selesai',
            'siswa.*.sanksi' => 'nullable|string|max:500',
        ]);

        // Decode timestamp dari URL
        $created_at = \Carbon\Carbon::parse($created_at);
        $tanggal = \Carbon\Carbon::parse($tanggal)->format('Y-m-d');
        
        // Handle null petugas_id
        $petugas_id = $petugas_id === 'null' ? null : $petugas_id;
        
        // Ambil semua record keterlambatan dalam batch yang sama
        $query = SiswaKeterlambatan::where('tanggal', $tanggal)
            ->whereRaw('ABS(TIMESTAMPDIFF(MINUTE, created_at, ?)) <= 5', [$created_at]);
            
        if ($petugas_id) {
            $query->where('petugas_id', $petugas_id);
        } else {
            $query->whereNull('petugas_id');
        }
        
        $keterlambatanBatch = $query->get();

        if ($keterlambatanBatch->isEmpty()) {
            return redirect()->route('kesiswaan.keterlambatan.index')
                ->with('error', 'Batch keterlambatan tidak ditemukan');
        }

        // Update data batch
        foreach ($keterlambatanBatch as $keterlambatan) {
            $siswaData = $request->siswa[$keterlambatan->id] ?? null;
            
            if ($siswaData) {
                $keterlambatan->update([
                    'tanggal' => $request->tanggal,
                    'jam_terlambat' => $siswaData['jam_terlambat'],
                    'alasan_terlambat' => $siswaData['alasan_terlambat'],
                    'status' => $siswaData['status'],
                    'sanksi' => $siswaData['sanksi'] ?? null,
                    'catatan_petugas' => $request->catatan_batch,
                ]);
            }
        }

        return redirect()->route('kesiswaan.keterlambatan.index')
            ->with('success', 'Data batch keterlambatan berhasil diperbarui');
    }

    public function destroyBatch($tanggal, $petugas_id, $created_at)
    {
        // Decode timestamp dari URL
        $created_at = \Carbon\Carbon::parse($created_at);
        $tanggal = \Carbon\Carbon::parse($tanggal)->format('Y-m-d');
        
        // Handle null petugas_id
        $petugas_id = $petugas_id === 'null' ? null : $petugas_id;
        
        // Ambil semua record keterlambatan dalam batch yang sama
        $query = SiswaKeterlambatan::where('tanggal', $tanggal)
            ->whereRaw('ABS(TIMESTAMPDIFF(MINUTE, created_at, ?)) <= 5', [$created_at]);
            
        if ($petugas_id) {
            $query->where('petugas_id', $petugas_id);
        } else {
            $query->whereNull('petugas_id');
        }
        
        $keterlambatanBatch = $query->get();

        if ($keterlambatanBatch->isEmpty()) {
            return redirect()->route('kesiswaan.keterlambatan.index')
                ->with('error', 'Batch keterlambatan tidak ditemukan');
        }

        // Hapus semua record dalam batch
        $jumlahDihapus = $keterlambatanBatch->count();
        
        foreach ($keterlambatanBatch as $keterlambatan) {
            $keterlambatan->delete();
        }

        return redirect()->route('kesiswaan.keterlambatan.index')
            ->with('success', "Batch keterlambatan berhasil dihapus ({$jumlahDihapus} siswa)");
    }

    public function rekap(Request $request)
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        
        // Ambil input filter dari user
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalAkhir = $request->input('tanggal_akhir');
        $kelasId = $request->input('kelas_id');
        $bulanSelect = $request->input('bulan_select');
        $tahunSelect = $request->input('tahun_select');
        
        // Jika user memilih bulan dan tahun, konversi ke tanggal mulai dan akhir
        if ($bulanSelect && $tahunSelect && !$tanggalMulai && !$tanggalAkhir) {
            $date = Carbon::createFromDate($tahunSelect, $bulanSelect, 1);
            $tanggalMulai = $date->startOfMonth()->format('Y-m-d');
            $tanggalAkhir = $date->endOfMonth()->format('Y-m-d');
        }
        
        // Tandai apakah user sudah melakukan filter
        $hasFilter = ($request->has('tanggal_mulai') && $request->has('tanggal_akhir')) || 
                     ($request->has('bulan_select') && $request->has('tahun_select'));
        
        $rekapData = collect();
        
        // Hanya query data jika user sudah memilih tanggal
        if ($hasFilter) {
            $query = SiswaKeterlambatan::with(['siswa', 'kelas', 'petugas'])
                ->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
                
            if ($kelasId) {
                $query->where('kelas_id', $kelasId);
            }
            
            $rekapData = $query->orderBy('tanggal', 'desc')
                ->orderBy('created_at', 'desc')
                ->get();
        }
            
        // Statistik rekap hanya jika ada data
        $totalKeterlambatan = $rekapData->count();
        $totalSiswa = $rekapData->pluck('siswa_id')->unique()->count();
        $rekapPerKelas = $rekapData->groupBy('kelas.nama_kelas')->map(function($items) {
            return [
                'jumlah_siswa' => $items->pluck('siswa_id')->unique()->count(),
                'total_keterlambatan' => $items->count()
            ];
        });
        
        return view('kesiswaan.keterlambatan.rekap', compact(
            'kelas', 
            'rekapData', 
            'tanggalMulai', 
            'tanggalAkhir', 
            'kelasId',
            'totalKeterlambatan',
            'totalSiswa',
            'rekapPerKelas',
            'hasFilter'
        ));
    }

    public function exportRekap(Request $request)
    {
        // Validation rules - bulan & tahun atau tanggal manual harus ada
        $validationRules = [
            'export_type' => 'required|in:per_tanggal,rekap_total,periode',
        ];
        
        if ($request->has('bulan_select') && $request->has('tahun_select') && 
            $request->bulan_select && $request->tahun_select) {
            $validationRules['bulan_select'] = 'required|in:01,02,03,04,05,06,07,08,09,10,11,12';
            $validationRules['tahun_select'] = 'required|integer|min:2020|max:2030';
        } else {
            $validationRules['tanggal_mulai'] = 'required|date';
            $validationRules['tanggal_akhir'] = 'required|date|after_or_equal:tanggal_mulai';
        }
        
        $request->validate($validationRules);

        // Handle month & year selection or manual date input
        if ($request->has('bulan_select') && $request->has('tahun_select') && 
            $request->bulan_select && $request->tahun_select) {
            $date = Carbon::createFromDate($request->tahun_select, $request->bulan_select, 1);
            $tanggalMulai = $date->startOfMonth()->format('Y-m-d');
            $tanggalAkhir = $date->endOfMonth()->format('Y-m-d');
        } else {
            $tanggalMulai = $request->input('tanggal_mulai');
            $tanggalAkhir = $request->input('tanggal_akhir');
        }
        
        $kelasId = $request->input('kelas_id');
        $exportType = $request->input('export_type');
        
        $dateRange = \Carbon\Carbon::parse($tanggalMulai)->format('d-m-Y') . '_sampai_' . 
                     \Carbon\Carbon::parse($tanggalAkhir)->format('d-m-Y');
        
        if ($exportType === 'rekap_total') {
            $fileName = 'Rekap_Total_Keterlambatan_' . $dateRange . '.xlsx';
            $export = new KeterlambatanRekapTotalExport($tanggalMulai, $tanggalAkhir, $kelasId);
        } elseif ($exportType === 'periode') {
            $fileName = 'Keterlambatan_Periode_' . $dateRange . '.xlsx';
            $export = new KeterlambatanPeriodeExport($tanggalMulai, $tanggalAkhir, $kelasId);
        } else {
            $fileName = 'Keterlambatan_Per_Tanggal_' . $dateRange . '.xlsx';
            $export = new KeterlambatanMultiSheetExport($tanggalMulai, $tanggalAkhir, $kelasId);
        }
        
        return Excel::download($export, $fileName);
    }



    public function edit(SiswaKeterlambatan $keterlambatan)
    {
        $keterlambatan->load(['siswa', 'kelas']);
        $kelas = Kelas::with('jurusan')->orderBy('nama_kelas')->get();

        return view('kesiswaan.keterlambatan.edit', compact('keterlambatan', 'kelas'));
    }

    public function update(Request $request, SiswaKeterlambatan $keterlambatan)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam_terlambat' => 'required|date_format:H:i',
            'alasan_terlambat' => 'required|string|max:500',
            'status' => 'required|in:belum_ditindak,sudah_ditindak,selesai',
            'sanksi' => 'nullable|string|max:500',
            'catatan_petugas' => 'nullable|string|max:500',
        ]);

        $keterlambatan->update([
            'tanggal' => $request->tanggal,
            'jam_terlambat' => $request->jam_terlambat,
            'alasan_terlambat' => $request->alasan_terlambat,
            'status' => $request->status,
            'sanksi' => $request->sanksi,
            'catatan_petugas' => $request->catatan_petugas,
        ]);

        return redirect()->route('kesiswaan.keterlambatan.show', $keterlambatan)
            ->with('success', 'Data keterlambatan berhasil diperbarui');
    }

    public function destroy(SiswaKeterlambatan $keterlambatan)
    {
        $keterlambatan->delete();

        return redirect()->route('kesiswaan.keterlambatan.index')
            ->with('success', 'Data keterlambatan berhasil dihapus');
    }

    // API endpoint untuk mendapatkan siswa berdasarkan kelas
    public function getSiswaByKelas($kelas)
    {
        $siswa = Siswa::where('kelas_id', $kelas)
            ->where('status_siswa', 'aktif')
            ->orderBy('nama_lengkap')
            ->get(['id', 'nama_lengkap as nama', 'nis']);

        return response()->json($siswa);
    }

    // Laporan keterlambatan
    public function laporan(Request $request)
    {
        $tanggalMulai = $request->filled('tanggal_mulai')
            ? Carbon::parse($request->tanggal_mulai)
            : now()->startOfMonth();

        $tanggalSelesai = $request->filled('tanggal_selesai')
            ? Carbon::parse($request->tanggal_selesai)
            : now()->endOfMonth();

        // Statistik keterlambatan
        $statistik = SiswaKeterlambatan::whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])
            ->selectRaw('
                COUNT(*) as total_keterlambatan,
                COUNT(DISTINCT siswa_id) as total_siswa_terlambat,
                AVG(TIME_TO_SEC(jam_terlambat)) / 60 as rata_rata_menit_terlambat
            ')
            ->first();

        // Top siswa terlambat
        $topSiswaTerlambat = SiswaKeterlambatan::with(['siswa', 'kelas'])
            ->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])
            ->selectRaw('siswa_id, kelas_id, COUNT(*) as jumlah_terlambat')
            ->groupBy('siswa_id', 'kelas_id')
            ->orderByDesc('jumlah_terlambat')
            ->take(10)
            ->get();

        // Keterlambatan per kelas
        $keterlambatanPerKelas = SiswaKeterlambatan::with('kelas')
            ->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])
            ->selectRaw('kelas_id, COUNT(*) as total')
            ->groupBy('kelas_id')
            ->orderByDesc('total')
            ->get();

        // Trend keterlambatan per hari
        $trendHarian = SiswaKeterlambatan::whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])
            ->selectRaw('DATE(tanggal) as tanggal, COUNT(*) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        return view('kesiswaan.keterlambatan.laporan', compact(
            'statistik',
            'topSiswaTerlambat',
            'keterlambatanPerKelas',
            'trendHarian',
            'tanggalMulai',
            'tanggalSelesai'
        ));
    }

    private function getStatistikHariIni(): array
    {
        $hariIni = today();

        return [
            'total_terlambat' => SiswaKeterlambatan::whereDate('tanggal', $hariIni)->count(),
            'terlambat_biasa' => SiswaKeterlambatan::whereDate('tanggal', $hariIni)
                ->where('status', 'terlambat')
                ->count(),
            'izin_terlambat' => SiswaKeterlambatan::whereDate('tanggal', $hariIni)
                ->where('status', 'izin_terlambat')
                ->count(),
            'jam_paling_telat' => SiswaKeterlambatan::whereDate('tanggal', $hariIni)
                ->orderByDesc('jam_terlambat')
                ->first()?->jam_terlambat_format ?? '-',
        ];
    }
}
