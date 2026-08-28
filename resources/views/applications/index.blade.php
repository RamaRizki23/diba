@extends('layouts.app')
@section('content')
<div class="topbar"><div><div class="eyebrow">Workspace / katalog</div><h1 class="page-title">Daftar aplikasi</h1></div><a class="button" href="{{ route('applications.create') }}">+ Tambah aplikasi</a></div>
@if(session('success')) <div class="alert">{{ session('success') }}</div> @endif
<div class="panel"><div class="panel-head"><div><h2>Daftar Aplikasi</h2></div></div><form class="filter-bar" method="GET"><select name="owner" aria-label="Filter owner"><option value="">Semua Owner</option>@foreach($owners as $owner)<option value="{{ $owner }}" {{ request('owner') === $owner ? 'selected' : '' }}>{{ $owner }}</option>@endforeach</select><button class="button" type="submit"><i class="bi bi-search"></i> Filter</button></form>
<div class="table-tools"><div class="table-tools-left">Tampilkan <select aria-label="Jumlah entri"><option>10</option><option>25</option><option>50</option></select> entri <button class="tool-button copy" type="button" id="copyTable"><i class="bi bi-copy"></i> Salin</button><a class="tool-button pdf" href="{{ route('applications.pdf.index', request()->only('owner')) }}"><i class="bi bi-file-earmark-pdf"></i> PDF</a><button class="tool-button print" type="button" onclick="window.print()"><i class="bi bi-printer"></i> Cetak</button><button class="tool-button columns" type="button" id="toggleColumns"><i class="bi bi-eye"></i> Kolom</button><div id="columnMenu" class="column-menu" hidden>@foreach(['No','Nama Aplikasi','Kode','URL','Deskripsi','Pemilik Aplikasi','Aksi'] as $column)<label><input type="checkbox" checked data-column="{{ $loop->index }}"> <span>{{ $column }}</span></label>@endforeach</div></div><label class="table-tools-right">Cari: <input id="tableSearch" type="search" placeholder="Cari tabel..."></label></div>
<div class="table-wrap"><table id="applicationsTable"><thead><tr><th>No</th><th>Nama Aplikasi</th><th>Kode</th><th>URL</th><th>Deskripsi</th><th>Pemilik Aplikasi</th><th>Aksi</th></tr></thead><tbody>
@forelse($applications as $application)<tr><td>{{ $applications->firstItem() + $loop->index }}</td><td><div class="app-name">{{ $application->name }}</div></td><td>{{ $application->code }}</td><td>@if($application->url)<a style="color:#087cf0" href="{{ $application->url }}" target="_blank">{{ parse_url($application->url, PHP_URL_HOST) ?: $application->url }}</a>@else - @endif</td><td class="muted">{{ \Illuminate\Support\Str::limit($application->description ?: '-', 90) }}</td><td>{{ $application->owner ?: '-' }}</td><td><div class="actions"><a class="icon-button" href="{{ route('applications.show', $application) }}"><i class="bi bi-info-circle-fill"></i> Detail</a><a class="icon-button" href="{{ route('applications.pdf', $application) }}"><i class="bi bi-file-earmark-pdf-fill"></i> PDF</a><a class="icon-button" href="{{ route('applications.edit', $application) }}"><i class="bi bi-pencil-fill"></i> Edit</a><form method="POST" action="{{ route('applications.destroy', $application) }}" onsubmit="return confirm('Hapus aplikasi ini?')">@csrf @method('DELETE')<button class="icon-button delete" type="submit"><i class="bi bi-trash-fill"></i> Hapus</button></form></div></td></tr>@empty<tr><td colspan="7" class="muted">Data belum tersedia.</td></tr>@endforelse
</tbody></table></div><div class="pagination-bar"><div>Menampilkan {{ $applications->firstItem() ?: 0 }} sampai {{ $applications->lastItem() ?: 0 }} dari {{ $applications->total() }} entri</div><div class="pagination"><a class="{{ $applications->onFirstPage() ? 'disabled' : '' }}" href="{{ $applications->previousPageUrl() ?: '#' }}">Sebelumnya</a>@foreach($applications->getUrlRange(max(1, $applications->currentPage() - 2), min($applications->lastPage(), $applications->currentPage() + 2)) as $page => $url)<a class="{{ $page == $applications->currentPage() ? 'current' : '' }}" href="{{ $url }}">{{ $page }}</a>@endforeach<a class="{{ $applications->currentPage() == $applications->lastPage() ? 'disabled' : '' }}" href="{{ $applications->nextPageUrl() ?: '#' }}">Selanjutnya</a></div></div></div>
<footer class="site-footer">&copy; {{ date('Y') }} DIBA Katalog Aplikasi Jawa Barat</footer>
<style>.column-menu{position:absolute;z-index:3;top:38px;right:0;min-width:248px;padding:8px 0;background:#087cf0;border-radius:0 0 4px 4px;box-shadow:0 5px 18px #0003}.column-menu label{display:flex;align-items:center;padding:7px 20px;color:#fff;font-size:13px;white-space:nowrap;cursor:pointer}.column-menu label:hover{background:#066bd0}.column-menu input{display:none}.table-tools-left{position:relative}</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
	const table = document.getElementById('applicationsTable');
	const search = document.getElementById('tableSearch');
	const menu = document.getElementById('columnMenu');
	document.getElementById('toggleColumns').addEventListener('click', () => menu.hidden = !menu.hidden);
	menu.querySelectorAll('input').forEach(input => input.addEventListener('change', function () {
		table.querySelectorAll('tr').forEach(row => { const cell = row.children[Number(this.dataset.column)]; if (cell) cell.hidden = !this.checked; });
	}));
	search.addEventListener('input', function () {
		const query = this.value.toLowerCase();
		table.querySelectorAll('tbody tr').forEach(row => row.style.display = row.innerText.toLowerCase().includes(query) ? '' : 'none');
	});
	document.getElementById('copyTable').addEventListener('click', async function () {
		const rows = [...table.querySelectorAll('tr')].map(row => [...row.children].filter(cell => !cell.hidden).slice(0, -1).map(cell => cell.innerText.trim()).join('\t')).join('\n');
		await navigator.clipboard.writeText(rows);
		const original = this.innerHTML; this.innerHTML = '<i class="bi bi-check2"></i> Tersalin'; setTimeout(() => this.innerHTML = original, 1400);
	});
});
</script>
@endsection
