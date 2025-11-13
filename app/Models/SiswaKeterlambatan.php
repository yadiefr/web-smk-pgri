<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiswaKeterlambatan extends Model
{
    use HasFactory;

    protected $table = 'siswa_keterlambatan';

    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'tanggal',
        'jam_terlambat',
        'alasan_terlambat',
        'status',
        'sanksi',
        'petugas_id',
        'catatan_petugas',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(AdminUser::class, 'petugas_id');
    }

    // Scope untuk filter berdasarkan tanggal
    public function scopeHariIni($query)
    {
        return $query->whereDate('tanggal', today());
    }

    public function scopeBulanIni($query)
    {
        return $query->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year);
    }

    // Accessor untuk format jam yang lebih readable
    public function getJamTerlambatFormatAttribute()
    {
        if (empty($this->jam_terlambat)) {
            return '';
        }

        // Jika sudah dalam format H:i atau H:i:s
        if (is_string($this->jam_terlambat)) {
            // Format HH:MM
            if (preg_match('/^\d{1,2}:\d{2}$/', $this->jam_terlambat)) {
                return $this->jam_terlambat;
            }
            // Format HH:MM:SS, ambil hanya HH:MM
            if (preg_match('/^\d{1,2}:\d{2}:\d{2}$/', $this->jam_terlambat)) {
                return substr($this->jam_terlambat, 0, 5);
            }
            
            // Jika format lain, coba parse dengan Carbon
            try {
                return \Carbon\Carbon::parse($this->jam_terlambat)->format('H:i');
            } catch (\Exception $e) {
                return $this->jam_terlambat;
            }
        }
        
        // Jika Carbon instance
        if ($this->jam_terlambat instanceof \Carbon\Carbon) {
            return $this->jam_terlambat->format('H:i');
        }
        
        // Default fallback - coba convert ke string dulu
        return (string) $this->jam_terlambat;
    }
}
