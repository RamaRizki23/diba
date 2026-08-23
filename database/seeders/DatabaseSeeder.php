<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Application;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@diba.test'],
            ['name' => 'Administrator DIBA', 'password' => 'password'],
        );

        Application::updateOrCreate(['code' => 'DIBA-001'], [
            'name' => 'Portal Data Aplikasi', 'owner' => 'Diskominfo', 'service' => 'Informasi',
            'sector' => 'Pemerintahan', 'status' => 'Aktif', 'year' => 2024,
            'language' => 'PHP', 'framework' => 'Laravel', 'database' => 'MySQL',
            'operating_system' => 'Linux', 'description' => 'Pusat inventaris aplikasi digital daerah.',
        ]);

        Application::updateOrCreate(['code' => 'DIBA-002'], [
            'name' => 'Layanan Perizinan Terpadu', 'owner' => 'DPMPTSP', 'service' => 'Pelayanan Publik',
            'sector' => 'Pelayanan', 'status' => 'Dalam Pengembangan', 'year' => 2025,
            'language' => 'PHP', 'framework' => 'Laravel', 'database' => 'MySQL',
            'operating_system' => 'Linux', 'description' => 'Pengajuan layanan perizinan secara digital.',
        ]);
    }
}
