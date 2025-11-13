<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Pelanggaran extends Model
{
    protected $fillable = [
        'siswa_id',
        'jenis_pelanggaran_id',
        'guru_id',
        'tanggal_pelanggaran',
        'jam_pelanggaran',
        'deskripsi_kejadian',
        'sanksi_diberikan',
        'tanggal_selesai_sanksi',
        'status_sanksi',
        'catatan_tambahan',
        'bukti_foto',
        'sudah_dihubungi_ortu',
        'tanggal_hubungi_ortu',
        'respon_ortu',
        'tingkat_urgensi'
    ];

    protected $casts = [
        'tanggal_pelanggaran' => 'date',
        'tanggal_selesai_sanksi' => 'date',
        'tanggal_hubungi_ortu' => 'datetime',
        'sudah_dihubungi_ortu' => 'boolean'
    ];

    /**
     * Get the siswa that owns the pelanggaran
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * Get the jenis pelanggaran
     */
    public function jenisPelanggaran(): BelongsTo
    {
        return $this->belongsTo(JenisPelanggaran::class);
    }

    /**
     * Get the guru that reported the pelanggaran
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class);
    }

    /**
     * Scope untuk status sanksi tertentu
     */
    public function scopeStatusSanksi($query, $status)
    {
        return $query->where('status_sanksi', $status);
    }

    /**
     * Scope untuk tingkat urgensi tertentu
     */
    public function scopeTingkatUrgensi($query, $tingkat)
    {
        return $query->where('tingkat_urgensi', $tingkat);
    }

    /**
     * Scope untuk pelanggaran bulan ini
     */
    public function scopeBulanIni($query)
    {
        return $query->whereMonth('tanggal_pelanggaran', now()->month)
                    ->whereYear('tanggal_pelanggaran', now()->year);
    }

    /**
     * Scope untuk pelanggaran hari ini
     */
    public function scopeHariIni($query)
    {
        return $query->whereDate('tanggal_pelanggaran', now()->toDateString());
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColorAttribute()
    {
        return match($this->status_sanksi) {
            'belum_selesai' => 'bg-red-100 text-red-800',
            'sedang_proses' => 'bg-yellow-100 text-yellow-800',
            'selesai' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Get urgensi badge color
     */
    public function getUrgensiBadgeColorAttribute()
    {
        return match($this->tingkat_urgensi) {
            'rendah' => 'bg-blue-100 text-blue-800',
            'sedang' => 'bg-yellow-100 text-yellow-800',
            'tinggi' => 'bg-orange-100 text-orange-800',
            'sangat_tinggi' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Check if sanksi sudah berakhir
     */
    public function getIsSanksiSelesaiAttribute()
    {
        if (!$this->tanggal_selesai_sanksi) {
            return false;
        }

        return Carbon::now()->gte($this->tanggal_selesai_sanksi);
    }

    /**
     * Get sisa hari sanksi
     */
    public function getSisaHariSanksiAttribute()
    {
        if (!$this->tanggal_selesai_sanksi) {
            return null;
        }

        $sisa = Carbon::now()->diffInDays($this->tanggal_selesai_sanksi, false);
        return $sisa > 0 ? $sisa : 0;
    }
}
