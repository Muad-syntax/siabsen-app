<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'tingkat',
        'jurusan',
        'tahun_ajaran',
        'wali_kelas_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Wali kelas (User dengan role guru)
    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }

    // Guru pengampu (Guru-guru yang mengajar di kelas ini)
    public function pengajar()
    {
        return $this->belongsToMany(User::class, 'guru_kelas', 'kelas_id', 'guru_id');
    }

    // Siswa yang terdaftar di kelas ini
    public function siswa()
    {
        return $this->belongsToMany(User::class, 'siswa_kelas', 'kelas_id', 'siswa_id')
                    ->withPivot('joined_at', 'left_at');
    }

    // Sesi absensi kelas
    public function sessions()
    {
        return $this->hasMany(AttendanceSession::class, 'kelas_id');
    }

    // Rekam absensi kelas
    public function attendanceRecords()
    {
        return $this->hasMany(AttendanceRecord::class, 'kelas_id');
    }
}
