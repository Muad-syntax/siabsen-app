<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nis',
        'nip',
        'photo',
        'is_active',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    // Relasi Guru: Wali kelas untuk beberapa kelas
    public function kelasAsWali()
    {
        return $this->hasMany(Kelas::class, 'wali_kelas_id');
    }

    // Relasi Guru: Mengajar di banyak kelas (via guru_kelas)
    public function kelasYangDiajar()
    {
        return $this->belongsToMany(Kelas::class, 'guru_kelas', 'guru_id', 'kelas_id');
    }

    // Mendapatkan semua kelas untuk Guru (Wali Kelas + Pengajar)
    public function allKelasForGuru()
    {
        $waliKelasIds = Kelas::where('wali_kelas_id', $this->id)->pluck('id');
        $pengajarKelasIds = $this->kelasYangDiajar()->pluck('kelas.id');
        $allIds = $waliKelasIds->merge($pengajarKelasIds)->unique();

        return Kelas::whereIn('id', $allIds);
    }

    // Relasi Siswa: Terdaftar di kelas (via siswa_kelas)
    public function kelasAsStudent()
    {
        return $this->belongsToMany(Kelas::class, 'siswa_kelas', 'siswa_id', 'kelas_id')
                    ->withPivot('joined_at', 'left_at');
    }

    // Relasi Siswa: Catatan kehadiran
    public function attendanceRecords()
    {
        return $this->hasMany(AttendanceRecord::class, 'siswa_id');
    }

    // Sesi absensi yang dibuat oleh guru
    public function attendanceSessions()
    {
        return $this->hasMany(AttendanceSession::class, 'guru_id');
    }
}