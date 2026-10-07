@extends('layouts.app')
@section('content')
@include('security._styles')
<div class="security-page">
    <header class="sec-head"><div><div class="sec-crumb"><a href="{{ route('security.dashboard') }}">Beranda</a>　›　Keamanan Aplikasi　›　Temuan Keamanan</div><h1 class="page-title">Temuan Keamanan</h1><p class="sec-subtitle">Daftar temuan keamanan aplikasi/website di lingkungan Pemerintah Provinsi Jawa Barat.</p></div><a class="sec-button" href="{{ route('security.findings.create') }}"><i class="bi bi-plus-lg"></i> Tambah Temuan</a></header>
    @if(session('success'))<div class="sec-alert"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>@endif
    @if($errors->any())<div class="alert errors"><ul style="margin:0;padding-left:18px">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <section class="sec-card" style="margin-bottom:14px">
        <form class="sec-filter" method="GET" action="{{ route('security.findings.index') }}">
            <div><label for="filter-type">Jenis Temuan</label><select id="filter-type" name="type"><option value="">Semua Jenis</option>@foreach($types as $type)<option value="{{ $type }}" @selected(($filters['type'] ?? '') === $type)>{{ $type }}</option>@endforeach</select></div>
            <div><label for="filter-status">Status</label><select id="filter-status" name="status"><option value="">Semua Status</option>@foreach(\App\Models\SecurityFinding::STATUSES as $status)<option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ $status }}</option>@endforeach</select></div>
            <div><label for="filter-severity">Severity</label><select id="filter-severity" name="severity"><option value="">Semua Severity</option>@foreach(\App\Models\SecurityFinding::SEVERITIES as $severity)<option value="{{ $severity }}" @selected(($filters['severity'] ?? '') === $severity)>{{ $severity }}</option>@endforeach</select></div>
            <div><label for="filter-owner">Perangkat Daerah</label><select id="filter-owner" name="owner"><option value="">Semua Perangkat Daerah</option>@foreach($owners as $owner)<option value="{{ $owner }}" @selected(($filters['owner'] ?? '') === $owner)>{{ $owner }}</option>@endforeach</select></div>
            <div class="search-field"><label for="filter-search">Cari temuan</label><input id="filter-search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Aplikasi, URL, nomor, deskripsi..."></div>
            <div class="sec-filter-actions"><button class="sec-button" type="submit"><i class="bi bi-search"></i> Filter</button></div>
            <div class="sec-filter-actions"><a class="sec-button light" href="{{ route('security.findings.index') }}"><i class="bi bi-arrow-counterclockwise"></i> Reset</a></div>
        </form>
    </section>
    <section class="sec-card">
        <div class="sec-toolbar"><span>Menampilkan {{ $findings->firstItem() ?: 0 }}–{{ $findings->lastItem() ?: 0 }} dari <strong>{{ $findings->total() }}</strong> temuan</span><a class="sec-button light" href="{{ route('security.findings.export', array_filter($filters)) }}"><i class="bi bi-file-earmark-spreadsheet"></i> Export CSV</a></div>
        <div class="sec-table-wrap"><table class="sec-table"><thead><tr><th>#</th><th>Tanggal Temuan</th><th>Aplikasi</th><th>URL</th><th>Perangkat Daerah</th><th>Jenis Temuan</th><th>Severity</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
            @forelse($findings as $finding)
                <tr><td>{{ $findings->firstItem() + $loop->index }}</td><td>{{ $finding->found_at?->format('d M Y') }}</td><td><a class="cell-title" href="{{ route('security.findings.show', $finding) }}">{{ $finding->application_name }}</a><div class="cell-sub">{{ $finding->reference_code }}</div></td><td>@if($finding->application_url)<a href="{{ $finding->application_url }}" target="_blank" rel="noopener">{{ parse_url($finding->application_url, PHP_URL_HOST) ?: $finding->application_url }}</a>@else—@endif</td><td>{{ $finding->owner }}</td><td>{{ $finding->finding_type }}</td><td><span class="sec-badge {{ strtolower($finding->severity) }}">{{ $finding->severity }}</span></td><td><span class="sec-badge status-{{ $finding->status === 'Baru' ? 'baru' : ($finding->status === 'Dalam Penanganan' ? 'dalam' : ($finding->status === 'Menunggu Verifikasi' ? 'menunggu' : 'selesai')) }}">{{ $finding->status }}</span></td><td><a class="sec-button small" href="{{ route('security.findings.show', $finding) }}"><i class="bi bi-eye"></i> Detail</a></td></tr>
            @empty
                <tr><td colspan="9" class="sec-empty">Tidak ada temuan yang sesuai filter.</td></tr>
            @endforelse
        </tbody></table></div>
        <div class="sec-pagination"><span>Menampilkan {{ $findings->firstItem() ?: 0 }} sampai {{ $findings->lastItem() ?: 0 }} dari {{ $findings->total() }} entri</span><nav class="sec-pages" aria-label="Navigasi halaman"><a class="{{ $findings->onFirstPage() ? 'disabled' : '' }}" href="{{ $findings->previousPageUrl() ?: '#' }}" aria-label="Sebelumnya">&laquo;</a>@foreach($findings->getUrlRange(max(1, $findings->currentPage() - 2), min(max(1, $findings->lastPage()), $findings->currentPage() + 2)) as $page => $url)<a class="{{ $page == $findings->currentPage() ? 'current' : '' }}" href="{{ $url }}">{{ $page }}</a>@endforeach<a class="{{ $findings->currentPage() >= $findings->lastPage() ? 'disabled' : '' }}" href="{{ $findings->nextPageUrl() ?: '#' }}" aria-label="Selanjutnya">&raquo;</a></nav></div>
    </section>
</div>
@endsection
