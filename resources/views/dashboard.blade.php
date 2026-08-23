@extends('layouts.app')

@section('content')
<div class="topbar">
    <div><div class="eyebrow">Workspace overview</div><h1 class="page-title">Selamat datang, {{ auth()->user()->name }}</h1></div>
    <div class="top-actions"><form method="POST" action="{{ route('logout') }}">@csrf<button class="button secondary" type="submit">Keluar</button></form><a class="button" href="{{ route('applications.create') }}">+ Tambah aplikasi</a></div>
</div>
@if(session('success')) <div class="alert">{{ session('success') }}</div> @endif
<div class="stat-grid"><div class="stat"><div class="stat-label">Total aplikasi</div><div class="stat-value">{{ $stats['total'] }}</div></div><div class="stat"><div class="stat-label">Aplikasi aktif</div><div class="stat-value">{{ $stats['active'] }}</div></div><div class="stat"><div class="stat-label">Dalam pengembangan</div><div class="stat-value">{{ $stats['development'] }}</div></div><div class="stat"><div class="stat-label">Pemilik terdata</div><div class="stat-value">{{ $stats['owners'] }}</div></div></div>
<div class="panel"><div class="panel-head"><div><div class="eyebrow">Data terbaru</div><h2>Aktivitas katalog</h2></div><a class="button secondary" href="{{ route('applications.index') }}">Lihat semua</a></div><div class="table-wrap"><table><thead><tr><th>Aplikasi</th><th>Pemilik</th><th>Teknologi</th><th>Status</th><th>Diubah</th></tr></thead><tbody>@forelse($latestApplications as $application)<tr><td><div class="code">{{ $application->code }}</div><div class="app-name">{{ $application->name }}</div></td><td class="muted">{{ $application->owner ?: '-' }}</td><td class="muted">{{ $application->language ?: '-' }} / {{ $application->framework ?: '-' }}</td><td><span class="status {{ strtolower(str_replace(' ', '-', $application->status)) }}">{{ $application->status }}</span></td><td class="muted">{{ $application->updated_at->diffForHumans() }}</td></tr>@empty<tr><td colspan="5" class="muted">Belum ada aplikasi. Tambahkan data pertama.</td></tr>@endforelse</tbody></table></div></div>
@endsection
