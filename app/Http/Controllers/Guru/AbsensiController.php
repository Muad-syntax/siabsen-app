<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\AttendanceSession;
use App\Models\AttendanceRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $kelasList = $user->allKelasForGuru()->with('siswa')->get();

        return view('guru.absensi.index', compact('kelasList'));
    }

    public function startSession(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'duration' => 'required|integer|in:5,15,30,60',
        ]);

        $user = Auth::user();
        $kelas = Kelas::with('siswa')->findOrFail($request->kelas_id);
        $now = Carbon::now();
        $expiresAt = (clone $now)->addMinutes((int)$request->duration);

        // Buat Sesi Baru dengan UUID token
        $session = AttendanceSession::create([
            'token' => (string) Str::uuid(),
            'kelas_id' => $kelas->id,
            'guru_id' => $user->id,
            'tanggal' => $now->toDateString(),
            'starts_at' => $now,
            'expires_at' => $expiresAt,
            'is_closed' => false,
        ]);

        // Buat record default "belum_hadir" untuk semua siswa di kelas ini
        foreach ($kelas->siswa as $siswa) {
            AttendanceRecord::firstOrCreate([
                'session_id' => $session->id,
                'siswa_id' => $siswa->id,
            ], [
                'kelas_id' => $kelas->id,
                'tanggal' => $now->toDateString(),
                'status' => 'belum_hadir',
            ]);
        }

        return redirect()->route('guru.absensi.session', $session->token)->with('success', 'Sesi Absensi QR Code telah diaktifkan.');
    }

    public function showSession($token)
    {
        $session = AttendanceSession::where('token', $token)
            ->with(['kelas', 'guru', 'records.siswa'])
            ->firstOrFail();

        $localIp = gethostbyname(gethostname());
        if (!$localIp || $localIp === '127.0.0.1' || $localIp === '0.0.0.0') {
            $localIp = $_SERVER['SERVER_ADDR'] ?? '192.168.1.100';
        }

        return view('guru.absensi.session', compact('session', 'localIp'));
    }

    public function closeSession(Request $request, $token)
    {
        $session = AttendanceSession::where('token', $token)->firstOrFail();
        $session->is_closed = true;
        $session->save();

        // Otomatis ubah status siswa yang masih 'belum_hadir' menjadi 'alpha'
        AttendanceRecord::where('session_id', $session->id)
            ->where('status', 'belum_hadir')
            ->update(['status' => 'alpha']);

        return redirect()->route('guru.absensi.session', $session->token)->with('success', 'Sesi absensi telah ditutup. Siswa yang belum scan diubah ke status Alpha.');
    }

    public function overrideRecord(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:hadir,izin,sakit,alpha,belum_hadir',
            'catatan' => 'nullable|string|max:255',
        ]);

        $record = AttendanceRecord::findOrFail($id);
        $record->status = $request->status;
        $record->catatan = $request->catatan;
        $record->override_by = Auth::id();
        $record->save();

        return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui']);
    }

    public function riwayat()
    {
        $user = Auth::user();
        $sessions = AttendanceSession::where('guru_id', $user->id)
            ->with(['kelas', 'records'])
            ->latest()
            ->paginate(10);

        return view('guru.absensi.riwayat', compact('sessions'));
    }
}
