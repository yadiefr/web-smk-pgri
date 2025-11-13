<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="generator" content="PhpSpreadsheet, https://github.com/PHPOffice/PhpSpreadsheet">
    <meta name="author" content="SMK PGRI CIKAMPEK" />
    <style type="text/css">
        html { font-family: 'Times New Roman', serif; font-size: 11pt; background-color: white }
        body { margin-left: 0.7in; margin-right: 0.7in; margin-top: 0.75in; margin-bottom: 0.75in; }
        table { border-collapse: collapse; page-break-after: always; width: 100%; table-layout: fixed; border: 2px solid #000000; }
        .gridlines td { border: 1px solid #000000 !important; }
        .gridlines th { border: 1px solid #000000 !important; }
        
        /* Header Styles */
        .title { vertical-align: middle; text-align: center; font-weight: bold; color: #000000; font-family: 'Times New Roman'; font-size: 18pt; background-color: white }
        .subtitle { vertical-align: middle; text-align: center; color: #000000; font-family: 'Times New Roman'; font-size: 14pt; background-color: white }
        
        /* Info Styles */
        .info-label { vertical-align: middle; text-align: left; padding-left: 0px; color: #000000; font-family: 'Times New Roman'; font-size: 12pt; background-color: white }
        
        /* Table Header Styles */
        .table-header { vertical-align: middle; text-align: center; border: 2px solid #000000 !important; font-weight: bold; color: #000000; font-family: 'Times New Roman'; font-size: 12pt; background-color: #B4C6E7; height: 40px; padding: 8px 4px !important; line-height: 1.2; display: table-cell; }
        
        /* Table Data Styles */
        .table-data { vertical-align: middle; text-align: center; border: 1px solid #000000 !important; color: #000000; font-family: 'Times New Roman'; font-size: 11pt; background-color: white; padding: 4px; }
        .table-data-left { vertical-align: middle; text-align: left; border: 1px solid #000000 !important; color: #000000; font-family: 'Times New Roman'; font-size: 11pt; background-color: white; padding: 4px; padding-left: 8px; }
        .table-data-center { vertical-align: middle; text-align: center; border: 1px solid #000000 !important; color: #000000; font-family: 'Times New Roman'; font-size: 11pt; background-color: white; padding: 4px; }
        
        /* Footer Styles */
        .footer-text { vertical-align: middle; text-align: left; color: #000000; font-family: 'Times New Roman'; font-size: 11pt; background-color: white }
        .signature { vertical-align: middle; text-align: center; color: #000000; font-family: 'Times New Roman'; font-size: 11pt; background-color: white }
        .signature-name { vertical-align: middle; text-align: center; color: #000000; font-family: 'Times New Roman'; font-size: 11pt; background-color: white }
        
        /* Merge & Center Styles */
        .merge-center { vertical-align: middle; text-align: center; border: 1px solid #000000 !important; font-weight: bold; color: #000000; font-family: 'Times New Roman'; font-size: 12pt; background-color: #B4C6E7 }
        .merge-data { vertical-align: middle; text-align: center; border: 1px solid #000000 !important; color: #000000; font-family: 'Times New Roman'; font-size: 11pt; background-color: white }
        
        /* Column widths for summary */
        .col-no { width: 40px !important; max-width: 40px; min-width: 40px; }
        .col-nama { width: 250px !important; max-width: 250px; min-width: 250px; }
        .col-kelas { width: 80px !important; max-width: 80px; min-width: 80px; }
        .col-total { width: 150px !important; max-width: 150px; min-width: 150px; }
        
        /* Table column settings for summary */
        table.sheet0 col.col0 { width: 40px }
        table.sheet0 col.col1 { width: 250px }
        table.sheet0 col.col2 { width: 80px }
        table.sheet0 col.col3 { width: 150px }
    </style>
</head>
<body>
    <table border="0" cellpadding="0" cellspacing="0" class="gridlines sheet0">
        <!-- Column Definitions -->
        <col class="col-no col0" width="40" style="width: 40px;">
        <col class="col-nama col1" width="250" style="width: 250px;">
        <col class="col-kelas col2" width="80" style="width: 80px;">
        <col class="col-total col3" width="150" style="width: 150px;">
        
        <!-- Header Section -->
        <tr>
            <td colspan="4" class="title" style="text-align: center; padding: 10px 0;">REKAP TOTAL KETERLAMBATAN SISWA</td>
        </tr>
        <tr>
            <td colspan="4" class="title" style="text-align: center; padding: 10px 0;">SMK PGRI CIKAMPEK</td>
        </tr>
        <tr>
            <td colspan="4" class="subtitle" style="text-align: center; padding: 10px 0;">TAHUN AJARAN {{ date('Y') }}-{{ date('Y') + 1 }}</td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        
        <!-- Info Section -->
        <tr>
            <td>&nbsp;</td>
            <td class="info-label" colspan="3" style="text-align: left; padding: 4px;">PERIODE : {{ \Carbon\Carbon::parse($tanggalMulai)->locale('id')->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($tanggalAkhir)->locale('id')->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        
        @if($summaryData->count() > 0)
        <!-- Table Header -->
        <tr style="height: 40px;">
            <td class="table-header col-no" style="width: 40px; text-align: center; vertical-align: middle; border: 2px solid #000000 !important; font-weight: bold; padding: 8px 4px; height: 40px;">NO</td>
            <td class="table-header col-nama" style="width: 250px; text-align: center; vertical-align: middle; border: 2px solid #000000 !important; font-weight: bold; padding: 8px 4px; height: 40px;">NAMA SISWA</td>
            <td class="table-header col-kelas" style="width: 80px; text-align: center; vertical-align: middle; border: 2px solid #000000 !important; font-weight: bold; padding: 8px 4px; height: 40px;">KELAS</td>
            <td class="table-header col-total" style="width: 150px; text-align: center; vertical-align: middle; border: 2px solid #000000 !important; font-weight: bold; padding: 8px 4px; height: 40px;">TOTAL TERLAMBAT</td>
        </tr>
        
        <!-- Table Data -->
        @foreach($summaryData as $index => $data)
        <tr>
            <td class="table-data" style="width: 40px; text-align: center; vertical-align: middle; border: 1px solid #000000 !important; padding: 4px;">{{ $index + 1 }}</td>
            <td class="table-data-left" style="width: 250px; text-align: left; vertical-align: middle; border: 1px solid #000000 !important; padding: 4px; padding-left: 8px;">{{ $data->siswa->nama_lengkap }}</td>
            <td class="table-data" style="width: 80px; text-align: center; vertical-align: middle; border: 1px solid #000000 !important; padding: 4px;">{{ $data->kelas->nama_kelas }}</td>
            <td class="table-data-center" style="width: 150px; text-align: center; vertical-align: middle; border: 1px solid #000000 !important; padding: 4px; font-weight: bold;">{{ $data->total_terlambat }} KALI</td>
        </tr>
        @endforeach
        
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        
        <!-- Footer Section -->
        <tr>
            <td>&nbsp;</td>
            <td class="footer-text" colspan="3" style="text-align: left; padding: 4px;">KETERANGAN : Data keterlambatan periode {{ \Carbon\Carbon::parse($tanggalMulai)->locale('id')->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($tanggalAkhir)->locale('id')->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
            <td colspan="2" class="signature" style="text-align: center; padding: 10px 0;">Wakil Wakasek Kesiswaan</td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
            <td colspan="2" class="signature-name" style="text-align: center; padding: 5px 0;">Ridwan Surya Permana</td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        @else
        <!-- No Data Message -->
        <tr>
            <td colspan="4" class="merge-center" style="text-align: center; padding: 20px 0; border: 1px solid #000000 !important;">TIDAK ADA DATA KETERLAMBATAN PADA PERIODE TERSEBUT</td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
            <td colspan="2" class="signature" style="text-align: center; padding: 10px 0;">Wakil Wakasek Kesiswaan</td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
            <td colspan="2" class="signature-name" style="text-align: center; padding: 5px 0;">Ridwan Surya Permana</td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        @endif
    </table>
</body>
</html>