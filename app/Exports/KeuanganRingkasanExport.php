<?php

namespace App\Exports;

use App\Models\Pembayaran;
use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KeuanganRingkasanExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize, WithStyles
{
    protected $tahunAjaran;
    protected $kelasId;
    
    public function __construct($tahunAjaran = null, $kelasId = null)
    {
        $this->tahunAjaran = $tahunAjaran ?? date('Y');
        $this->kelasId = $kelasId;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Pembayaran::with(['siswa.kelas'])
            ->whereHas('siswa', function($q) {
                $q->where('status', 'aktif');
            })
            ->whereYear('tanggal', $this->tahunAjaran);
            
        if ($this->kelasId) {
            $query->whereHas('siswa', function($q) {
                $q->where('kelas_id', $this->kelasId);
            });
        }
        
        return $query->orderBy('tanggal', 'desc')->get();
    }
    
    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No.',
            'Tanggal Pembayaran',
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Keterangan',
            'Jumlah',
            'Status'
        ];
    }
    
    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        static $i = 0;
        $i++;
        
        return [
            $i,
            $row->tanggal ? \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') : '-',
            $row->siswa->nis ?? '-',
            $row->siswa->nama_lengkap ?? 'Tidak ada data',
            $row->siswa->kelas->nama_kelas ?? 'Tidak ada kelas',
            $row->keterangan,
            $row->jumlah,
            $row->status
        ];
    }
    
    /**
     * @return string
     */
    public function title(): string
    {
        $title = 'Laporan Keuangan ' . $this->tahunAjaran;
        if ($this->kelasId) {
            $kelas = Kelas::find($this->kelasId);
            if ($kelas) {
                $title .= ' - ' . $kelas->nama_kelas;
            }
        }
        
        return $title;
    }
    
    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $sheet->getStyle('A1:H1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        // Auto filter
        $sheet->setAutoFilter($sheet->calculateWorksheetDimension());
        
        // Format currency for Jumlah column
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('G2:G'.$lastRow)->getNumberFormat()->setFormatCode('#,##0');
        
        // Add total row
        $totalRow = $lastRow + 1;
        $sheet->setCellValue('F'.$totalRow, 'TOTAL');
        $sheet->setCellValue('G'.$totalRow, '=SUM(G2:G'.$lastRow.')');
        $sheet->getStyle('F'.$totalRow.':G'.$totalRow)->getFont()->setBold(true);
        $sheet->getStyle('G'.$totalRow)->getNumberFormat()->setFormatCode('#,##0');
        
        return $sheet;
    }
}
