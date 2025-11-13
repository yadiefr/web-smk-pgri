<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisPelanggaran extends Model
{
    protected $fillable = [
        'nama_pelanggaran',
        'deskripsi',
        'kategori',
        'poin_pelanggaran',
        'sanksi_default',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'poin_pelanggaran' => 'integer'
    ];

    /**
     * Get all pelanggaran for this jenis pelanggaran
     */
    public function pelanggarans(): HasMany
    {
        return $this->hasMany(Pelanggaran::class);
    }

    /**
     * Scope untuk kategori tertentu
     */
    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Scope untuk jenis pelanggaran aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get kategori badge color
     */
    public function getKategoriBadgeColorAttribute()
    {
        return match($this->kategori) {
            'ringan' => 'bg-yellow-100 text-yellow-800',
            'sedang' => 'bg-orange-100 text-orange-800',
            'berat' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
}
