<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSession;
use App\Models\AttendanceRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AbsenController extends Controller
{
    public function scan(Request $request, $token)
    {
        // 1. Cek autentikasi
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk melakukan absensi.');
        }

        $user = Auth::user();

        // 2. Cek Role Siswa
        if (!$user->isSiswa()) {
            return view('siswa.absen.result', [
                'status' => 'error',
                'title' => 'Akses Khusus Siswa',
                'message' => 'Hanya akun Siswa yang dapat memindai QR Code untuk mencatat kehadiran.',
            ]);
        }

        // 3. Cari Sesi Absensi berdasarkan Token
        $session = AttendanceSession::where('token', $token)->with(['kelas', 'guru'])->first();

        if (!$session) {
            return view('siswa.absen.result', [
                'status' => 'error',
                'title' => 'QR Code Tidak Valid',
                'message' => 'Sesi absensi tidak ditemukan. Pastikan Anda memindai QR Code resmi dari guru.',
            ]);
        }

        // 4. Cek apakah Sesi Kadaluarsa atau Ditutup
        if ($session->is_closed || $session->isExpired()) {
            return view('siswa.absen.result', [
                'status' => 'error',
                'title' => 'Sesi Absensi Berakhir',
                'message' => 'QR Code ini sudah kadaluarsa atau telah ditutup oleh pengajar.',
            ]);
        }

        // 5. Cek apakah Siswa Terdaftar di Kelas Ini
        $isEnrolled = $user->kelasAsStudent()->where('kelas_id', $session->kelas_id)->exists();
        if (!$isEnrolled) {
            return view('siswa.absen.result', [
                'status' => 'error',
                'title' => 'Kelas Tidak Sesuai',
                'message' => 'Anda tidak terdaftar sebagai peserta didik di kelas ' . ($session->kelas ? $session->kelas->nama_kelas : 'ini') . '.',
            ]);
        }

        // 6. Catat atau Update Presensi Siswa
        $now = Carbon::now();
        $record = AttendanceRecord::firstOrCreate([
            'session_id' => $session->id,
            'siswa_id' => $user->id,
        ], [
            'kelas_id' => $session->kelas_id,
            'tanggal' => $session->tanggal,
            'status' => 'belum_hadir',
        ]);

        if ($record->status === 'hadir') {
            return view('siswa.absen.result', [
                'status' => 'info',
                'title' => 'Sudah Absen',
                'message' => 'Anda sudah berhasil mencatat kehadiran pada pukul ' . ($record->scan_at ? $record->scan_at->format('H:i:s') : '-') . ' WIB.',
                'record' => $record,
                'session' => $session,
            ]);
        }

        // Update status menjadi HADIR
        $record->status = 'hadir';
        $record->scan_at = $now;
        $record->save();

        return view('siswa.absen.result', [
            'status' => 'success',
            'title' => 'Absensi Berhasil!',
            'message' => 'Kehadiran Anda di kelas ' . ($session->kelas ? $session->kelas->nama_kelas : '') . ' telah berhasil dicatat.',
            'record' => $record,
            'session' => $session,
        ]);
    }
}
