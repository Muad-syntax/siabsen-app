<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Enrolled class
        $kelas = $user->kelasAsStudent()->first();

        // Attendance stats
        $records = AttendanceRecord::where('siswa_id', $user->id)->get();
        $totalRecord = $records->count();

        $stats = [
            'hadir' => $records->where('status', 'hadir')->count(),
            'izin' => $records->where('status', 'izin')->count(),
            'sakit' => $records->where('status', 'sakit')->count(),
            'alpha' => $records->where('status', 'alpha')->count(),
        ];

        $persenHadir = $totalRecord > 0 ? round(($stats['hadir'] / $totalRecord) * 100) : 100;

        // Terbaru
        $riwayatTerbaru = AttendanceRecord::where('siswa_id', $user->id)
            ->with(['kelas', 'session.guru'])
            ->latest('tanggal')
            ->take(5)
            ->get();

        return view('siswa.dashboard', compact('kelas', 'stats', 'persenHadir', 'totalRecord', 'riwayatTerbaru'));
    }
}
