<?php

namespace App\Exports;

use App\Models\SiswaKeterlambatan;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class KeterlambatanMultiSheetExport implements WithMultipleSheets
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

    public function sheets(): array
    {
        $sheets = [];

        // Get all unique dates in the range
        $query = SiswaKeterlambatan::whereBetween('tanggal', [$this->tanggalMulai, $this->tanggalAkhir]);

        if ($this->kelasId) {
            $query->where('siswa_keterlambatan.kelas_id', $this->kelasId);
        }

        $tanggalList = $query->selectRaw('DATE(tanggal) as tanggal')
            ->distinct()
            ->orderBy('tanggal')
            ->pluck('tanggal')
            ->toArray();

        // Create sheet for each date
        foreach ($tanggalList as $tanggal) {
            $dataKeterlambatan = SiswaKeterlambatan::with(['siswa', 'kelas', 'petugas'])
                ->whereDate('tanggal', $tanggal);

            if ($this->kelasId) {
                $dataKeterlambatan->where('siswa_keterlambatan.kelas_id', $this->kelasId);
            }

            $dataKeterlambatan = $dataKeterlambatan
                ->join('kelas', 'siswa_keterlambatan.kelas_id', '=', 'kelas.id')
                ->join('siswa', 'siswa_keterlambatan.siswa_id', '=', 'siswa.id')
                ->orderBy('kelas.nama_kelas', 'asc')
                ->orderBy('siswa.nama_lengkap', 'asc')
                ->orderBy('siswa_keterlambatan.jam_terlambat', 'asc')
                ->select('siswa_keterlambatan.*')
                ->get();

            // Load relasi setelah query untuk memastikan data lengkap
            $dataKeterlambatan->load(['siswa', 'kelas', 'petugas']);

            if ($dataKeterlambatan->count() > 0) {
                $tanggalFormatted = Carbon::parse($tanggal)->format('d-m-Y');
                $sheets[] = new KeterlambatanSheetExport($dataKeterlambatan, $tanggal, $tanggalFormatted);
            }
        }

        // Add summary sheet at the end
        $sheets[] = new KeterlambatanSummarySheetExport($this->tanggalMulai, $this->tanggalAkhir, $this->kelasId);

        return $sheets;
    }
}

class KeterlambatanSheetExport implements FromView, ShouldAutoSize, WithTitle, WithEvents
{
    protected $data;

    protected $tanggalRaw;

    protected $tanggalFormatted;

    public function __construct($data, $tanggalRaw, $tanggalFormatted)
    {
        $this->data = $data;
        $this->tanggalRaw = $tanggalRaw;
        $this->tanggalFormatted = $tanggalFormatted;
    }

    public function view(): View
    {
        return view('kesiswaan.keterlambatan.export-per-tanggal', [
            'rekapData' => $this->data,
            'tanggalMulai' => $this->tanggalRaw,
            'tanggalAkhir' => $this->tanggalRaw,
        ]);
    }

    public function title(): string
    {
        return $this->tanggalFormatted;
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

class KeterlambatanSummarySheetExport implements FromView, ShouldAutoSize, WithTitle, WithEvents
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
        return 'REKAP TOTAL';
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
