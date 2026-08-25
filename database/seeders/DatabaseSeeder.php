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

        $samples = [
            ['DIBA-003', 'Portal Kebudayaan Daerah', 'Dinas Pariwisata dan Kebudayaan', 'Aktif'],
            ['DIBA-004', 'Layanan Kedaruratan Daerah', 'Badan Penanggulangan Bencana Daerah', 'Aktif'],
            ['DIBA-005', 'Sistem Pendapatan Daerah', 'Badan Pendapatan Daerah', 'Aktif'],
            ['DIBA-006', 'Manajemen Keuangan Daerah', 'Badan Pengelolaan Keuangan dan Aset Daerah', 'Aktif'],
            ['DIBA-007', 'Data Kepegawaian Terpadu', 'Badan Kepegawaian Daerah', 'Dalam Pengembangan'],
            ['DIBA-008', 'Sistem Informasi Perencanaan', 'Badan Perencanaan Pembangunan Daerah', 'Aktif'],
            ['DIBA-009', 'Katalog Layanan Digital', 'Dinas Komunikasi dan Informatika', 'Aktif'],
        ];

        foreach ($samples as [$code, $name, $owner, $status]) {
            Application::updateOrCreate(['code' => $code], [
                'name' => $name, 'owner' => $owner, 'service' => 'Informasi',
                'sector' => 'Pemerintahan', 'status' => $status, 'year' => 2024,
                'language' => 'PHP', 'framework' => 'Laravel', 'database' => 'MySQL',
                'operating_system' => 'Linux', 'description' => 'Contoh data katalog aplikasi daerah.',
            ]);
        }
    }
}
