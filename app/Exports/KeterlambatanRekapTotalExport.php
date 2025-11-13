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

class KeterlambatanRekapTotalExport implements FromView, ShouldAutoSize, WithTitle, WithEvents
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
        // Get summary data
        $query = SiswaKeterlambatan::with(['siswa', 'kelas'])
            ->whereBetween('tanggal', [$this->tanggalMulai, $this->tanggalAkhir]);

        if ($this->kelasId) {
            $query->where('siswa_keterlambatan.kelas_id', $this->kelasId);
        }

        $summaryData = $query
            ->selectRaw('siswa_keterlambatan.siswa_id, siswa_keterlambatan.kelas_id, COUNT(*) as total_terlambat')
            ->groupBy('siswa_keterlambatan.siswa_id', 'siswa_keterlambatan.kelas_id')
            ->orderByRaw('MAX(kelas.nama_kelas) ASC, MAX(siswa.nama_lengkap) ASC')
            ->join('kelas', 'siswa_keterlambatan.kelas_id', '=', 'kelas.id')
            ->join('siswa', 'siswa_keterlambatan.siswa_id', '=', 'siswa.id')
            ->get()
            ->load(['siswa', 'kelas']);

        return view('kesiswaan.keterlambatan.export-summary', [
            'summaryData' => $summaryData,
            'tanggalMulai' => $this->tanggalMulai,
            'tanggalAkhir' => $this->tanggalAkhir,
        ]);
    }

    public function title(): string
    {
        return 'REKAP TOTAL KETERLAMBATAN';
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