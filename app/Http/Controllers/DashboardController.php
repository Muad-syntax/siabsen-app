<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Absensi;
use App\Models\Nilai;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $dataGuru = Guru::all();
            return view('admin.dashboard', compact('dataGuru'));
        }

        if ($user->isGuru()) {
            $dataSiswa = Siswa::all();
            return view('guru.dashboard', compact('dataSiswa'));
        }

        if ($user->isSiswa()) {
            // Ambil riwayat presensi dan nilai milik siswa yang sedang login
            $riwayatAbsensi = Absensi::where('nis', $user->nis)->get();
            $dataNilai = Nilai::with('mataPelajaran')->where('nis', $user->nis)->get();

            return view('siswa.dashboard', compact('riwayatAbsensi', 'dataNilai'));
        }

        return abort(403, 'Akses tidak sah.');
    }
}