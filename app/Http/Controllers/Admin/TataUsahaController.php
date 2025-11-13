<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Exports\KeuanganRingkasanExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class TataUsahaController extends Controller
{
    /**
     * Menampilkan dashboard Tata Usaha
     */
    public function index()
    {
        // Mengambil data untuk dashboard Tata Usaha
        $totalSiswa = Siswa::where('status', 'aktif')->count();
        $totalPembayaran = Pembayaran::sum('jumlah');
        $totalTagihan = Tagihan::sum('nominal');
        $tunggakan = $totalTagihan - $totalPembayaran;
        
        // Persentase pembayaran (rasio pembayaran dibanding total tagihan)
        $persentasePembayaran = $totalTagihan > 0 ? round(($totalPembayaran / $totalTagihan) * 100) : 0;

        // Mengambil data pembayaran bulanan untuk grafik
        $pembayaranBulanan = Pembayaran::selectRaw('MONTH(tanggal) as bulan, YEAR(tanggal) as tahun, SUM(jumlah) as total')
            ->whereYear('tanggal', date('Y'))
            ->groupBy('bulan', 'tahun')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();
        
        // Format data untuk grafik
        $dataBulan = [];
        $dataJumlah = [];
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        foreach ($pembayaranBulanan as $pb) {
            $dataBulan[] = $namaBulan[$pb->bulan];
            $dataJumlah[] = $pb->total;
        }
        
        // Mengambil 10 transaksi terbaru
        $transaksiTerbaru = Pembayaran::with('siswa')
            ->orderBy('tanggal', 'desc')
            ->take(10)
            ->get();

        // Mengambil 10 siswa dengan tunggakan terbesar
        $siswaWithTunggakan = Siswa::with(['kelas', 'pembayaran'])
            ->where('status', 'aktif')
            ->get()
            ->map(function($siswa) {
                // Hitung total tagihan untuk siswa
                $tagihanSiswa = Tagihan::where(function($q) use ($siswa) {
                    $q->whereNull('kelas_id')->whereNull('siswa_id')  // Tagihan global
                      ->orWhere('kelas_id', $siswa->kelas_id)         // Tagihan kelas
                      ->orWhere('siswa_id', $siswa->id);              // Tagihan spesifik
                })->sum('nominal');
                
                // Total yang sudah dibayar
                $totalDibayar = $siswa->pembayaran->sum('jumlah');
                
                $siswa->tunggakan = max(0, $tagihanSiswa - $totalDibayar);
                return $siswa;
            })
            ->sortByDesc('tunggakan')
            ->take(10);
        
        return view('tata_usaha.index', compact(
            'totalSiswa', 
            'totalPembayaran', 
            'totalTagihan', 
            'tunggakan', 
            'persentasePembayaran',
            'dataBulan',
            'dataJumlah',
            'transaksiTerbaru',
            'siswaWithTunggakan'
        ));
    }
    
    /**
     * Menampilkan laporan keuangan
     */
    public function laporan(Request $request)
    {
        $tahunAjaran = $request->input('tahun_ajaran', date('Y'));
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $kelasId = $request->input('kelas_id');
        
        // Query untuk laporan keuangan
        $query = Pembayaran::with(['siswa.kelas'])
            ->whereHas('siswa', function($q) {
                $q->where('status', 'aktif');
            })
            ->whereYear('tanggal', $tahunAjaran);
        
        // Filter berdasarkan kelas jika dipilih
        if ($kelasId) {
            $query->whereHas('siswa', function($q) use ($kelasId) {
                $q->where('kelas_id', $kelasId);
            });
        }
        
        $pembayaranList = $query->orderBy('tanggal', 'desc')->get();
        
        // Mengelompokkan pembayaran per kelas
        $pembayaranPerKelas = $pembayaranList->groupBy(function($item) {
            return $item->siswa->kelas->nama_kelas ?? 'Tidak Ada Kelas';
        });
        
        // Menghitung total per kelas
        $totalPerKelas = [];
        foreach ($pembayaranPerKelas as $kelas => $pembayaran) {
            $totalPerKelas[$kelas] = $pembayaran->sum('jumlah');
        }
        
        // Statistik tunggakan per kelas
        $tunggakanPerKelas = [];
        foreach ($kelasList as $kelas) {
            $siswaKelas = Siswa::where('kelas_id', $kelas->id)->where('status', 'aktif')->get();
            $totalTagihanKelas = 0;
            $totalBayarKelas = 0;
            
            foreach ($siswaKelas as $siswa) {
                // Hitung tagihan untuk siswa
                $tagihanSiswa = Tagihan::where(function($q) use ($siswa) {
                    $q->whereNull('kelas_id')->whereNull('siswa_id')
                      ->orWhere('kelas_id', $siswa->kelas_id)
                      ->orWhere('siswa_id', $siswa->id);
                })->sum('nominal');
                
                // Hitung pembayaran siswa
                $bayarSiswa = Pembayaran::where('siswa_id', $siswa->id)->sum('jumlah');
                
                $totalTagihanKelas += $tagihanSiswa;
                $totalBayarKelas += $bayarSiswa;
            }
            
            $tunggakanKelas = max(0, $totalTagihanKelas - $totalBayarKelas);
            $persentaseBayarKelas = $totalTagihanKelas > 0 ? round(($totalBayarKelas / $totalTagihanKelas) * 100) : 0;
            
            $tunggakanPerKelas[$kelas->nama_kelas] = [
                'total_tagihan' => $totalTagihanKelas,
                'total_bayar' => $totalBayarKelas,
                'tunggakan' => $tunggakanKelas,
                'persentase_bayar' => $persentaseBayarKelas
            ];
        }
        
        return view('tata_usaha.laporan', compact(
            'tahunAjaran',
            'kelasList',
            'kelasId',
            'pembayaranList',
            'pembayaranPerKelas',
            'totalPerKelas',
            'tunggakanPerKelas'
        ));
    }
    
    /**
     * Mengekspor data keuangan ke Excel
     */
    public function export(Request $request)
    {
        $tahunAjaran = $request->input('tahun_ajaran', date('Y'));
        $kelasId = $request->input('kelas_id');
        
        $fileName = 'laporan_keuangan_';
        if ($kelasId) {
            $kelas = Kelas::find($kelasId);
            $fileName .= 'kelas_' . str_replace(' ', '_', $kelas->nama_kelas ?? 'unknown');
        } else {
            $fileName .= 'semua_kelas';
        }
        $fileName .= '_' . $tahunAjaran . '.xlsx';
        
        return Excel::download(new KeuanganRingkasanExport($tahunAjaran, $kelasId), $fileName);
    }
}
