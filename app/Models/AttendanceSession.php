<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceSession extends Model
{
    use HasFactory;

    protected $table = 'attendance_sessions';

    public $timestamps = false;

    protected $fillable = [
        'token',
        'kelas_id',
        'guru_id',
        'tanggal',
        'starts_at',
        'expires_at',
        'is_closed',
        'created_at',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_closed' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function records()
    {
        return $this->hasMany(AttendanceRecord::class, 'session_id');
    }

    public function isExpired(): bool
    {
        return $this->is_closed || now()->greaterThan($this->expires_at);
    }
}
