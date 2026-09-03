<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\AttendanceRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $kelasId = $request->query('kelas_id');
        $startDate = $request->query('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', Carbon::now()->toDateString());

        $kelasList = Kelas::where('is_active', true)->get();

        $query = AttendanceRecord::with(['siswa', 'kelas'])
            ->whereBetween('tanggal', [$startDate, $endDate]);

        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }

        $records = $query->latest('tanggal')->paginate(20);

        // Rekapitulasi Status
        $rekap = [
            'hadir' => (clone $query)->where('status', 'hadir')->count(),
            'izin' => (clone $query)->where('status', 'izin')->count(),
            'sakit' => (clone $query)->where('status', 'sakit')->count(),
            'alpha' => (clone $query)->where('status', 'alpha')->count(),
        ];

        return view('admin.laporan.index', compact('records', 'kelasList', 'kelasId', 'startDate', 'endDate', 'rekap'));
    }

    public function exportPdf(Request $request)
    {
        $kelasId = $request->query('kelas_id');
        $startDate = $request->query('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', Carbon::now()->toDateString());

        $query = AttendanceRecord::with(['siswa', 'kelas'])
            ->whereBetween('tanggal', [$startDate, $endDate]);

        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }

        $records = $query->latest('tanggal')->get();
        $kelas = $kelasId ? Kelas::find($kelasId) : null;

        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan.pdf', compact('records', 'kelas', 'startDate', 'endDate'));
            return $pdf->download('laporan-absensi-' . date('Y-m-d') . '.pdf');
        }

        return redirect()->back()->with('error', 'Package DomPDF belum terinstall.');
    }

    public function exportExcel(Request $request)
    {
        $kelasId = $request->query('kelas_id');
        $startDate = $request->query('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', Carbon::now()->toDateString());

        $query = AttendanceRecord::with(['siswa', 'kelas'])
            ->whereBetween('tanggal', [$startDate, $endDate]);

        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }

        $records = $query->latest('tanggal')->get();

        // CSV Header & Content output
        $filename = "laporan-absensi-" . date('Y-m-d') . ".csv";
        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($records) {
            $file = fopen('php://output', 'w');
            // BOM for Excel UTF-8 support
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['Tanggal', 'NIS', 'Nama Siswa', 'Kelas', 'Status Kehadiran', 'Waktu Scan', 'Catatan']);

            foreach ($records as $row) {
                fputcsv($file, [
                    $row->tanggal->format('Y-m-d'),
                    $row->siswa ? $row->siswa->nis : '-',
                    $row->siswa ? $row->siswa->name : '-',
                    $row->kelas ? $row->kelas->nama_kelas : '-',
                    strtoupper($row->status),
                    $row->scan_at ? $row->scan_at->format('H:i:s') : '-',
                    $row->catatan ?? '-'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
