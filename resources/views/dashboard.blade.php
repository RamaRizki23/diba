@extends('layouts.app')

@section('content')
@php
    $maxValue = fn ($items) => max(1, (int) $items->max());
    $chartColors = ['#f46b57', '#08a864', '#f6a313', '#12afd0', '#438fc0', '#7f8791', '#e3425b', '#7b45d9'];
    $chartGradient = function ($items) use ($chartColors) {
        $total = max(1, (int) $items->sum());
        $position = 0;
        $colorIndex = 0;
        $parts = [];
        foreach ($items->take(count($chartColors)) as $count) {
            $next = $position + (($count / $total) * 100);
            $parts[] = $chartColors[$colorIndex % count($chartColors)].' '.$position.'% '.$next.'%';
            $position = $next;
            $colorIndex++;
        }
        return implode(', ', $parts) ?: '#edf1f2 0% 100%';
    };
    $chartItems = [
        ['title' => 'Sektor', 'icon' => 'bi-bar-chart-fill', 'items' => $charts['sector']],
        ['title' => 'Layanan', 'icon' => 'bi-cone-striped', 'items' => $charts['service']],
        ['title' => 'Status', 'icon' => 'bi-info-circle-fill', 'items' => $charts['status']],
        ['title' => 'Bahasa Pemrograman', 'icon' => 'bi-code-slash', 'items' => $charts['language']],
        ['title' => 'Framework', 'icon' => 'bi-layers-fill', 'items' => $charts['framework']],
        ['title' => 'Database', 'icon' => 'bi-database-fill', 'items' => $charts['database']],
    ];
    $chartItems = array_map(function ($chart) use ($chartGradient) {
        $chart['gradient'] = $chartGradient($chart['items']);
        return $chart;
    }, $chartItems);
@endphp
<style>
.dashboard-head{display:flex;justify-content:space-between;align-items:flex-end;gap:20px;margin-bottom:20px}.scope-tabs{display:flex;border:1px solid #dfe4e7;border-radius:4px;overflow:hidden;background:#fff}.scope-tabs a{padding:10px 14px;color:#66757e;font-size:13px}.scope-tabs a.active{background:#119db4;color:#fff}.dashboard-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:18px}.dashboard-stat{min-height:104px;padding:17px 20px;color:#fff;position:relative;overflow:hidden}.dashboard-stat strong{display:block;font:700 30px 'Space Grotesk'}.dashboard-stat span{font-size:13px}.dashboard-stat i{position:absolute;right:20px;top:24px;font-size:45px;opacity:.2}.dashboard-stat.teal{background:#18a4b8}.dashboard-stat.green{background:#20a849}.dashboard-stat.yellow{background:#ffbf12;color:#263238}.dashboard-stat.red{background:#df394a}.dashboard-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px}.chart-panel{background:#fff;border:1px solid #dfe4e7;min-height:310px}.chart-panel h2{padding:14px 16px;border-bottom:1px solid #e7ebed;font:500 16px 'DM Sans'}.chart-panel h2 i{margin-right:6px}.chart-body{padding:16px}.chart-visual{display:flex;align-items:center;gap:15px;min-height:125px;margin-bottom:8px}.donut{width:116px;height:116px;flex:0 0 116px;border-radius:50%;position:relative;background:#edf1f2}.donut:after{content:'';position:absolute;inset:28px;border-radius:50%;background:#fff}.donut-total{position:absolute;z-index:1;inset:0;display:grid;place-items:center;font:700 20px 'Space Grotesk';color:#263238}.chart-legend{display:grid;gap:5px;min-width:0}.legend-row{display:flex;align-items:center;gap:6px;max-width:145px;font-size:10px;color:#66757e}.legend-row i{width:10px;height:10px;flex:0 0 10px}.legend-row span{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.bar-chart{display:grid;gap:10px}.bar-row{display:grid;grid-template-columns:minmax(80px,1fr) 1.3fr 22px;align-items:center;gap:8px;font-size:11px}.bar-row>span{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.bar-row>div{height:14px;background:#edf1f2}.bar-row b{display:block;height:100%;background:#f46b57}.bar-row:nth-child(2n) b{background:#08a864}.bar-row em{font-style:normal;text-align:right;color:#60727a}.empty-chart{padding:35px 0;text-align:center;color:#71808a;font-size:13px}@media(max-width:900px){.dashboard-stats{grid-template-columns:repeat(2,1fr)}.dashboard-grid{grid-template-columns:repeat(2,1fr)}}@media(max-width:650px){.dashboard-head{align-items:flex-start;flex-direction:column}.scope-tabs{width:100%}.scope-tabs a{flex:1;text-align:center}.dashboard-grid{grid-template-columns:1fr}.chart-visual{justify-content:center}}
.dashboard-head{display:flex;justify-content:space-between;align-items:flex-end;gap:20px;margin-bottom:20px}.scope-tabs{display:flex;border:1px solid #dfe4e7;border-radius:4px;overflow:hidden;background:#fff}.scope-tabs a{padding:10px 14px;color:#66757e;font-size:13px}.scope-tabs a.active{background:#119db4;color:#fff}.dashboard-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:18px}.dashboard-stat{min-height:104px;padding:17px 20px;color:#fff;position:relative;overflow:hidden}.dashboard-stat strong{display:block;font:700 30px 'Space Grotesk'}.dashboard-stat span{font-size:13px}.dashboard-stat i{position:absolute;right:20px;top:24px;font-size:45px;opacity:.2}.dashboard-stat.teal{background:#18a4b8}.dashboard-stat.green{background:#20a849}.dashboard-stat.yellow{background:#ffbf12;color:#263238}.dashboard-stat.red{background:#df394a}.dashboard-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px}.chart-panel{background:#fff;border:1px solid #dfe4e7;min-height:310px}.chart-panel h2{padding:14px 16px;border-bottom:1px solid #e7ebed;font:500 16px 'DM Sans'}.chart-panel h2 i{margin-right:6px}.chart-body{padding:16px}.chart-visual{display:flex;align-items:center;gap:15px;min-height:125px;margin-bottom:8px}.donut{width:116px;height:116px;flex:0 0 116px;border-radius:50%;position:relative;background:#edf1f2}.donut:after{content:'';position:absolute;inset:28px;border-radius:50%;background:#fff}.donut-total{position:absolute;z-index:1;inset:0;display:grid;place-items:center;font:700 20px 'Space Grotesk';color:#263238}.chart-legend{display:grid;gap:5px;min-width:0}.legend-row{display:flex;align-items:center;gap:6px;max-width:145px;font-size:10px;color:#66757e}.legend-row i{width:10px;height:10px;flex:0 0 10px}.legend-row span{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.bar-chart{display:grid;gap:10px}.bar-row{display:grid;grid-template-columns:minmax(80px,1fr) 1.3fr 22px;align-items:center;gap:8px;font-size:11px}.bar-row>span{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.bar-row>div{height:14px;background:#edf1f2}.bar-row b{display:block;height:100%;background:#f46b57}.bar-row:nth-child(2n) b{background:#08a864}.bar-row em{font-style:normal;text-align:right;color:#60727a}.empty-chart{padding:35px 0;text-align:center;color:#71808a;font-size:13px}.dashboard-applications{margin-top:18px;background:#fff;border:1px solid #dfe4e7;overflow:hidden}.dashboard-applications h2{padding:15px 18px;margin:0;border-bottom:1px solid #e7ebed;font:500 18px 'DM Sans'}.dashboard-filter{padding:10px 0;border-bottom:1px solid #e7ebed}.dashboard-filter select{width:425px;max-width:100%;border-radius:0}.dashboard-table-wrap{overflow:auto}.dashboard-table{min-width:880px}.dashboard-table th{background:#f9fafb;color:#263238}.dashboard-table td{font-size:12px;padding:10px 12px;vertical-align:top}.dashboard-table a{color:#087cf0}.dashboard-table-footer{display:flex;justify-content:space-between;gap:12px;padding:14px 18px;color:#71808a;font-size:12px}.dashboard-table-footer a{color:#087cf0}@media(max-width:900px){.dashboard-stats{grid-template-columns:repeat(2,1fr)}.dashboard-grid{grid-template-columns:repeat(2,1fr)}}@media(max-width:650px){.dashboard-head{align-items:flex-start;flex-direction:column}.scope-tabs{width:100%}.scope-tabs a{flex:1;text-align:center}.dashboard-grid{grid-template-columns:1fr}.chart-visual{justify-content:center}.dashboard-table-footer{align-items:flex-start;flex-direction:column}}
</style>
<style>
    .dashboard-head{display:flex;justify-content:space-between;align-items:flex-end;gap:20px;margin-top:82px;margin-bottom:20px}.scope-tabs{display:flex;border:1px solid #dfe4e7;border-radius:4px;overflow:hidden;background:#fff}.scope-tabs a{padding:10px 14px;color:#66757e;font-size:13px}.scope-tabs a.active{background:#119db4;color:#fff}.dashboard-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:18px}.dashboard-stat{min-height:104px;padding:17px 20px;color:#fff;position:relative;overflow:hidden}.dashboard-stat strong{display:block;font:700 30px 'Space Grotesk'}.dashboard-stat span{font-size:13px}.dashboard-stat i{position:absolute;right:20px;top:24px;font-size:45px;opacity:.2}.dashboard-stat.teal{background:#18a4b8}.dashboard-stat.green{background:#20a849}.dashboard-stat.yellow{background:#ffbf12;color:#263238}.dashboard-stat.red{background:#df394a}.dashboard-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px}.chart-panel{background:#fff;border:1px solid #dfe4e7;min-height:310px}.chart-panel h2{padding:14px 16px;border-bottom:1px solid #e7ebed;font:500 16px 'DM Sans'}.chart-panel h2 i{margin-right:6px}.chart-body{padding:16px}.chart-visual{display:flex;align-items:center;gap:15px;min-height:125px;margin-bottom:8px}.donut{width:116px;height:116px;flex:0 0 116px;border-radius:50%;position:relative;background:#edf1f2}.donut:after{content:'';position:absolute;inset:28px;border-radius:50%;background:#fff}.donut-total{position:absolute;z-index:1;inset:0;display:grid;place-items:center;font:700 20px 'Space Grotesk';color:#263238}.chart-legend{display:grid;gap:5px;min-width:0}.legend-row{display:flex;align-items:center;gap:6px;max-width:145px;font-size:10px;color:#66757e}.legend-row i{width:10px;height:10px;flex:0 0 10px}.legend-row span{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.bar-chart{display:grid;gap:10px}.bar-row{display:grid;grid-template-columns:minmax(80px,1fr) 1.3fr 22px;align-items:center;gap:8px;font-size:11px}.bar-row>span
.dashboard-grid{grid-template-columns:repeat(3,minmax(0,1fr))}
.dashboard-grid>*{min-width:0}
.chart-panel,.chart-body,.chart-visual{min-width:0}
.bar-row{grid-template-columns:minmax(0,1fr) minmax(0,1.3fr) 22px}
.dashboard-stat span{font-size:20px}
.scope-tabs a{font-size:17px}
.chart-panel h2{font-size:22px}
.legend-row,.bar-row{font-size:17px}
.legend-row{max-width:180px}
.dashboard-table{font-size:19px}
.dashboard-table th{font-size:17px}
.dashboard-table td{font-size:19px}
.dashboard-table-tools{font-size:17px}
.dashboard-table-tools input{font-size:18px}
@media(max-width:800px){.dashboard-stats{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media(max-width:700px){.dashboard-grid{grid-template-columns:1fr}.dashboard-stats{grid-template-columns:1fr 1fr}}
</style>
<div class="dashboard-head"><div><h1 class="page-title">Dashboard {{ $scope === 'provinsi' ? 'Provinsi' : 'Kabupaten/Kota' }}</h1></div><div class="scope-tabs"><a class="{{ $scope === 'provinsi' ? 'active' : '' }}" href="{{ route('dashboard', ['scope' => 'provinsi']) }}">Provinsi</a><a class="{{ $scope === 'kabupaten-kota' ? 'active' : '' }}" href="{{ route('dashboard', ['scope' => 'kabupaten-kota']) }}">Kabupaten/Kota</a></div></div>
<div class="dashboard-stats"><div class="dashboard-stat teal"><strong>{{ $stats['total'] }}</strong><span>Total Aplikasi</span><i class="bi bi-laptop"></i></div><div class="dashboard-stat green"><strong>{{ $stats['pse'] }}</strong><span>Total PSE</span><i class="bi bi-check-circle-fill"></i></div><div class="dashboard-stat yellow"><strong>{{ $stats['repository'] }}</strong><span>Total Repository</span><i class="bi bi-diagram-3-fill"></i></div><div class="dashboard-stat red"><strong>{{ $stats['profile'] }}</strong><span>Total Profil</span><i class="bi bi-person-fill"></i></div></div>
<div class="dashboard-grid">
@foreach($chartItems as $chart)
<section class="chart-panel"><h2><i class="bi {{ $chart['icon'] }}"></i> {{ $chart['title'] }}</h2><div class="chart-body"><div class="chart-visual"><div class="donut" data-gradient="{{ $chart['gradient'] }}"><span class="donut-total">{{ $chart['items']->sum() }}</span></div><div class="chart-legend">@foreach($chart['items']->take(5) as $label => $count)<div class="legend-row"><i data-color="{{ $chartColors[$loop->index % count($chartColors)] }}"></i><span title="{{ $label }}">{{ $label }}</span></div>@endforeach</div></div><div class="bar-chart">
@forelse($chart['items']->take(8) as $label => $count)
    <div class="bar-row"><span title="{{ $label }}">{{ $label }}</span><div><b data-width="{{ ($count / $maxValue($chart['items'])) * 100 }}"></b></div><em>{{ $count }}</em></div>
@empty
<div class="empty-chart">Belum ada data</div>
@endforelse
</div></div></section>
<script>document.querySelectorAll('.bar-row b[data-width]').forEach(function (bar) { bar.style.width = bar.dataset.width + '%'; }); document.querySelectorAll('.donut[data-gradient]').forEach(function (donut) { donut.style.background = 'conic-gradient(' + donut.dataset.gradient + ')'; }); document.querySelectorAll('.legend-row i[data-color]').forEach(function (color) { color.style.background = color.dataset.color; });</script>
@endforeach
</div>
<style>
.dashboard-applications{margin-top:18px;background:#fff;border:1px solid #dfe4e7;min-width:0}
.dashboard-applications h2{padding:16px 20px;border-bottom:1px solid #e7ebed;font:500 19px 'DM Sans'}
.dashboard-filters{display:grid;grid-template-columns:repeat(3,minmax(0,1fr)) auto;gap:14px;padding:20px;border-bottom:1px solid #edf0f1}
.dashboard-filter label{display:block;margin-bottom:7px;font-size:12px;font-weight:700}
.dashboard-filter select{border-radius:4px;background:#fff}
.dashboard-filter-reset{align-self:end}
.dashboard-filter-reset .button{background:#6c7780;white-space:nowrap}
.dashboard-table-tools{display:flex;justify-content:space-between;align-items:center;gap:15px;padding:18px 20px 12px;color:#44545e;font-size:13px}
.dashboard-table-tools input{width:175px;padding:8px 10px;border-radius:4px}
.dashboard-table-wrap{overflow-x:auto;padding:0 20px 20px}
.dashboard-table{width:100%;min-width:980px;border-collapse:collapse;font-size:13px}
.dashboard-table th{padding:11px 9px;background:#f7f9fa;color:#263238;text-align:left;font-size:12px;border:1px solid #dfe4e7}
.dashboard-table td{padding:11px 9px;border:1px solid #dfe4e7;vertical-align:top}
.dashboard-table tbody tr:nth-child(odd){background:#f7f7f7}
.dashboard-table a{color:#087cf0;word-break:break-word}
.dashboard-table .app-name{font-weight:500;min-width:130px}
@media(max-width:700px){.dashboard-filters{grid-template-columns:1fr}.dashboard-table-tools{align-items:flex-start;flex-direction:column}.dashboard-table-tools input{width:100%}}
</style>
<section class="dashboard-applications">
    <h2>Daftar Aplikasi Perangkat Daerah</h2>
    @auth
    <form class="dashboard-filters" method="GET">
        <input type="hidden" name="scope" value="{{ $scope }}">
        <div class="dashboard-filter"><label for="dashboard-owner">Filter Pemilik:</label><select id="dashboard-owner" name="owner"><option value="">Semua Pemilik</option>@foreach($owners as $owner)<option value="{{ $owner }}" @selected($filters['owner'] === $owner)>{{ $owner }}</option>@endforeach</select></div>
        <div class="dashboard-filter"><label for="dashboard-service">Filter Layanan:</label><select id="dashboard-service" name="service"><option value="">Semua Layanan</option>@foreach($services as $service)<option value="{{ $service }}" @selected($filters['service'] === $service)>{{ $service }}</option>@endforeach</select></div>
        <div class="dashboard-filter"><label for="dashboard-sector">Filter Sektor:</label><select id="dashboard-sector" name="sector"><option value="">Semua Sektor</option>@foreach($sectors as $sector)<option value="{{ $sector }}" @selected($filters['sector'] === $sector)>{{ $sector }}</option>@endforeach</select></div>
        <div class="dashboard-filter-reset"><a class="button" href="{{ route('dashboard', ['scope' => $scope]) }}"><i class="bi bi-x-lg"></i> Reset Filter</a></div>
    </form>
    @endauth
    <div class="dashboard-table-tools"><strong>Menampilkan {{ $filteredApplications->count() }} data</strong><label for="dashboard-search">Cari: <input id="dashboard-search" type="search" placeholder="Cari tabel..."></label></div>
    <div class="dashboard-table-wrap"><table class="dashboard-table" id="dashboard-applications-table"><thead><tr><th>No</th><th>Nama Aplikasi</th><th>URL</th><th>Pemilik Aplikasi</th><th>No Registrasi PSE</th><th>Layanan</th><th>Sektor</th><th>Bahasa</th><th>Framework</th><th>Database</th></tr></thead><tbody>
    @forelse($filteredApplications as $application)
        <tr><td>{{ $loop->iteration }}</td><td class="app-name">{{ $application->name }}</td><td>@if($application->url)<a href="{{ $application->url }}" target="_blank" rel="noopener">{{ $application->url }}</a>@else - @endif</td><td>{{ $application->owner ?: '-' }}</td><td>{{ $application->pse_badge ?: '-' }}</td><td>{{ $application->service ?: '-' }}</td><td>{{ $application->sector ?: '-' }}</td><td>{{ $application->language ?: '-' }}</td><td>{{ $application->framework ?: '-' }}</td><td>{{ $application->database ?: '-' }}</td></tr>
    @empty
        <tr><td colspan="10">Data belum tersedia.</td></tr>
    @endforelse
    </tbody></table></div>
</section>
<script>
document.getElementById('dashboard-search')?.addEventListener('input', function () {
    const query = this.value.toLowerCase();
    document.querySelectorAll('#dashboard-applications-table tbody tr').forEach(function (row) {
        row.style.display = row.innerText.toLowerCase().includes(query) ? '' : 'none';
    });
});
</script>
@endsection
