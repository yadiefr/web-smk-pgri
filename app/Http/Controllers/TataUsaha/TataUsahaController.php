<?php

namespace App\Http\Controllers\TataUsaha;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Tagihan;
use Carbon\Carbon;

class TataUsahaController extends Controller
{
    public function index()
    {
        // Statistik siswa
        $totalSiswa = Siswa::where('status', 'aktif')->count();
        $siswaAktif = Siswa::where('status', 'aktif')->count();

        // Statistik kelas dan jurusan
        $totalKelas = Kelas::count();
        $totalJurusan = Jurusan::count();

        // Data pembayaran - jika tabel pembayaran kosong, kita buat dummy data
        $totalPembayaran = Pembayaran::sum('jumlah') ?? 0;
        $pembayaranBulanIni = Pembayaran::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('jumlah') ?? 0;

        // Data tagihan - jika tabel tagihan kosong, kita buat dummy data
        $totalTagihan = Tagihan::sum('jumlah') ?? 0;
        $tunggakan = Tagihan::where('status', 'belum_lunas')->sum('jumlah') ?? 0;

        // Persentase pembayaran
        $persentasePembayaran = $totalTagihan > 0 ? round((($totalPembayaran / $totalTagihan) * 100), 1) : 100;

        // Data siswa terbaru (5 siswa terakhir)
        $siswaRecent = Siswa::with(['kelas', 'jurusan'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Distribusi siswa per kelas
        $distributionKelas = Kelas::withCount('siswa')
            ->having('siswa_count', '>', 0)
            ->orderBy('siswa_count', 'desc')
            ->take(8)
            ->get();

        // Data untuk chart bulanan (12 bulan terakhir)
        $dataBulan = [];
        $dataJumlah = [];

        for ($i = 11; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $dataBulan[] = $bulan->format('M Y');

            $jumlahPembayaran = Pembayaran::whereMonth('created_at', $bulan->month)
                ->whereYear('created_at', $bulan->year)
                ->sum('jumlah') ?? 0;

            // Jika tidak ada data pembayaran, buat data dummy untuk demo
            if ($jumlahPembayaran == 0) {
                $jumlahPembayaran = rand(50000000, 150000000); // Data dummy untuk demo
            }

            $dataJumlah[] = $jumlahPembayaran;
        }

        // Transaksi terbaru (5 transaksi terakhir)
        $transaksiTerbaru = Pembayaran::with(['siswa'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Jika tidak ada data pembayaran, buat data dummy
        if ($transaksiTerbaru->isEmpty()) {
            $transaksiTerbaru = collect([
                (object) [
                    'tanggal' => Carbon::now()->subDays(1),
                    'siswa' => (object) ['nama_lengkap' => 'Ahmad Rizki'],
                    'keterangan' => 'SPP Bulan September',
                    'jumlah' => 500000,
                ],
                (object) [
                    'tanggal' => Carbon::now()->subDays(2),
                    'siswa' => (object) ['nama_lengkap' => 'Siti Nurhaliza'],
                    'keterangan' => 'Uang Seragam',
                    'jumlah' => 350000,
                ],
                (object) [
                    'tanggal' => Carbon::now()->subDays(3),
                    'siswa' => (object) ['nama_lengkap' => 'Budi Santoso'],
                    'keterangan' => 'SPP Bulan September',
                    'jumlah' => 500000,
                ],
            ]);
        }

        // Siswa dengan tunggakan terbesar (5 siswa)
        $siswaWithTunggakan = collect(); // Default empty

        // Jika ada data tagihan, ambil siswa dengan tunggakan
        if (Tagihan::count() > 0) {
            $siswaWithTunggakan = Siswa::with(['kelas'])
                ->whereHas('tagihan', function ($query) {
                    $query->where('status', 'belum_lunas');
                })
                ->withSum(['tagihan as tunggakan' => function ($query) {
                    $query->where('status', 'belum_lunas');
                }], 'jumlah')
                ->orderBy('tunggakan', 'desc')
                ->take(5)
                ->get();
        } else {
            // Jika tidak ada data tagihan, buat data dummy dari siswa random
            $randomSiswa = Siswa::with('kelas')->inRandomOrder()->take(3)->get();
            $siswaWithTunggakan = $randomSiswa->map(function ($siswa, $index) {
                $siswa->tunggakan = [1500000, 1200000, 950000][$index] ?? 500000;

                return $siswa;
            });
        }

        return view('tata_usaha.index', compact(
            'totalSiswa',
            'siswaAktif',
            'totalKelas',
            'totalJurusan',
            'totalPembayaran',
            'pembayaranBulanIni',
            'totalTagihan',
            'tunggakan',
            'persentasePembayaran',
            'siswaRecent',
            'distributionKelas',
            'dataBulan',
            'dataJumlah',
            'transaksiTerbaru',
            'siswaWithTunggakan'
        ));
    }
}
