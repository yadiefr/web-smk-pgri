<?php

namespace App\Exports;

use App\Models\SiswaKeterlambatan;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class KeterlambatanPeriodeExport implements FromView, ShouldAutoSize, WithTitle, WithEvents
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
        // Get all keterlambatan data in the period
        $query = SiswaKeterlambatan::with(['siswa', 'kelas', 'petugas'])
            ->whereBetween('tanggal', [$this->tanggalMulai, $this->tanggalAkhir]);

        if ($this->kelasId) {
            $query->where('siswa_keterlambatan.kelas_id', $this->kelasId);
        }

        $rekapData = $query
            ->join('kelas', 'siswa_keterlambatan.kelas_id', '=', 'kelas.id')
            ->join('siswa', 'siswa_keterlambatan.siswa_id', '=', 'siswa.id')
            ->orderBy('siswa_keterlambatan.tanggal', 'asc')
            ->orderBy('kelas.nama_kelas', 'asc')
            ->orderBy('siswa.nama_lengkap', 'asc')
            ->orderBy('siswa_keterlambatan.jam_terlambat', 'asc')
            ->select('siswa_keterlambatan.*')
            ->get();

        // Load relationships after query to ensure complete data
        $rekapData->load(['siswa', 'kelas', 'petugas']);

        return view('kesiswaan.keterlambatan.export-periode', [
            'rekapData' => $rekapData,
            'tanggalMulai' => $this->tanggalMulai,
            'tanggalAkhir' => $this->tanggalAkhir,
        ]);
    }

    public function title(): string
    {
        $dateRange = Carbon::parse($this->tanggalMulai)->format('d-m-Y') . '_sampai_' . 
                     Carbon::parse($this->tanggalAkhir)->format('d-m-Y');
        return 'KETERLAMBATAN_' . $dateRange;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
                $event->sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
                
                // Set font to Times New Roman for entire sheet
                $event->sheet->getStyle('A:Z')->getFont()->setName('Times New Roman');
            },
        ];
    }
}