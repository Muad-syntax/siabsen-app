<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $guru = User::where('role', 'guru')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.guru.index', compact('guru', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'nip' => 'nullable|string|max:20|unique:users,nip',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip,
            'password' => Hash::make($request->password),
            'role' => 'guru',
            'is_active' => true,
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Akun Guru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $guru = User::where('role', 'guru')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $guru->id,
            'nip' => 'nullable|string|max:20|unique:users,nip,' . $guru->id,
        ]);

        $guru->update([
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip,
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Data Guru berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $guru = User::where('role', 'guru')->findOrFail($id);
        // Soft toggle status active/nonactive
        $guru->is_active = !$guru->is_active;
        $guru->save();

        $statusText = $guru->is_active ? 'diaktifkan kembali' : 'dinonaktifkan';
        return redirect()->route('admin.guru.index')->with('success', "Akun Guru '{$guru->name}' berhasil {$statusText}.");
    }

    public function deletePermanent($id)
    {
        $guru = User::where('role', 'guru')->findOrFail($id);
        $nama = $guru->name;
        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', "Akun Guru '{$nama}' berhasil dihapus secara permanen.");
    }

    public function resetPassword(Request $request, $id)
    {
        $guru = User::where('role', 'guru')->findOrFail($id);

        $request->validate([
            'new_password' => 'required|string|min:6',
        ]);

        $guru->password = Hash::make($request->new_password);
        $guru->save();

        return redirect()->route('admin.guru.index')->with('success', "Password Guru '{$guru->name}' berhasil diperbarui.");
    }
}
