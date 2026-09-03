<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    use HasFactory;

    protected $table = 'attendance_records';

    protected $fillable = [
        'session_id',
        'siswa_id',
        'kelas_id',
        'tanggal',
        'status',
        'scan_at',
        'scan_ip',
        'override_by',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'scan_at' => 'datetime',
    ];

    public function session()
    {
        return $this->belongsTo(AttendanceSession::class, 'session_id');
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function overrideBy()
    {
        return $this->belongsTo(User::class, 'override_by');
    }
}
