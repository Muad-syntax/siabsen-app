<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $records = AttendanceRecord::where('siswa_id', $user->id)
            ->with(['kelas', 'session.guru'])
            ->latest('tanggal')
            ->paginate(15);

        return view('siswa.riwayat', compact('records'));
    }
}
