<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kelas;
use App\Models\AttendanceRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalSiswa = User::where('role', 'siswa')->where('is_active', true)->count();
        $totalGuru = User::where('role', 'guru')->where('is_active', true)->count();
        $totalKelas = Kelas::where('is_active', true)->count();

        // Kehadiran Hari Ini
        $totalRecordHariIni = AttendanceRecord::whereDate('tanggal', $today)->count();
        $totalHadirHariIni = AttendanceRecord::whereDate('tanggal', $today)->where('status', 'hadir')->count();
        
        $persenKehadiran = $totalRecordHariIni > 0 ? round(($totalHadirHariIni / $totalRecordHariIni) * 100) : 0;

        // Kelas dengan persentase kehadiran hari ini
        $kelasList = Kelas::where('is_active', true)->with('waliKelas')->get()->map(function ($kelas) use ($today) {
            $records = AttendanceRecord::where('kelas_id', $kelas->id)->whereDate('tanggal', $today)->get();
            $total = $records->count();
            $hadir = $records->where('status', 'hadir')->count();
            $kelas->persen_hadir = $total > 0 ? round(($hadir / $total) * 100) : 0;
            return $kelas;
        });

        // Guru terbaru
        $guruTerbaru = User::where('role', 'guru')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'persenKehadiran',
            'totalHadirHariIni',
            'totalRecordHariIni',
            'kelasList',
            'guruTerbaru'
        ));
    }
}
