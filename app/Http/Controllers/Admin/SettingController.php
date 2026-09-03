<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'nama_sekolah' => config('app.school_name', 'SMA Negeri 1 AbsensiKu'),
            'alamat' => config('app.school_address', 'Jl. Pendidikan No. 123, Jakarta'),
            'telepon' => config('app.school_phone', '(021) 555-0199'),
            'tahun_ajaran_aktif' => '2026/2027',
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:30',
        ]);

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan Sekolah berhasil disimpan.');
    }
}
