<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with(['waliKelas', 'pengajar', 'siswa'])->latest()->get();
        $gurus = User::where('role', 'guru')->where('is_active', true)->get();

        return view('admin.kelas.index', compact('kelas', 'gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:50',
            'tingkat' => 'required|string|max:5',
            'jurusan' => 'nullable|string|max:50',
            'tahun_ajaran' => 'required|string|max:10',
            'wali_kelas_id' => 'nullable|exists:users,id',
            'guru_ids' => 'nullable|array',
            'guru_ids.*' => 'exists:users,id',
        ]);

        $kelas = Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'tingkat' => $request->tingkat,
            'jurusan' => $request->jurusan,
            'tahun_ajaran' => $request->tahun_ajaran,
            'wali_kelas_id' => $request->wali_kelas_id,
            'is_active' => true,
        ]);

        $guruIds = $request->guru_ids ?? [];
        if ($request->wali_kelas_id && !in_array($request->wali_kelas_id, $guruIds)) {
            $guruIds[] = $request->wali_kelas_id;
        }
        $kelas->pengajar()->sync($guruIds);

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas baru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $request->validate([
            'nama_kelas' => 'required|string|max:50',
            'tingkat' => 'required|string|max:5',
            'jurusan' => 'nullable|string|max:50',
            'tahun_ajaran' => 'required|string|max:10',
            'wali_kelas_id' => 'nullable|exists:users,id',
            'guru_ids' => 'nullable|array',
            'guru_ids.*' => 'exists:users,id',
        ]);

        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
            'tingkat' => $request->tingkat,
            'jurusan' => $request->jurusan,
            'tahun_ajaran' => $request->tahun_ajaran,
            'wali_kelas_id' => $request->wali_kelas_id,
        ]);

        $guruIds = $request->guru_ids ?? [];
        if ($request->wali_kelas_id && !in_array($request->wali_kelas_id, $guruIds)) {
            $guruIds[] = $request->wali_kelas_id;
        }
        $kelas->pengajar()->sync($guruIds);

        return redirect()->route('admin.kelas.index')->with('success', 'Data Kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->is_active = !$kelas->is_active;
        $kelas->save();

        $status = $kelas->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.kelas.index')->with('success', "Kelas {$kelas->nama_kelas} berhasil {$status}.");
    }

    public function deletePermanent($id)
    {
        $kelas = Kelas::findOrFail($id);
        $nama = $kelas->nama_kelas;
        $kelas->delete();

        return redirect()->route('admin.kelas.index')->with('success', "Kelas '{$nama}' telah dihapus secara permanen.");
    }
}
