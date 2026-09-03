<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kehadiran Siswa</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #0F2D4A; margin: 20px; }
        h1 { font-size: 18px; margin-bottom: 2px; text-align: center; }
        p.subtitle { text-align: center; color: #64748B; font-size: 10px; margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #E2E8F0; padding: 6px 8px; text-align: left; }
        th { background-color: #0F2D4A; color: white; text-transform: uppercase; font-size: 9px; }
        tr:nth-child(even) { background-color: #EFF6FF; }
        .badge { font-weight: bold; padding: 2px 6px; border-radius: 4px; font-size: 9px; }
        .hadir { background-color: #D1FAE5; color: #065F46; }
        .izin { background-color: #FEF3C7; color: #92400E; }
        .sakit { background-color: #DBEAFE; color: #1E40AF; }
        .alpha { background-color: #FFE4E6; color: #991B1B; }
    </style>
</head>
<body>

    <h1>LAPORAN KEHADIRAN SISWA</h1>
    <p class="subtitle">
        {{ $kelas ? 'Kelas: ' . $kelas->nama_kelas : 'Semua Kelas' }} | Periode: {{ $startDate }} s/d {{ $endDate }}
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Status</th>
                <th>Waktu Scan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $index => $r)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $r->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $r->siswa ? $r->siswa->nis : '-' }}</td>
                    <td><strong>{{ $r->siswa ? $r->siswa->name : '-' }}</strong></td>
                    <td>{{ $r->kelas ? $r->kelas->nama_kelas : '-' }}</td>
                    <td>
                        <span class="badge {{ $r->status }}">{{ strtoupper($r->status) }}</span>
                    </td>
                    <td>{{ $r->scan_at ? $r->scan_at->format('H:i:s') : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
