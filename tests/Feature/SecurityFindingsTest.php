<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\SecurityFinding;
use App\Models\SecurityFindingActivity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SecurityFindingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_security_dashboard_requires_login_and_loads_for_authenticated_users(): void
    {
        $this->get(route('security.dashboard'))->assertRedirect(route('login'));

        $this->actingAs(User::factory()->create())
            ->get(route('security.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Keamanan Aplikasi')
            ->assertSee('Status Temuan');
    }

    public function test_user_can_create_finding_and_store_evidence_privately(): void
    {
        Storage::fake('local');
        $user = User::factory()->create();
        $application = $this->createTestApplication();

        $response = $this->actingAs($user)->post(route('security.findings.store'), [
            'application_id' => $application->id,
            'title' => 'Uji konfigurasi keamanan',
            'finding_type' => 'Misconfiguration',
            'severity' => 'Medium',
            'source' => 'Audit Keamanan',
            'found_at' => now()->subDay()->format('Y-m-d H:i:s'),
            'description' => 'Deskripsi temuan untuk pengujian.',
            'recommendation' => 'Terapkan perbaikan dan lakukan verifikasi.',
            'pic_name' => 'PIC Uji',
            'pic_email' => 'pic@example.test',
            'deadline' => now()->addDays(3)->toDateString(),
            'evidence' => [UploadedFile::fake()->createWithContent('bukti.txt', 'Bukti pengujian.')],
        ]);

        $finding = SecurityFinding::query()->firstOrFail();
        $response->assertRedirect(route('security.findings.show', $finding));
        $this->assertDatabaseHas('security_findings', [
            'id' => $finding->id,
            'application_name' => $application->name,
            'owner' => $application->owner,
            'status' => 'Baru',
        ]);
        $this->assertDatabaseHas('security_finding_activities', [
            'security_finding_id' => $finding->id,
            'event' => 'Temuan dibuat',
        ]);
        $this->assertDatabaseHas('security_finding_evidence', ['security_finding_id' => $finding->id]);
        Storage::disk('local')->assertExists($finding->evidence()->firstOrFail()->path);
    }

    public function test_user_can_record_follow_up_and_change_finding_status(): void
    {
        $user = User::factory()->create();
        $finding = $this->createFinding();

        $this->actingAs($user)->post(route('security.findings.follow-up', $finding), [
            'follow_up' => 'Perbaikan telah diterapkan dan siap diperiksa.',
            'status' => 'Menunggu Verifikasi',
        ])->assertRedirect();

        $this->assertDatabaseHas('security_findings', [
            'id' => $finding->id,
            'status' => 'Menunggu Verifikasi',
            'follow_up' => 'Perbaikan telah diterapkan dan siap diperiksa.',
        ]);
        $this->assertDatabaseHas('security_finding_activities', [
            'security_finding_id' => $finding->id,
            'event' => 'Tindak lanjut diperbarui',
            'to_status' => 'Menunggu Verifikasi',
        ]);
    }

    public function test_user_can_download_a_finding_memo_as_pdf(): void
    {
        $finding = $this->createFinding();

        $this->actingAs(User::factory()->create())
            ->get(route('security.findings.memo', $finding))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');
    }

    public function test_dashboard_filters_search_all_rows_and_keep_scope_separate(): void
    {
        $this->actingAs(User::factory()->create());
        $this->createTestApplication('SEARCH-01', 'Aplikasi Filter Khusus', 'Dinas Pendidikan');
        $this->createTestApplication('SEARCH-02', 'Aplikasi Lain', 'Dinas Pendidikan');
        $this->createTestApplication('CITY-01', 'Aplikasi Wilayah Kota', 'Pemerintah Kota Cimahi');
        $this->createTestApplication('PROV-01', 'Aplikasi Wilayah Provinsi', 'Pemerintah Provinsi Jawa Barat');

        $this->get(route('dashboard', ['scope' => 'provinsi', 'search' => 'Filter Khusus']))
            ->assertOk()
            ->assertSee('Aplikasi Filter Khusus')
            ->assertDontSee('Aplikasi Lain');

        $this->get(route('dashboard', ['scope' => 'kabupaten-kota', 'search' => 'Wilayah Kota']))
            ->assertOk()
            ->assertSee('Aplikasi Wilayah Kota')
            ->assertDontSee('Aplikasi Wilayah Provinsi');
    }

    private function createTestApplication(
        string $code = 'SEC-TEST-01',
        string $name = 'Aplikasi Uji Keamanan',
        string $owner = 'Dinas Uji'
    ): Application
    {
        return Application::query()->create([
            'code' => $code,
            'name' => $name,
            'owner' => $owner,
            'url' => 'https://uji.example.test',
            'status' => 'Aktif',
        ]);
    }

    private function createFinding(): SecurityFinding
    {
        $application = $this->createTestApplication();

        return SecurityFinding::query()->create([
            'reference_code' => 'TMN-TEST-000001',
            'application_id' => $application->id,
            'application_name' => $application->name,
            'application_url' => $application->url,
            'owner' => $application->owner,
            'title' => 'Temuan pengujian',
            'finding_type' => 'Vulnerability',
            'category' => 'Keamanan Aplikasi',
            'severity' => 'High',
            'source' => 'Audit Keamanan',
            'found_at' => now()->subDay(),
            'description' => 'Deskripsi uji.',
            'recommendation' => 'Rekomendasi uji.',
            'status' => 'Baru',
        ]);
    }
}
