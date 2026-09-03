<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\AttendanceSession;
use App\Models\AttendanceRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();

        // Kelas yang diajar atau diwali oleh guru ini
        $kelasList = $user->allKelasForGuru()->with('siswa')->get();

        // Sesi absensi hari ini yang dibuat oleh guru ini
        $sesiHariIni = AttendanceSession::where('guru_id', $user->id)
            ->whereDate('tanggal', $today)
            ->with(['kelas', 'records'])
            ->latest()
            ->get();

        // Total siswa yang diajar
        $totalSiswa = 0;
        foreach ($kelasList as $k) {
            $totalSiswa += $k->siswa->count();
        }

        return view('guru.dashboard', compact('kelasList', 'sesiHariIni', 'totalSiswa'));
    }
}
