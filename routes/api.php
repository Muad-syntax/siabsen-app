<?php

use Illuminate\Support\Facades\Route;
use App\Models\AttendanceSession;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Polling endpoint for Guru Sesi QR
Route::get('/absensi/session/{token}/status', function ($token) {
    $session = AttendanceSession::where('token', $token)->with(['records.siswa'])->first();

    if (!$session) {
        return response()->json(['error' => 'Sesi tidak ditemukan'], 404);
    }

    $records = $session->records->map(function ($rec) {
        return [
            'id' => $rec->id,
            'nama' => $rec->siswa ? $rec->siswa->name : 'Siswa',
            'nis' => $rec->siswa ? $rec->siswa->nis : '-',
            'status' => $rec->status,
            'scan_at' => $rec->scan_at ? $rec->scan_at->format('H:i:s') : null,
        ];
    });

    return response()->json([
        'token' => $session->token,
        'is_closed' => $session->is_closed,
        'is_expired' => $session->isExpired(),
        'expires_at' => $session->expires_at->toIso8601String(),
        'total_hadir' => $records->where('status', 'hadir')->count(),
        'total_siswa' => $records->count(),
        'records' => $records->values(),
    ]);
});
