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
        Storage::fake('local');
        $user = User::factory()->create();
        $finding = $this->createFinding();
        $evidence = UploadedFile::fake()->createWithContent('bukti-perbaikan.txt', 'Bukti perbaikan.');

        $this->actingAs($user)->post(route('security.findings.follow-up', $finding), [
            'follow_up' => 'Perbaikan telah diterapkan dan siap diperiksa.',
            'status' => 'Menunggu Verifikasi',
            'evidence' => [$evidence],
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
        $this->assertDatabaseHas('security_finding_evidence', [
            'security_finding_id' => $finding->id,
            'original_name' => 'bukti-perbaikan.txt',
        ]);
        Storage::disk('local')->assertExists($finding->evidence()->firstOrFail()->path);
    }

    public function test_follow_up_shows_a_clear_error_when_evidence_upload_fails(): void
    {
        $finding = $this->createFinding();
        $failedUpload = new UploadedFile(__FILE__, 'bukti.jpg', null, UPLOAD_ERR_INI_SIZE, true);

        $this->actingAs(User::factory()->create())
            ->from(route('security.findings.show', $finding))
            ->post(route('security.findings.follow-up', $finding), [
                'follow_up' => 'Perbaikan sudah dilakukan.',
                'status' => 'Dalam Penanganan',
                'evidence' => [$failedUpload],
            ])
            ->assertRedirect(route('security.findings.show', $finding))
            ->assertSessionHasErrors([
                'evidence.0' => 'Berkas melebihi batas maksimum upload server. Pilih foto yang lebih kecil.',
            ]);

        $this->assertDatabaseMissing('security_finding_evidence', [
            'security_finding_id' => $finding->id,
        ]);
    }

    public function test_follow_up_explains_when_an_evidence_upload_is_interrupted(): void
    {
        $finding = $this->createFinding();
        $interruptedUpload = new UploadedFile(__FILE__, 'bukti.jpg', null, UPLOAD_ERR_PARTIAL, true);

        $this->actingAs(User::factory()->create())
            ->from(route('security.findings.show', $finding))
            ->post(route('security.findings.follow-up', $finding), [
                'follow_up' => 'Perbaikan sudah dilakukan.',
                'status' => 'Dalam Penanganan',
                'evidence' => [$interruptedUpload],
            ])
            ->assertRedirect(route('security.findings.show', $finding))
            ->assertSessionHasErrors([
                'evidence.0' => 'Unggahan terputus sebelum selesai. Coba unggah ulang.',
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

    public function test_user_can_filter_findings_export_csv_and_download_evidence(): void
    {
        Storage::fake('local');
        $user = User::factory()->create();
        $finding = $this->createFinding();
        $finding->update(['title' => 'Temuan filter yang dicari']);
        $otherFinding = $this->createFinding('SEC-TEST-02', 'TMN-TEST-000002');
        $otherFinding->update([
            'title' => 'Temuan lain',
            'status' => 'Selesai',
        ]);

        $this->actingAs($user)
            ->get(route('security.findings.index', ['status' => 'Baru', 'search' => 'filter yang dicari']))
            ->assertOk()
            ->assertSee($finding->reference_code)
            ->assertDontSee($otherFinding->reference_code);

        $export = $this->get(route('security.findings.export', ['status' => 'Baru', 'search' => 'filter yang dicari']));
        $export->assertOk()->assertHeader('content-type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString($finding->reference_code, $export->streamedContent());
        $this->assertStringNotContainsString($otherFinding->reference_code, $export->streamedContent());

        $path = 'security-evidence/'.$finding->id.'/bukti.txt';
        Storage::disk('local')->put($path, 'Bukti pengujian.');
        $evidence = $finding->evidence()->create([
            'original_name' => 'bukti.txt',
            'path' => $path,
            'mime_type' => 'text/plain',
            'size' => 16,
        ]);

        $this->get(route('security.findings.show', $finding))
            ->assertOk()
            ->assertSee('bukti.txt');
        $this->get(route('security.findings.evidence', [$finding, $evidence]))
            ->assertDownload('bukti.txt');
    }

    public function test_user_can_update_status_and_a_deadline_today_is_not_overdue(): void
    {
        $this->travelTo(now()->setTime(12, 0));
        $user = User::factory()->create();
        $finding = $this->createFinding();
        $finding->update(['deadline' => today()->toDateString()]);

        $this->actingAs($user)
            ->get(route('security.findings.show', $finding))
            ->assertOk()
            ->assertSee('Hari ini')
            ->assertDontSee('Terlambat');
        $this->get(route('security.dashboard'))
            ->assertOk()
            ->assertViewHas('actionCount', 0);

        $this->patch(route('security.findings.status', $finding), [
            'status' => 'Selesai',
            'note' => 'Perbaikan telah diverifikasi.',
        ])->assertRedirect();

        $this->assertDatabaseHas('security_findings', [
            'id' => $finding->id,
            'status' => 'Selesai',
        ]);
        $this->assertNotNull($finding->fresh()->verified_at);
        $this->assertDatabaseHas('security_finding_activities', [
            'security_finding_id' => $finding->id,
            'event' => 'Status diubah',
            'from_status' => 'Baru',
            'to_status' => 'Selesai',
            'note' => 'Perbaikan telah diverifikasi.',
        ]);
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

    private function createFinding(
        string $applicationCode = 'SEC-TEST-01',
        string $referenceCode = 'TMN-TEST-000001'
    ): SecurityFinding
    {
        $application = $this->createTestApplication($applicationCode);

        return SecurityFinding::query()->create([
            'reference_code' => $referenceCode,
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
