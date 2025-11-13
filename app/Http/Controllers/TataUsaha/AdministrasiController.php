<?php

namespace App\Http\Controllers\TataUsaha;

use App\Http\Controllers\Controller;

class AdministrasiController extends Controller
{
    public function surat()
    {
        // Placeholder for surat management
        return view('tata_usaha.administrasi.surat');
    }

    public function dokumen()
    {
        // Placeholder for dokumen management
        return view('tata_usaha.administrasi.dokumen');
    }

    public function arsip()
    {
        // Placeholder for arsip management
        return view('tata_usaha.administrasi.arsip');
    }
}
