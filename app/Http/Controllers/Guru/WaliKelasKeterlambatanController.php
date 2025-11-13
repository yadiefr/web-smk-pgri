<?php

namespace App\Http\Controllers\Guru;

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
use Illuminate\Support\Facades\Auth;

class WaliKelasKeterlambatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:guru');
        $this->middleware(function ($request, $next) {
            $guru = Auth::guard('guru')->user();
            if (!$guru->is_wali_kelas) {
                return redirect()->route('guru.dashboard')->with('error', 'Anda tidak memiliki akses sebagai Wali Kelas');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $guru = Auth::guard('guru')->user();
        $kelas = $guru->kelasWali;
        
        if (!$kelas) {
            return redirect()->route('guru.dashboard')->with('error', 'Anda belum ditugaskan sebagai wali kelas');
        }

        // Ambil data keterlambatan siswa di kelas yang diampu
        $query = SiswaKeterlambatan::with(['siswa', 'kelas', 'petugas'])
            ->where('kelas_id', $kelas->id);

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
        } elseif ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        } else {
            // Default: 1 bulan terakhir
            $query->where('tanggal', '>=', now()->subMonth()->startOfMonth())
                  ->where('tanggal', '<=', now()->endOfMonth());
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

        $keterlambatan = $query->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Statistik untuk kelas ini
        $totalKeterlambatan = SiswaKeterlambatan::where('kelas_id', $kelas->id)
            ->whereBetween('tanggal', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();
            
        $siswaTerlambatBulanIni = SiswaKeterlambatan::where('kelas_id', $kelas->id)
            ->whereBetween('tanggal', [now()->startOfMonth(), now()->endOfMonth()])
            ->distinct('siswa_id')
            ->count();

        $keterlambatanHariIni = SiswaKeterlambatan::where('kelas_id', $kelas->id)
            ->whereDate('tanggal', today())
            ->count();

        return view('guru.wali-kelas.keterlambatan.index', compact(
            'keterlambatan',
            'kelas',
            'totalKeterlambatan',
            'siswaTerlambatBulanIni',
            'keterlambatanHariIni'
        ));
    }

    public function rekap(Request $request)
    {
        $guru = Auth::guard('guru')->user();
        $kelas = $guru->kelasWali;
        
        if (!$kelas) {
            return redirect()->route('guru.dashboard')->with('error', 'Anda belum ditugaskan sebagai wali kelas');
        }
        
        // Ambil input filter dari user
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalAkhir = $request->input('tanggal_akhir');
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
        
        // Hanya query data jika user sudah memilih tanggal, dan selalu filter berdasarkan kelas wali
        if ($hasFilter) {
            $query = SiswaKeterlambatan::with(['siswa', 'kelas', 'petugas'])
                ->where('kelas_id', $kelas->id)
                ->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
            
            $rekapData = $query->orderBy('tanggal', 'desc')
                ->orderBy('created_at', 'desc')
                ->get();
        }
            
        // Statistik rekap hanya untuk kelas ini jika ada data
        $totalKeterlambatan = $rekapData->count();
        $totalSiswa = $rekapData->pluck('siswa_id')->unique()->count();
        $rekapPerKelas = collect([$kelas->nama_kelas => [
            'jumlah_siswa' => $totalSiswa,
            'total_keterlambatan' => $totalKeterlambatan
        ]]);
        
        return view('guru.wali-kelas.keterlambatan.rekap', compact(
            'kelas', 
            'rekapData', 
            'tanggalMulai', 
            'tanggalAkhir', 
            'totalKeterlambatan',
            'totalSiswa',
            'rekapPerKelas',
            'hasFilter'
        ));
    }

    public function exportRekap(Request $request)
    {
        $guru = Auth::guard('guru')->user();
        $kelas = $guru->kelasWali;
        
        if (!$kelas) {
            return redirect()->route('guru.dashboard')->with('error', 'Anda belum ditugaskan sebagai wali kelas');
        }

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
        
        // Selalu filter berdasarkan kelas wali
        $kelasId = $kelas->id;
        $exportType = $request->input('export_type');
        
        $dateRange = \Carbon\Carbon::parse($tanggalMulai)->format('d-m-Y') . '_sampai_' . 
                     \Carbon\Carbon::parse($tanggalAkhir)->format('d-m-Y');
        
        $kelasName = str_replace(' ', '_', $kelas->nama_kelas);
        
        if ($exportType === 'rekap_total') {
            $fileName = 'Rekap_Total_Keterlambatan_' . $kelasName . '_' . $dateRange . '.xlsx';
            $export = new KeterlambatanRekapTotalExport($tanggalMulai, $tanggalAkhir, $kelasId);
        } elseif ($exportType === 'periode') {
            $fileName = 'Keterlambatan_Periode_' . $kelasName . '_' . $dateRange . '.xlsx';
            $export = new KeterlambatanPeriodeExport($tanggalMulai, $tanggalAkhir, $kelasId);
        } else {
            $fileName = 'Keterlambatan_Per_Tanggal_' . $kelasName . '_' . $dateRange . '.xlsx';
            $export = new KeterlambatanMultiSheetExport($tanggalMulai, $tanggalAkhir, $kelasId);
        }
        
        return Excel::download($export, $fileName);
    }
}