<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class SiswaController extends Controller
{
    public function index(Request $request, $kelasId)
    {
        $kelas = Kelas::with(['siswa' => function ($q) use ($request) {
            if ($request->search) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('nis', 'like', "%{$request->search}%");
            }
        }])->findOrFail($kelasId);

        return view('guru.siswa.index', compact('kelas'));
    }

    public function store(Request $request, $kelasId)
    {
        $kelas = Kelas::findOrFail($kelasId);

        $request->validate([
            'name' => 'required|string|max:100',
            'nis' => 'required|string|max:20|unique:users,nis',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $siswa = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nis' => $request->nis,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
            'is_active' => true,
        ]);

        $siswa->kelasAsStudent()->attach($kelas->id, ['joined_at' => Carbon::now()]);

        return redirect()->route('guru.siswa.index', $kelasId)->with('success', "Siswa '{$siswa->name}' berhasil ditambahkan ke kelas.");
    }

    public function importCsv(Request $request, $kelasId)
    {
        $kelas = Kelas::findOrFail($kelasId);

        $request->validate([
            'file_csv' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $path = $request->file('file_csv')->getRealPath();
        $file = fopen($path, 'r');
        
        $header = fgetcsv($file); // format: nama, nis, email, password
        $importedCount = 0;

        while (($row = fgetcsv($file)) !== false) {
            if (count($row) >= 3) {
                $name = trim($row[0]);
                $nis = trim($row[1]);
                $email = trim($row[2]);
                $password = isset($row[3]) && !empty(trim($row[3])) ? trim($row[3]) : 'password123';

                if (!User::where('email', $email)->orWhere('nis', $nis)->exists()) {
                    $siswa = User::create([
                        'name' => $name,
                        'email' => $email,
                        'nis' => $nis,
                        'password' => Hash::make($password),
                        'role' => 'siswa',
                        'is_active' => true,
                    ]);

                    $siswa->kelasAsStudent()->attach($kelas->id, ['joined_at' => Carbon::now()]);
                    $importedCount++;
                }
            }
        }

        fclose($file);

        return redirect()->route('guru.siswa.index', $kelasId)->with('success', "Berhasil meng-import {$importedCount} data siswa.");
    }

    public function destroy($id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);
        $siswa->is_active = !$siswa->is_active;
        $siswa->save();

        return redirect()->back()->with('success', 'Status siswa berhasil diperbarui.');
    }

    public function deletePermanent($id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);
        $nama = $siswa->name;
        $siswa->delete();

        return redirect()->back()->with('success', "Data siswa '{$nama}' berhasil dihapus secara permanen.");
    }
}
