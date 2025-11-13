<?php

namespace App\Exports;

use App\Models\SiswaKeterlambatan;
use App\Models\Kelas;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class RekapKeterlambatanExport implements FromView, ShouldAutoSize, WithTitle
{
    protected $tanggalMulai;
    protected $tanggalAkhir;
    protected $kelasId;

    public function __construct($tanggalMulai, $tanggalAkhir, $kelasId = null)
    {
        $this->tanggalMulai = $tanggalMulai;
        $this->tanggalAkhir = $tanggalAkhir;
        $this->kelasId = $kelasId;
    }

    public function view(): View
    {
        $query = SiswaKeterlambatan::with(['siswa', 'kelas', 'petugas'])
            ->whereBetween('tanggal', [$this->tanggalMulai, $this->tanggalAkhir]);
            
        if ($this->kelasId) {
            $query->where('kelas_id', $this->kelasId);
        }
        
        $rekapData = $query->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Statistik rekap
        $totalKeterlambatan = $rekapData->count();
        $totalSiswa = $rekapData->pluck('siswa_id')->unique()->count();
        $rekapPerKelas = $rekapData->groupBy('kelas.nama_kelas')->map(function($items) {
            return [
                'jumlah_siswa' => $items->pluck('siswa_id')->unique()->count(),
                'total_keterlambatan' => $items->count()
            ];
        });
        
        $kelasTerpilih = $this->kelasId ? Kelas::find($this->kelasId) : null;

        return view('kesiswaan.keterlambatan.export', compact(
            'rekapData',
            'totalKeterlambatan',
            'totalSiswa',
            'rekapPerKelas',
            'kelasTerpilih'
        ))->with([
            'tanggalMulai' => $this->tanggalMulai,
            'tanggalAkhir' => $this->tanggalAkhir,
        ]);
    }
    
    public function title(): string
    {
        return 'Rekap Keterlambatan';
    }
}