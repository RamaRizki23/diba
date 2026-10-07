<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\SecurityFinding;
use App\Models\SecurityFindingActivity;
use App\Models\SecurityFindingEvidence;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SecurityFindingController extends Controller
{
    private const TYPES = ['Credential Leak', 'Malicious Activity', 'Vulnerability', 'Web Defacement', 'PII Exposure', 'Misconfiguration', 'Lainnya'];

    private const SOURCES = ['Monitoring SOC', 'Audit Keamanan', 'Laporan Eksternal', 'Pengujian Keamanan', 'Lainnya'];

    public function dashboard(): View
    {
        $findings = SecurityFinding::query()
            ->when(request()->filled('owner'), fn (Builder $query) => $query->where('owner', request('owner')));
        $all = (clone $findings)->get();
        $statusCounts = collect(SecurityFinding::STATUSES)->mapWithKeys(fn (string $status) => [$status => $all->where('status', $status)->count()]);
        $typeCounts = $all->groupBy('finding_type')->map->count()->sortDesc();

        return view('security.dashboard', [
            'total' => $all->count(),
            'openCount' => $all->whereIn('status', ['Baru', 'Dalam Penanganan', 'Menunggu Verifikasi'])->count(),
            'highCount' => $all->where('severity', 'High')->whereNotIn('status', ['Selesai'])->count(),
            'actionCount' => $all->filter(fn (SecurityFinding $finding) => $finding->deadline && $finding->deadline->isPast() && $finding->status !== 'Selesai')->count(),
            'statusCounts' => $statusCounts,
            'typeCounts' => $typeCounts,
            'recent' => (clone $findings)->with('application')->latest('found_at')->take(8)->get(),
            'unitName' => request('owner'),
            'owners' => SecurityFinding::query()->select('owner')->distinct()->orderBy('owner')->pluck('owner'),
        ]);
    }

    public function index(Request $request): View
    {
        $filters = $request->only(['status', 'severity', 'type', 'owner', 'search']);
        $findings = SecurityFinding::query()
            ->with('application')
            ->filtered($filters)
            ->latest('found_at')
            ->paginate(10)
            ->withQueryString();

        return view('security.index', [
            'findings' => $findings,
            'filters' => $filters,
            'types' => self::TYPES,
            'owners' => SecurityFinding::query()->select('owner')->distinct()->orderBy('owner')->pluck('owner'),
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $findings = SecurityFinding::query()
            ->with('application')
            ->filtered($request->only(['status', 'severity', 'type', 'owner', 'search']))
            ->latest('found_at');

        return response()->streamDownload(function () use ($findings): void {
            $output = fopen('php://output', 'w');
            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, ['Nomor Temuan', 'Tanggal Temuan', 'Aplikasi', 'URL', 'Perangkat Daerah', 'Jenis Temuan', 'Severity', 'Status', 'Batas Tindak Lanjut']);
            $findings->chunk(200, function ($items) use ($output): void {
                foreach ($items as $finding) {
                    fputcsv($output, [
                        $finding->reference_code, $finding->found_at?->format('d-m-Y H:i'), $finding->application_name,
                        $finding->application_url, $finding->owner, $finding->finding_type, $finding->severity,
                        $finding->status, $finding->deadline?->format('d-m-Y'),
                    ]);
                }
            });
            fclose($output);
        }, 'temuan-keamanan-'.now()->format('Ymd-His').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function create(): View
    {
        return view('security.create', [
            'applications' => Application::query()->orderBy('name')->get(['id', 'name', 'url', 'owner', 'pic', 'pic_phone']),
            'types' => self::TYPES,
            'sources' => self::SOURCES,
            'statuses' => SecurityFinding::STATUSES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'application_id' => ['required', 'integer', 'exists:applications,id'],
            'title' => ['required', 'string', 'max:180'],
            'finding_type' => ['required', Rule::in(self::TYPES)],
            'severity' => ['required', Rule::in(SecurityFinding::SEVERITIES)],
            'source' => ['required', Rule::in(self::SOURCES)],
            'found_at' => ['required', 'date'],
            'description' => ['required', 'string', 'max:10000'],
            'impact' => ['nullable', 'string', 'max:5000'],
            'recommendation' => ['nullable', 'string', 'max:10000'],
            'deadline' => ['nullable', 'date', 'after_or_equal:today'],
            'pic_name' => ['nullable', 'string', 'max:150'],
            'pic_email' => ['nullable', 'email', 'max:190'],
            'internal_note' => ['nullable', 'string', 'max:500'],
            'evidence.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,zip,txt,log', 'max:10240'],
        ]);
        $files = array_filter($request->file('evidence', []));
        validator(['evidence' => $files], ['evidence' => ['array', 'max:10']])->validate();
        $application = Application::query()->findOrFail($validated['application_id']);

        $finding = DB::transaction(function () use ($validated, $application, $request, $files): SecurityFinding {
            $finding = SecurityFinding::create([
                ...$validated,
                'reference_code' => 'TMP-'.Str::uuid(),
                'reporter_id' => $request->user()->id,
                'application_name' => $application->name,
                'application_url' => $application->url,
                'owner' => $application->owner ?: 'Belum ditentukan',
                'category' => 'Keamanan Aplikasi',
                'status' => 'Baru',
            ]);
            $finding->update(['reference_code' => sprintf('TMN-%s-%06d', now()->format('Y'), $finding->id)]);

            SecurityFindingActivity::create([
                'security_finding_id' => $finding->id,
                'user_id' => $request->user()->id,
                'event' => 'Temuan dibuat',
                'to_status' => 'Baru',
                'note' => 'Temuan keamanan dicatat ke dalam sistem.',
            ]);
            $this->storeEvidence($finding, $files, $request);

            return $finding;
        });

        return redirect()->route('security.findings.show', $finding)->with('success', 'Temuan keamanan berhasil disimpan.');
    }

    public function show(SecurityFinding $finding): View
    {
        $finding->load(['application', 'reporter', 'evidence.uploader', 'activities.user']);

        return view('security.show', ['finding' => $finding, 'statuses' => SecurityFinding::STATUSES]);
    }

    public function followUp(Request $request, SecurityFinding $finding): RedirectResponse
    {
        $validated = $request->validate([
            'follow_up' => ['required', 'string', 'max:10000'],
            'status' => ['required', Rule::in(['Dalam Penanganan', 'Menunggu Verifikasi', 'Selesai'])],
            'evidence.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,zip,txt,log', 'max:10240'],
        ]);
        $files = array_filter($request->file('evidence', []));
        validator(['evidence' => $files], ['evidence' => ['array', 'max:10']])->validate();
        $fromStatus = $finding->status;

        DB::transaction(function () use ($finding, $validated, $request, $files, $fromStatus): void {
            $finding->update([
                'follow_up' => $validated['follow_up'],
                'status' => $validated['status'],
                'verified_at' => $validated['status'] === 'Selesai' ? now() : null,
            ]);
            SecurityFindingActivity::create([
                'security_finding_id' => $finding->id,
                'user_id' => $request->user()->id,
                'event' => 'Tindak lanjut diperbarui',
                'from_status' => $fromStatus,
                'to_status' => $validated['status'],
                'note' => Str::limit($validated['follow_up'], 450),
            ]);
            $this->storeEvidence($finding, $files, $request);
        });

        return back()->with('success', 'Tindak lanjut berhasil dicatat.');
    }

    public function updateStatus(Request $request, SecurityFinding $finding): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(SecurityFinding::STATUSES)],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);
        $fromStatus = $finding->status;
        $finding->update([
            'status' => $validated['status'],
            'verified_at' => $validated['status'] === 'Selesai' ? now() : null,
        ]);
        SecurityFindingActivity::create([
            'security_finding_id' => $finding->id,
            'user_id' => $request->user()->id,
            'event' => 'Status diubah',
            'from_status' => $fromStatus,
            'to_status' => $validated['status'],
            'note' => $validated['note'] ?? null,
        ]);

        return back()->with('success', 'Status temuan berhasil diperbarui.');
    }

    public function downloadEvidence(SecurityFinding $finding, SecurityFindingEvidence $evidence)
    {
        abort_unless($evidence->security_finding_id === $finding->id, 404);
        abort_unless(Storage::exists($evidence->path), 404);

        return Storage::download($evidence->path, $evidence->original_name);
    }

    public function memo(SecurityFinding $finding)
    {
        $finding->load(['application', 'evidence']);

        return Pdf::loadView('security.memo', ['finding' => $finding])
            ->setPaper('a4')
            ->download('nota-dinas-'.$finding->reference_code.'.pdf');
    }

    /** @param array<int, \Illuminate\Http\UploadedFile> $files */
    private function storeEvidence(SecurityFinding $finding, array $files, Request $request): void
    {
        foreach ($files as $file) {
            $path = $file->store('security-evidence/'.$finding->id);
            SecurityFindingEvidence::create([
                'security_finding_id' => $finding->id,
                'uploaded_by' => $request->user()->id,
                'original_name' => $file->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize() ?: 0,
            ]);
        }
    }
}
