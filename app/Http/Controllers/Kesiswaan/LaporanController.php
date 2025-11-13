<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Absensi;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view('kesiswaan.laporan.index');
    }

    public function laporanAbsensi(Request $request)
    {
        $tanggalMulai = $request->filled('tanggal_mulai') 
            ? Carbon::parse($request->tanggal_mulai)
            : now()->startOfMonth();
            
        $tanggalSelesai = $request->filled('tanggal_selesai')
            ? Carbon::parse($request->tanggal_selesai)
            : now()->endOfMonth();

        // Statistik absensi per status
        $absensiStats = Absensi::whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Absensi per kelas
        $absensiPerKelas = Absensi::with('kelas')
            ->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])
            ->selectRaw('kelas_id, status, COUNT(*) as total')
            ->groupBy('kelas_id', 'status')
            ->get()
            ->groupBy('kelas_id');

        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('kesiswaan.laporan.absensi', compact(
            'absensiStats', 
            'absensiPerKelas', 
            'kelas',
            'tanggalMulai',
            'tanggalSelesai'
        ));
    }

    public function laporanKegiatan(Request $request)
    {
        // Placeholder untuk laporan kegiatan
        $kegiatan = collect([]);
        
        return view('kesiswaan.laporan.kegiatan', compact('kegiatan'));
    }

    public function laporanPelanggaran(Request $request)
    {
        // Placeholder untuk laporan pelanggaran
        $pelanggaran = collect([]);
        
        return view('kesiswaan.laporan.pelanggaran', compact('pelanggaran'));
    }

    public function export(Request $request)
    {
        $jenis = $request->get('jenis', 'absensi');
        
        switch ($jenis) {
            case 'absensi':
                return $this->exportAbsensi($request);
            case 'kegiatan':
                return $this->exportKegiatan($request);
            case 'pelanggaran':
                return $this->exportPelanggaran($request);
            default:
                return redirect()->back()->with('error', 'Jenis laporan tidak valid');
        }
    }

    private function exportAbsensi(Request $request)
    {
        // Implementasi export absensi
        return redirect()->back()->with('success', 'Laporan absensi berhasil diexport');
    }

    private function exportKegiatan(Request $request)
    {
        // Implementasi export kegiatan
        return redirect()->back()->with('success', 'Laporan kegiatan berhasil diexport');
    }

    private function exportPelanggaran(Request $request)
    {
        // Implementasi export pelanggaran
        return redirect()->back()->with('success', 'Laporan pelanggaran berhasil diexport');
    }
}
