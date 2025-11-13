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
        
        /* Column widths */
        .col-no { width: 40px !important; max-width: 40px; min-width: 40px; }
        .col-nama { width: 240px !important; max-width: 240px; min-width: 240px; }
        .col-kelas { width: 80px !important; max-width: 80px; min-width: 80px; }
        .col-jam { width: 60px !important; max-width: 60px; min-width: 60px; }
        .col-alasan { width: 140px !important; max-width: 140px; min-width: 140px; }
        
        /* Table column settings */
        table.sheet0 col.col0 { width: 40px }
        table.sheet0 col.col1 { width: 240px }
        table.sheet0 col.col2 { width: 80px }
        table.sheet0 col.col3 { width: 60px }
        table.sheet0 col.col4 { width: 140px }
    </style>
</head>
<body>
    <table border="0" cellpadding="0" cellspacing="0" class="gridlines sheet0">
        <!-- Column Definitions -->
        <col class="col-no col0" width="40" style="width: 40px;">
        <col class="col-nama col1" width="240" style="width: 240px;">
        <col class="col-kelas col2" width="80" style="width: 80px;">
        <col class="col-jam col3" width="60" style="width: 60px;">
        <col class="col-alasan col4" width="140" style="width: 140px;">
        
        <!-- Header Section -->
        <tr>
            <td colspan="5" class="title" style="text-align: center; padding: 10px 0;">DAFTAR SISWA DATANG TERLAMBAT</td>
        </tr>
        <tr>
            <td colspan="5" class="title" style="text-align: center; padding: 10px 0;">SMK PGRI CIKAMPEK</td>
        </tr>
        <tr>
            <td colspan="5" class="subtitle" style="text-align: center; padding: 10px 0;">TAHUN AJARAN <?php echo e(date('Y')); ?>-<?php echo e(date('Y') + 1); ?></td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        
        <!-- Info Section -->
        <tr>
            <td>&nbsp;</td>
            <td class="info-label">HARI/TANGGAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
            <td class="info-label" colspan="3"><?php echo e(\Carbon\Carbon::parse($tanggalMulai)->locale('id')->translatedFormat('l, d F Y')); ?></td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        
        <?php if($rekapData->count() > 0): ?>
        <!-- Table Header -->
        <tr style="height: 40px;">
            <td class="table-header col-no" style="width: 40px; text-align: center; vertical-align: middle; border: 2px solid #000000 !important; font-weight: bold; padding: 8px 4px; height: 40px;">NO</td>
            <td class="table-header col-nama" style="width: 240px; text-align: center; vertical-align: middle; border: 2px solid #000000 !important; font-weight: bold; padding: 8px 4px; height: 40px;">NAMA SISWA</td>
            <td class="table-header col-kelas" style="width: 80px; text-align: center; vertical-align: middle; border: 2px solid #000000 !important; font-weight: bold; padding: 8px 4px; height: 40px;">KELAS</td>
            <td class="table-header col-jam" style="width: 60px; text-align: center; vertical-align: middle; border: 2px solid #000000 !important; font-weight: bold; padding: 8px 4px; height: 40px;">JAM</td>
            <td class="table-header col-alasan" style="width: 140px; text-align: center; vertical-align: middle; border: 2px solid #000000 !important; font-weight: bold; padding: 8px 4px; height: 40px;">ALASAN TERLAMBAT</td>
        </tr>
        
        <!-- Table Data -->
        <?php $__currentLoopData = $rekapData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td class="table-data" style="width: 40px; text-align: center; vertical-align: middle; border: 1px solid #000000 !important; padding: 4px;"><?php echo e($index + 1); ?></td>
            <td class="table-data-left" style="width: 240px; text-align: left; vertical-align: middle; border: 1px solid #000000 !important; padding: 4px; padding-left: 8px;"><?php echo e($data->siswa->nama_lengkap); ?></td>
            <td class="table-data" style="width: 80px; text-align: center; vertical-align: middle; border: 1px solid #000000 !important; padding: 4px;"><?php echo e($data->kelas->nama_kelas); ?></td>
            <td class="table-data" style="width: 60px; text-align: center; vertical-align: middle; border: 1px solid #000000 !important; padding: 4px;"><?php echo e(\Carbon\Carbon::parse($data->jam_terlambat)->format('H:i')); ?></td>
            <td class="table-data-center" style="width: 140px; text-align: center; vertical-align: middle; border: 1px solid #000000 !important; padding: 4px;"><?php echo e($data->alasan_terlambat ?? '-'); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        
        <!-- Footer Section -->
        <?php
            // Get unique sanctions from the data
            $uniqueSanctions = $rekapData->whereNotNull('sanksi')
                                        ->where('sanksi', '!=', '')
                                        ->pluck('sanksi')
                                        ->unique()
                                        ->values();
        ?>
        
        <?php if($uniqueSanctions->count() > 0): ?>
        <tr>
            <td>&nbsp;</td>
            <td class="footer-text">SANKSI/TINDAKAN :</td>
            <td colspan="3" class="footer-text"></td>
        </tr>
        <?php $__currentLoopData = $uniqueSanctions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sanksi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                // Split sanksi by newlines to handle multi-line sanctions
                $sanksiLines = explode("\n", trim($sanksi));
            ?>
            <?php $__currentLoopData = $sanksiLines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(trim($line) != ''): ?>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td class="footer-text" colspan="3"><?php echo e(trim($line)); ?></td>
                </tr>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
        <tr>
            <td>&nbsp;</td>
            <td class="footer-text">SANKSI/TINDAKAN :</td>
            <td colspan="3" class="footer-text">Telat Satu kali = Peringatan</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td class="footer-text" colspan="3">Telat Dua kali = Potong rambut</td>
        </tr>
        <?php endif; ?>
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
        <?php else: ?>
        <!-- No Data Message -->
        <tr>
            <td colspan="5" class="merge-center" style="text-align: center; padding: 20px 0; border: 1px solid #000000 !important;">TIDAK ADA DATA SISWA TERLAMBAT PADA TANGGAL TERSEBUT</td>
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
        <?php endif; ?>
    </table>
</body>
</html><?php /**PATH C:\wamp64\www\website-smk3\resources\views/kesiswaan/keterlambatan/export-per-tanggal.blade.php ENDPATH**/ ?>