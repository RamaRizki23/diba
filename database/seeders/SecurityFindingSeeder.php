<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\SecurityFinding;
use App\Models\SecurityFindingActivity;
use App\Models\User;
use Illuminate\Database\Seeder;

class SecurityFindingSeeder extends Seeder
{
    public function run(): void
    {
        $reporterId = User::query()->where('role', 'admin')->value('id');
        $samples = [
            ['TMN-2026-000101', 'JABAR-001', 'Paparan informasi sensitif pada portal layanan', 'PII Exposure', 'High', 'Monitoring SOC', 'Baru', 2, 5],
            ['TMN-2026-000102', 'DIBA-001', 'Konfigurasi keamanan perlu ditinjau', 'Misconfiguration', 'Medium', 'Audit Keamanan', 'Dalam Penanganan', 3, 8],
            ['TMN-2026-000103', 'JABAR-002', 'Indikasi aktivitas tidak wajar pada endpoint', 'Malicious Activity', 'High', 'Monitoring SOC', 'Menunggu Verifikasi', 4, 6],
            ['TMN-2026-000104', 'JABAR-003', 'Pembaruan komponen aplikasi diperlukan', 'Vulnerability', 'Medium', 'Pengujian Keamanan', 'Selesai', 6, -2],
            ['TMN-2026-000105', 'JABAR-004', 'Paparan kredensial pada repositori publik', 'Credential Leak', 'High', 'Laporan Eksternal', 'Baru', 1, 4],
        ];

        foreach ($samples as [$reference, $applicationCode, $title, $type, $severity, $source, $status, $daysAgo, $deadlineIn]) {
            $application = Application::query()->where('code', $applicationCode)->first();
            if (! $application) {
                continue;
            }

            $finding = SecurityFinding::updateOrCreate(['reference_code' => $reference], [
                'application_id' => $application->id,
                'reporter_id' => $reporterId,
                'application_name' => $application->name,
                'application_url' => $application->url,
                'owner' => $application->owner ?: 'Belum ditentukan',
                'title' => $title,
                'finding_type' => $type,
                'category' => 'Keamanan Aplikasi',
                'severity' => $severity,
                'source' => $source,
                'found_at' => now()->subDays($daysAgo)->setTime(10, 23),
                'description' => 'Temuan ini dicatat sebagai data demonstrasi untuk memperlihatkan alur pencatatan, penilaian risiko, dan tindak lanjut keamanan aplikasi.',
                'impact' => 'Tinjau konfigurasi dan data yang dapat diakses. Lakukan verifikasi teknis sebelum perubahan diterapkan ke lingkungan produksi.',
                'recommendation' => "1. Validasi temuan pada lingkungan yang berwenang.\n2. Terapkan perbaikan sesuai prosedur perubahan.\n3. Dokumentasikan bukti perbaikan dan minta verifikasi.",
                'status' => $status,
                'deadline' => now()->addDays($deadlineIn)->toDateString(),
                'pic_name' => $application->pic ?: 'PIC '.$application->owner,
                'pic_email' => null,
                'internal_note' => null,
                'verified_at' => $status === 'Selesai' ? now()->subDay() : null,
            ]);

            SecurityFindingActivity::firstOrCreate([
                'security_finding_id' => $finding->id,
                'event' => 'Temuan dibuat',
            ], [
                'user_id' => $reporterId,
                'to_status' => 'Baru',
                'note' => 'Data demonstrasi untuk pratinjau modul.',
            ]);
        }
    }
}
