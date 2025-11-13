<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics for Kesiswaan dashboard
        $totalSiswa = Siswa::count();
        $totalKelas = Kelas::count();
        $siswaAktif = Siswa::where('status', 'aktif')->count();
        $siswaNonaktif = Siswa::where('status', 'nonaktif')->count();
        
        // Recent attendance data
        $recentAbsensi = Absensi::with(['siswa', 'kelas'])
            ->orderBy('tanggal', 'desc')
            ->limit(10)
            ->get();
        
        // Attendance statistics for current month
        $currentMonth = now()->format('Y-m');
        $absensiStats = Absensi::where('tanggal', 'like', $currentMonth.'%')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
        
        // Class statistics
        $kelasStats = Kelas::withCount('siswa')
            ->orderBy('nama_kelas')
            ->get();
        
        // Monthly attendance trend (last 6 months)
        $monthlyTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthKey = $month->format('Y-m');
            $monthName = $month->format('M Y');
            
            $hadir = Absensi::where('tanggal', 'like', $monthKey.'%')
                ->where('status', 'hadir')
                ->count();
            
            $monthlyTrend[] = [
                'month' => $monthName,
                'hadir' => $hadir
            ];
        }

        return view('kesiswaan.dashboard', compact(
            'totalSiswa',
            'totalKelas', 
            'siswaAktif',
            'siswaNonaktif',
            'recentAbsensi',
            'absensiStats',
            'kelasStats',
            'monthlyTrend'
        ));
    }
}
