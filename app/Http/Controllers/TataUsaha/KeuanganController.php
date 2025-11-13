<?php

namespace App\Http\Controllers\TataUsaha;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;

class KeuanganController extends Controller
{
    public function pembayaran()
    {
        $tagihan = Tagihan::with(['siswa', 'kelas'])
            ->latest()
            ->paginate(20);

        return view('tata_usaha.keuangan.pembayaran', compact('tagihan'));
    }

    public function laporan()
    {
        // Basic financial reports for tata usaha
        $totalTagihan = Tagihan::sum('jumlah');
        $totalTerbayar = Tagihan::where('status_pembayaran', 'lunas')->sum('jumlah');
        $totalTunggakan = $totalTagihan - $totalTerbayar;

        return view('tata_usaha.keuangan.laporan', compact('totalTagihan', 'totalTerbayar', 'totalTunggakan'));
    }

    public function tagihan()
    {
        $tagihan = Tagihan::with(['siswa', 'kelas'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Add status pembayaran if not exists
        $tagihan->getCollection()->transform(function ($item) {
            if (! isset($item->status_pembayaran)) {
                // Generate status berdasarkan tanggal jatuh tempo
                $jatuhTempo = \Carbon\Carbon::parse($item->tanggal_jatuh_tempo);
                if ($jatuhTempo->isPast()) {
                    $item->status_pembayaran = 'terlambat';
                } else {
                    $item->status_pembayaran = 'belum_bayar';
                }
            }

            return $item;
        });

        return view('tata_usaha.keuangan.tagihan', compact('tagihan'));
    }

    public function tunggakan()
    {
        $tunggakan = Tagihan::with(['siswa', 'kelas'])
            ->where(function ($query) {
                $query->where('status_pembayaran', '!=', 'lunas')
                    ->orWhereNull('status_pembayaran');
            })
            ->where('tanggal_jatuh_tempo', '<', now())
            ->orderBy('tanggal_jatuh_tempo', 'asc')
            ->paginate(20);

        // Add status pembayaran if not exists
        $tunggakan->getCollection()->transform(function ($item) {
            if (! isset($item->status_pembayaran)) {
                $item->status_pembayaran = 'terlambat';
            }

            return $item;
        });

        return view('tata_usaha.keuangan.tunggakan', compact('tunggakan'));
    }
}
