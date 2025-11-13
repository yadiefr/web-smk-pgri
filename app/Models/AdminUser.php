<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AdminUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nip',
        'phone',
        'address',
        'birth_date',
        'gender',
        'photo',
        'status',
        'permissions',
        'last_login_at',
        'last_login_ip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'date',
        'last_login_at' => 'datetime',
        'permissions' => 'array',
    ];

    // Role constants
    const ROLES = [
        'admin' => 'Admin',
        'guru' => 'Guru',
        'siswa' => 'Siswa',
        'tata_usaha' => 'Tata Usaha',
        'kurikulum' => 'Kurikulum',
        'hubin' => 'Hubin',
        'perpustakaan' => 'Perpustakaan',
        'kesiswaan' => 'Kesiswaan',
    ];

    // Role permissions
    const ROLE_PERMISSIONS = [
        'admin' => ['*'], // All permissions
        'guru' => ['view_siswa', 'manage_nilai', 'view_jadwal', 'manage_materi'],
        'siswa' => ['view_nilai', 'view_jadwal', 'view_materi'],
        'tata_usaha' => ['manage_siswa', 'view_keuangan', 'manage_administrasi'],
        'kurikulum' => ['manage_kurikulum', 'manage_jadwal', 'view_siswa', 'manage_mapel'],
        'hubin' => ['manage_pkl', 'manage_industri', 'view_siswa'],
        'perpustakaan' => ['manage_buku', 'manage_peminjaman', 'view_siswa'],
        'kesiswaan' => ['manage_siswa', 'manage_kegiatan', 'manage_absensi'],
    ];

    /**
     * Password mutator
     */
    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => bcrypt($value),
        );
    }

    /**
     * Get role display name
     */
    public function getRoleDisplayAttribute()
    {
        return self::ROLES[$this->role] ?? $this->role;
    }

    /**
     * Get user permissions
     */
    public function getPermissionsAttribute($value)
    {
        $decoded = json_decode($value, true) ?? [];
        $rolePermissions = self::ROLE_PERMISSIONS[$this->role] ?? [];

        return array_unique(array_merge($rolePermissions, $decoded));
    }

    /**
     * Check if user has permission
     */
    public function hasPermission($permission)
    {
        $permissions = $this->permissions;

        return in_array('*', $permissions) || in_array($permission, $permissions);
    }

    /**
     * Check if user has role
     */
    public function hasRole($role)
    {
        if (is_array($role)) {
            return in_array($this->role, $role);
        }

        return $this->role === $role;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is tata_usaha
     */
    public function isTataUsaha()
    {
        return $this->role === 'tata_usaha';
    }

    /**
     * Check if user is keuangan/bendahara
     */
    public function isKeuangan()
    {
        return $this->role === 'keuangan' || $this->role === 'bendahara';
    }

    /**
     * Check if user is guru
     */
    public function isGuru()
    {
        return $this->role === 'guru';
    }

    /**
     * Check if user is siswa
     */
    public function isSiswa()
    {
        return $this->role === 'siswa';
    }

    /**
     * Check if user is keuangan or tata usaha (legacy support)
     */
    public function isKeuanganOrTU()
    {
        return in_array($this->role, ['keuangan', 'bendahara', 'tata_usaha', 'tu']);
    }

    /**
     * Scope for active users
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope for specific role
     */
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Get photo URL
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('storage/admin_photos/'.$this->photo);
        }

        return asset('images/default-avatar.png');
    }

    /**
     * Update last login
     */
    public function updateLastLogin($ip = null)
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => $ip ?? request()->ip(),
        ]);
    }
}
