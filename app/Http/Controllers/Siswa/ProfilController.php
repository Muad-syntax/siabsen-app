<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $kelas = $user->kelasAsStudent()->first();

        return view('siswa.profil', compact('user', 'kelas'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Password lama Anda tidak sesuai.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('siswa.profil')->with('success', 'Password berhasil diperbarui.');
    }
}
