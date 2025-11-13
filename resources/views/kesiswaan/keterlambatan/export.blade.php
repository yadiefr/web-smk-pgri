<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="generator" content="PhpSpreadsheet, https://github.com/PHPOffice/PhpSpreadsheet">
    <meta name="author" content="SMK PGRI CIKAMPEK" />
    <style type="text/css">
        html { font-family: 'Times New Roman', serif; font-size: 11pt; background-color: white }
        body { margin-left: 0.7in; margin-right: 0.7in; margin-top: 0.75in; margin-bottom: 0.75in; }
        table { border-collapse: collapse; page-break-after: always; width: 100%; table-layout: fixed; }
        .gridlines td { border: 1px dotted black }
        .gridlines th { border: 1px dotted black }
        
        /* Header Styles */
        .title { vertical-align: middle; text-align: center; font-weight: bold; color: #000000; font-family: 'Times New Roman'; font-size: 18pt; background-color: white }
        .subtitle { vertical-align: middle; text-align: center; color: #000000; font-family: 'Times New Roman'; font-size: 14pt; background-color: white }
        
        /* Info Styles */
        .info-label { vertical-align: middle; text-align: left; padding-left: 0px; color: #000000; font-family: 'Times New Roman'; font-size: 12pt; background-color: white }
        
        /* Table Header Styles */
        .table-header { vertical-align: middle; text-align: center; border: 1px solid #000000 !important; font-weight: bold; color: #000000; font-family: 'Times New Roman'; font-size: 12pt; background-color: #B4C6E7 }
        
        /* Table Data Styles */
        .table-data { vertical-align: middle; text-align: center; border: 1px solid #000000 !important; color: #000000; font-family: 'Times New Roman'; font-size: 11pt; background-color: white }
        .table-data-left { vertical-align: middle; text-align: left; border: 1px solid #000000 !important; color: #000000; font-family: 'Times New Roman'; font-size: 11pt; background-color: white; padding-left: 5px; }
        
        /* Footer Styles */
        .footer-text { vertical-align: middle; text-align: left; color: #000000; font-family: 'Times New Roman'; font-size: 11pt; background-color: white }
        .signature { vertical-align: middle; text-align: center; color: #000000; font-family: 'Times New Roman'; font-size: 11pt; background-color: white }
        .signature-name { vertical-align: middle; text-align: center; color: #000000; font-family: 'Times New Roman'; font-size: 11pt; background-color: white }
        
        /* Merge & Center Styles */
        .merge-center { vertical-align: middle; text-align: center; border: 1px solid #000000 !important; font-weight: bold; color: #000000; font-family: 'Times New Roman'; font-size: 12pt; background-color: #B4C6E7 }
        .merge-data { vertical-align: middle; text-align: center; border: 1px solid #000000 !important; color: #000000; font-family: 'Times New Roman'; font-size: 11pt; background-color: white }
        
        /* Column widths */
        .col-no { width: 40px !important; max-width: 40px; min-width: 40px; }
        .col-nama { width: 180px !important; max-width: 180px; min-width: 180px; }
        .col-kelas { width: 80px !important; max-width: 80px; min-width: 80px; }
        .col-jam { width: 60px !important; max-width: 60px; min-width: 60px; }
        .col-alasan { width: 200px !important; max-width: 200px; min-width: 200px; }
        
        /* Table column settings */
        table.sheet0 col.col0 { width: 40px }
        table.sheet0 col.col1 { width: 180px }
        table.sheet0 col.col2 { width: 80px }
        table.sheet0 col.col3 { width: 60px }
        table.sheet0 col.col4 { width: 200px }
    </style>
</head>
<body>
    <table border="0" cellpadding="0" cellspacing="0" class="gridlines sheet0">
        <!-- Column Definitions -->
        <col class="col-no col0" width="40" style="width: 40px;">
        <col class="col-nama col1" width="180" style="width: 180px;">
        <col class="col-kelas col2" width="80" style="width: 80px;">
        <col class="col-jam col3" width="60" style="width: 60px;">
        <col class="col-alasan col4" width="100" style="width: 100px;">
        
        <!-- Header Section -->
        <tr>
            <td colspan="5" class="title" style="text-align: center; padding: 10px 0;">DAFTAR SISWA DATANG TERLAMBAT</td>
        </tr>
        <tr>
            <td colspan="5" class="title" style="text-align: center; padding: 10px 0;">SMK PGRI CIKAMPEK</td>
        </tr>
        <tr>
            <td colspan="5" class="subtitle" style="text-align: center; padding: 10px 0;">TAHUN AJARAN {{ date('Y') }}-{{ date('Y') + 1 }}</td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        
        <!-- Info Section -->
        <tr>
            <td>&nbsp;</td>
            <td class="info-label">HARI/TANGGAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
            <td class="info-label" colspan="3">{{ \Carbon\Carbon::parse($tanggalMulai)->locale('id')->translatedFormat('l, d F Y') }}{{ $tanggalMulai != $tanggalAkhir ? ' - ' . \Carbon\Carbon::parse($tanggalAkhir)->locale('id')->translatedFormat('l, d F Y') : '' }}</td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        
        @if($rekapData->count() > 0)
        <!-- Table Header -->
        <tr>
            <td class="table-header col-no" style="width: 40px; text-align: center; padding: 5px 0;">NO</td>
            <td class="table-header col-nama" style="width: 180px; text-align: center; padding: 5px 0;">NAMA SISWA</td>
            <td class="table-header col-kelas" style="width: 80px; text-align: center; padding: 5px 0;">KELAS</td>
            <td class="table-header col-jam" style="width: 60px; text-align: center; padding: 5px 0;">JAM</td>
            <td class="table-header col-alasan" style="width: 200px; text-align: center; padding: 5px 0;">ALASAN TERLAMBAT</td>
        </tr>
        
        <!-- Table Data -->
        @foreach($rekapData as $index => $data)
        <tr>
            <td class="table-data" style="width: 40px; text-align: center; padding: 5px 0; border: 1px solid #000000 !important;">{{ $index + 1 }}</td>
            <td class="table-data-left" style="width: 180px; text-align: left; padding: 5px 0; border: 1px solid #000000 !important;">{{ $data->siswa->nama_lengkap }}</td>
            <td class="table-data" style="width: 80px; text-align: center; padding: 5px 0; border: 1px solid #000000 !important;">{{ $data->kelas->nama_kelas }}</td>
            <td class="table-data" style="width: 60px; text-align: center; padding: 5px 0; border: 1px solid #000000 !important;">{{ $data->jam_terlambat }}</td>
            <td class="table-data-left" style="width: 200px; text-align: center; padding: 5px 0; border: 1px solid #000000 !important;">{{ $data->alasan_terlambat ?? '-' }}</td>
        </tr>
        @endforeach
        
        <!-- Fill empty rows if less than 10 (more reasonable minimum) -->
        @for($i = count($rekapData); $i < 10; $i++)
        <tr>
            <td class="table-data" style="width: 40px; text-align: center; padding: 5px 0;">&nbsp;</td>
            <td class="table-data-left" style="width: 180px; text-align: left; padding: 5px 0;">&nbsp;</td>
            <td class="table-data" style="width: 80px; text-align: center; padding: 5px 0;">&nbsp;</td>
            <td class="table-data" style="width: 60px; text-align: center; padding: 5px 0;">&nbsp;</td>
            <td class="table-data-left" style="width: 200px; text-align: center; padding: 5px 0;">&nbsp;</td>
        </tr>
        @endfor
        
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        
        <!-- Footer Section -->
        <tr>
            <td>&nbsp;</td>
            <td class="footer-text">HUKUMAN :</td>
            <td colspan="3" class="footer-text">Telat Satu kali = Peringatan</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td class="footer-text" colspan="3">Telat Dua kali  = Potong rambut</td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
            <td colspan="3" class="signature" style="text-align: center; padding: 10px 0;">Wakil Wakasek Kesiswaan</td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
            <td colspan="3" class="signature-name" style="text-align: center; padding: 5px 0;">Ridwan Surya Permana</td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        @else
        <!-- No Data Message -->
        <tr>
            <td colspan="5" class="merge-center" style="text-align: center; padding: 20px 0; border: 1px solid #000000 !important;">TIDAK ADA DATA SISWA TERLAMBAT PADA PERIODE TERSEBUT</td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
            <td colspan="3" class="signature" style="text-align: center; padding: 10px 0;">Wakil Wakasek Kesiswaan</td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
            <td colspan="3" class="signature-name" style="text-align: center; padding: 5px 0;">Ridwan Surya Permana</td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        @endif
    </table>
</body>
</html>