<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Industry;
use App\Models\Period;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Period
        $period = Period::create([
            'name' => 'Prakerind 2025/2026 - Semester Genap',
            'start_date' => '2026-01-06',
            'end_date' => '2026-06-30',
            'is_active' => true,
        ]);

        // Create Industries
        $industry1 = Industry::create([
            'name' => 'PT Teknologi Maju Indonesia',
            'address' => 'Jl. Sudirman No. 123, Jakarta Selatan',
            'phone' => '021-5550123',
            'email' => 'info@teknomaaju.co.id',
            'contact_person' => 'Budi Santoso',
            'latitude' => -6.2088,
            'longitude' => 106.8456,
            'geofence_radius' => 150,
        ]);

        $industry2 = Industry::create([
            'name' => 'CV Digital Kreatif Nusantara',
            'address' => 'Jl. Gatot Subroto No. 45, Bandung',
            'phone' => '022-5550456',
            'email' => 'hrd@digitalkreatif.id',
            'contact_person' => 'Siti Rahayu',
            'latitude' => -6.9175,
            'longitude' => 107.6191,
            'geofence_radius' => 100,
        ]);

        // Create Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@jurnal.app',
            'password' => 'password',
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create Guru Pembimbing
        $guru = User::create([
            'name' => 'Drs. Ahmad Hidayat, M.Pd',
            'email' => 'guru@jurnal.app',
            'password' => 'password',
            'role' => 'guru_pembimbing',
            'nip' => '198501152010011002',
            'jabatan' => 'Guru Pembimbing PKL',
            'is_active' => true,
        ]);

        // Create Pembimbing Industri
        $pembimbing1 = User::create([
            'name' => 'Ir. Rudi Hermawan',
            'email' => 'pembimbing@jurnal.app',
            'password' => 'password',
            'role' => 'pembimbing_industri',
            'jabatan' => 'Senior Developer',
            'industry_id' => $industry1->id,
            'is_active' => true,
        ]);

        // Create Siswa
        User::create([
            'name' => 'Andi Prasetyo',
            'email' => 'siswa@jurnal.app',
            'password' => 'password',
            'role' => 'siswa',
            'nisn' => '0051234567',
            'kelas' => 'XII RPL 1',
            'jurusan' => 'Rekayasa Perangkat Lunak',
            'industry_id' => $industry1->id,
            'guru_pembimbing_id' => $guru->id,
            'pembimbing_industri_id' => $pembimbing1->id,
            'period_id' => $period->id,
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Dewi Lestari',
            'email' => 'siswa2@jurnal.app',
            'password' => 'password',
            'role' => 'siswa',
            'nisn' => '0051234568',
            'kelas' => 'XII RPL 2',
            'jurusan' => 'Rekayasa Perangkat Lunak',
            'industry_id' => $industry2->id,
            'guru_pembimbing_id' => $guru->id,
            'pembimbing_industri_id' => $pembimbing1->id,
            'period_id' => $period->id,
            'is_active' => true,
        ]);
    }
}
