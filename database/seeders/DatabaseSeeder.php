<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kelas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin Default (Kepala Sekolah)
        $admin = User::create([
            'name' => 'Kepala Sekolah (Admin)',
            'email' => 'admin@absensiku.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // 2. Data Guru
        $guru1 = User::create([
            'name' => 'Budi Santoso, S.Pd.',
            'email' => 'guru1@absensiku.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'nip' => '198501012010011001',
            'is_active' => true,
        ]);

        $guru2 = User::create([
            'name' => 'Siti Aminah, M.Pd.',
            'email' => 'guru2@absensiku.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'nip' => '199002022015022002',
            'is_active' => true,
        ]);

        // 3. Data Kelas
        $kelas1 = Kelas::create([
            'nama_kelas' => 'X-IPA-1',
            'tingkat' => 'X',
            'jurusan' => 'IPA',
            'tahun_ajaran' => '2026/2027',
            'wali_kelas_id' => $guru1->id,
            'is_active' => true,
        ]);

        $kelas2 = Kelas::create([
            'nama_kelas' => 'XI-IPA-2',
            'tingkat' => 'XI',
            'jurusan' => 'IPA',
            'tahun_ajaran' => '2026/2027',
            'wali_kelas_id' => $guru2->id,
            'is_active' => true,
        ]);

        // Guru mengajar di kelas
        $guru1->kelasYangDiajar()->attach([$kelas1->id, $kelas2->id]);
        $guru2->kelasYangDiajar()->attach([$kelas2->id]);

        // 4. Data Siswa
        $siswas = [
            [
                'name' => 'Ahmad Rizky',
                'email' => 'siswa1@absensiku.com',
                'nis' => '20261001',
            ],
            [
                'name' => 'Ani Rahayu',
                'email' => 'siswa2@absensiku.com',
                'nis' => '20261002',
            ],
            [
                'name' => 'Citra Dewi',
                'email' => 'siswa3@absensiku.com',
                'nis' => '20261003',
            ],
            [
                'name' => 'Doni Pratama',
                'email' => 'siswa4@absensiku.com',
                'nis' => '20261004',
            ],
        ];

        foreach ($siswas as $sData) {
            $siswa = User::create([
                'name' => $sData['name'],
                'email' => $sData['email'],
                'password' => Hash::make('password'),
                'role' => 'siswa',
                'nis' => $sData['nis'],
                'is_active' => true,
            ]);

            // daftarkan ke kelas X-IPA-1
            $siswa->kelasAsStudent()->attach($kelas1->id, ['joined_at' => Carbon::now()->subMonths(2)]);
        }
    }
}
