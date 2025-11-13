<?php

namespace App\Models;

use App\Models\Settings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Pendaftaran extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $table = 'pendaftaran';
    
    /**
     * Boot method to handle model events
     */
    protected static function boot(): void
    {
        parent::boot();
        
        static::creating(function ($pendaftaran) {
            if (empty($pendaftaran->nomor_pendaftaran)) {
                $pendaftaran->nomor_pendaftaran = self::generateNomorPendaftaran();
            }
            if (empty($pendaftaran->tanggal_pendaftaran)) {
                $pendaftaran->tanggal_pendaftaran = now();
            }
        });
    }
    
    protected $fillable = [
        'nomor_pendaftaran',
        'nama_lengkap',
        'jenis_kelamin',
        'nisn',
        'username',
        'password',
        'whatsapp',
        'is_active',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'telepon',
        'email',
        'asal_sekolah',
        'nama_ayah',
        'nama_ibu',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'telepon_orangtua',
        'alamat_orangtua',
        'pilihan_jurusan_1',
        'status', // menunggu, diterima, ditolak, cadangan
        'user_id',
        'tanggal_pendaftaran',
        'tahun_ajaran',
        'keterangan',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_pendaftaran' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Handle password hashing using a mutator
     */
    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = bcrypt($value);
    }

    // Relasi ke jurusan pilihan 1
    public function jurusanPertama()
    {
        return $this->belongsTo(Jurusan::class, 'pilihan_jurusan_1');
    }

    /**
     * Check if user is PPDB registrant
     */
    public function isPendaftar(): bool
    {
        return true; // Semua record di tabel ini adalah pendaftar PPDB
    }

    /**
     * Get role for this user
     */
    public function getRole(): string
    {
        return 'pendaftar';
    }
    
    // Generate nomor pendaftaran
    public static function generateNomorPendaftaran()
    {
        $tahun = date('Y');
        $count = self::whereYear('created_at', $tahun)->count() + 1;
        return 'PPDB-' . $tahun . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
    
    // Dapatkan total pendaftar berdasarkan status
    public static function getCountByStatus($status)
    {
        return self::where('status', $status)
                  ->where('tahun_ajaran', Settings::getValue('ppdb_year', date('Y').'/'.((int)date('Y')+1)))
                  ->count();
    }
    
    // Dapatkan total pendaftar berdasarkan jurusan
    public static function getCountByJurusan($jurusanId)
    {
        return self::where(function($query) use ($jurusanId) {
                      $query->where('pilihan_jurusan_1', $jurusanId)
                            ->orWhere('pilihan_jurusan_2', $jurusanId);
                  })
                  ->where('tahun_ajaran', Settings::getValue('ppdb_year', date('Y').'/'.((int)date('Y')+1)))
                  ->count();
    }
}
