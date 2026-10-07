@extends('layouts.app')
@section('content')
@include('security._styles')
@php
    $allStatuses = ['Baru' => '#ed4b55', 'Dalam Penanganan' => '#f2ae28', 'Menunggu Verifikasi' => '#1686eb', 'Selesai' => '#23ad79'];
    $parts = [];
    $angle = 0;
    $base = max(1, $total);
    foreach ($allStatuses as $label => $color) {
        $next = $angle + (($statusCounts[$label] / $base) * 360);
        $parts[] = $color.' '.$angle.'deg '.$next.'deg';
        $angle = $next;
    }
    $donutStyle = 'conic-gradient('.implode(', ', $parts).')';
    $maxType = max(1, (int) $typeCounts->max());
@endphp
<div class="security-page">
    <header class="sec-head"><div><div class="sec-crumb"><a href="{{ route('dashboard') }}">Beranda</a>　›　Keamanan Aplikasi　›　Dashboard</div><h1 class="page-title">Dashboard Keamanan Aplikasi</h1><p class="sec-subtitle">Ringkasan temuan keamanan aplikasi dan tindak lanjut perangkat daerah.</p></div><form method="GET"><select name="owner" aria-label="Pilih perangkat daerah" onchange="this.form.submit()" style="min-width:240px;padding:10px;border:1px solid #dce5ee;border-radius:5px;background:#fff"><option value="">Semua Perangkat Daerah</option>@foreach($owners as $owner)<option value="{{ $owner }}" @selected($unitName === $owner)>{{ $owner }}</option>@endforeach</select></form></header>
    <div class="sec-metrics">
        <article class="sec-metric blue"><strong>{{ $total }}</strong><span>Total Temuan</span><i class="bi bi-shield-lock-fill"></i></article>
        <article class="sec-metric green"><strong>{{ $statusCounts['Selesai'] }}</strong><span>Temuan Selesai</span><i class="bi bi-shield-check"></i></article>
        <article class="sec-metric red"><strong>{{ $highCount }}</strong><span>Temuan High Aktif</span><i class="bi bi-exclamation-octagon-fill"></i></article>
        <article class="sec-metric yellow"><strong>{{ $actionCount }}</strong><span>Lewat Batas Tindak Lanjut</span><i class="bi bi-clock-fill"></i></article>
    </div>
    <section class="sec-card">
        <div class="sec-card-head"><span><i class="bi bi-lock-fill"></i> Temuan Keamanan Terbaru</span><div class="sec-actions"><a class="sec-button light" href="{{ route('security.findings.index') }}">Lihat Semua <i class="bi bi-arrow-right"></i></a><a class="sec-button" href="{{ route('security.findings.create') }}"><i class="bi bi-plus-lg"></i> Tambah Temuan</a></div></div>
        <div class="sec-table-wrap"><table class="sec-table"><thead><tr><th>#</th><th>Aplikasi</th><th>Jenis Temuan</th><th>Tanggal</th><th>Severity</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
        @forelse($recent as $finding)
            <tr><td>{{ $loop->iteration }}</td><td><div class="cell-title">{{ $finding->application_name }}</div><div class="cell-sub">{{ $finding->owner }} · {{ $finding->reference_code }}</div></td><td>{{ $finding->finding_type }}</td><td>{{ $finding->found_at?->format('d M Y') }}</td><td><span class="sec-badge {{ strtolower($finding->severity) }}">{{ $finding->severity }}</span></td><td><span class="sec-badge status-{{ $finding->status === 'Baru' ? 'baru' : ($finding->status === 'Dalam Penanganan' ? 'dalam' : ($finding->status === 'Menunggu Verifikasi' ? 'menunggu' : 'selesai')) }}">{{ $finding->status }}</span></td><td><a class="sec-button small" href="{{ route('security.findings.show', $finding) }}"><i class="bi bi-eye"></i> Detail</a></td></tr>
        @empty
            <tr><td colspan="7" class="sec-empty">Belum ada temuan. <a href="{{ route('security.findings.create') }}">Catat temuan pertama</a>.</td></tr>
        @endforelse
        </tbody></table></div>
    </section>
    <div class="sec-grid-2">
        <section class="sec-card"><div class="sec-card-head"><span><i class="bi bi-pie-chart-fill"></i> Status Temuan</span></div><div class="sec-card-body sec-donut-layout"><div class="sec-donut" style="background:{{ $donutStyle }}"><strong>{{ $total }}</strong><small>Total Temuan</small></div><div class="sec-legend">@foreach($allStatuses as $label => $color)<div><i style="background:{{ $color }}"></i><span>{{ $label }}</span><b>{{ $statusCounts[$label] }}</b></div>@endforeach</div></div></section>
        <section class="sec-card"><div class="sec-card-head"><span><i class="bi bi-bar-chart-fill"></i> Jenis Temuan</span></div><div class="sec-card-body"><div class="sec-bars">
            @forelse($typeCounts->take(7) as $type => $count)
                <div class="sec-bar-row"><span>{{ $type }}</span><div class="sec-bar-track"><div class="sec-bar-fill" style="width:{{ ($count / $maxType) * 100 }}%"></div></div><b>{{ $count }}</b></div>
            @empty
                <div class="sec-empty">Grafik akan terisi setelah temuan dicatat.</div>
            @endforelse
        </div></div></section>
    </div>
</div>
@endsection
