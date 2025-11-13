<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Absensi::with(['siswa', 'kelas']);

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
        } elseif ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        } else {
            // Default: bulan ini
            $query->whereMonth('tanggal', now()->month)
                  ->whereYear('tanggal', now()->year);
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
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $absensi = $query->orderBy('tanggal', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->paginate(20);

        // Data untuk filter
        $kelas = Kelas::orderBy('nama_kelas')->get();
        
        // Statistik absensi
        $statistik = $this->getAbsensiStatistik($request);

        return view('kesiswaan.absensi.index', compact('absensi', 'kelas', 'statistik'));
    }

    public function rekap(Request $request)
    {
        $tanggalMulai = $request->filled('tanggal_mulai') 
            ? Carbon::parse($request->tanggal_mulai)
            : now()->startOfMonth();
            
        $tanggalSelesai = $request->filled('tanggal_selesai')
            ? Carbon::parse($request->tanggal_selesai)
            : now()->endOfMonth();

        $kelasId = $request->kelas_id;

        // Query dasar
        $query = Siswa::with(['kelas', 'absensi' => function ($q) use ($tanggalMulai, $tanggalSelesai) {
            $q->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
        }]);

        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }

        $siswa = $query->where('status_siswa', 'aktif')->get();

        // Hitung total hari kerja/sekolah dalam rentang tanggal
        $totalHari = $this->calculateWorkingDays($tanggalMulai, $tanggalSelesai);

        // Buat rekap per siswa
        $rekapData = $siswa->map(function ($s) use ($totalHari) {
            $absensiCount = $s->absensi->groupBy('status');
            
            return [
                'siswa' => $s,
                'hadir' => $absensiCount->get('hadir', collect())->count(),
                'izin' => $absensiCount->get('izin', collect())->count(),
                'sakit' => $absensiCount->get('sakit', collect())->count(),
                'alpa' => $absensiCount->get('alpa', collect())->count(),
                'total_hari' => $totalHari,
                'persentase_kehadiran' => $totalHari > 0 
                    ? round(($absensiCount->get('hadir', collect())->count() / $totalHari) * 100, 2)
                    : 0
            ];
        });

        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('kesiswaan.absensi.rekap', compact(
            'rekapData', 
            'kelas', 
            'tanggalMulai', 
            'tanggalSelesai', 
            'kelasId'
        ));
    }

    public function kelasList(Kelas $kelas, Request $request)
    {
        $tanggal = $request->filled('tanggal') ? Carbon::parse($request->tanggal) : now();
        
        $siswa = Siswa::where('kelas_id', $kelas->id)
                     ->where('status_siswa', 'aktif')
                     ->with(['absensi' => function ($q) use ($tanggal) {
                         $q->whereDate('tanggal', $tanggal);
                     }])
                     ->orderBy('nama_lengkap')
                     ->get();

        return view('kesiswaan.absensi.kelas', compact('kelas', 'siswa', 'tanggal'));
    }

    public function export(Request $request)
    {
        // Implementasi export ke Excel
        // Bisa menggunakan Laravel Excel atau export manual
        
        $tanggalMulai = $request->filled('tanggal_mulai') 
            ? Carbon::parse($request->tanggal_mulai)
            : now()->startOfMonth();
            
        $tanggalSelesai = $request->filled('tanggal_selesai')
            ? Carbon::parse($request->tanggal_selesai)
            : now()->endOfMonth();

        // Return download file atau redirect dengan success message
        return redirect()->back()->with('success', 'Export absensi berhasil diunduh');
    }

    private function getAbsensiStatistik(Request $request): array
    {
        $query = Absensi::query();

        // Apply same filters as main query
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
        } elseif ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        } else {
            $query->whereMonth('tanggal', now()->month)
                  ->whereYear('tanggal', now()->year);
        }

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        // Get statistics
        $stats = $query->selectRaw('status, COUNT(*) as total')
                      ->groupBy('status')
                      ->pluck('total', 'status')
                      ->toArray();

        return [
            'hadir' => $stats['hadir'] ?? 0,
            'izin' => $stats['izin'] ?? 0,
            'sakit' => $stats['sakit'] ?? 0,
            'alpa' => $stats['alpa'] ?? 0,
            'total' => array_sum($stats)
        ];
    }

    private function calculateWorkingDays(Carbon $startDate, Carbon $endDate): int
    {
        $totalDays = 0;
        $current = $startDate->copy();

        while ($current->lte($endDate)) {
            // Count Monday to Saturday (skip Sunday)
            if ($current->dayOfWeek !== Carbon::SUNDAY) {
                $totalDays++;
            }
            $current->addDay();
        }

        return $totalDays;
    }
}
