<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - DIBA</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7f6;
        }

        .navbar {
            background: #198754;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            margin: 0;
        }

        .logout {
            background: white;
            color: #198754;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
        }

        .content {
            padding: 40px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
    </style>
</head>

<body>

<div class="navbar">
    <h2>DIBA</h2>

    <form action="{{ route('logout') }}" method="POST">
        @csrf

        <button type="submit" class="logout">
            Logout
        </button>
    </form>
</div>

<div class="content">

@extends('layouts.app')

@section('content')
<div class="topbar">
    <div><div class="eyebrow">Senin, {{ now()->translatedFormat('d F Y') }}</div><h1 class="page-title">Selamat datang, {{ auth()->user()->name }}</h1></div>
    <div class="top-actions"><a class="button" href="{{ route('applications.create') }}">+ Tambah aplikasi</a></div>
</div>
@if (session('success')) <div class="alert">{{ session('success') }}</div> @endif
<div class="stat-grid">
    <div class="stat"><div class="stat-label">Total aplikasi</div><div class="stat-value">{{ $stats['total'] }}</div></div>
    <div class="stat"><div class="stat-label">Aplikasi aktif</div><div class="stat-value">{{ $stats['active'] }}</div></div>
    <div class="stat"><div class="stat-label">Dalam pengembangan</div><div class="stat-value">{{ $stats['development'] }}</div></div>
    <div class="stat"><div class="stat-label">Pemilik terdata</div><div class="stat-value">{{ $stats['owners'] }}</div></div>
</div>
<div class="panel">
    <div class="panel-head"><div><div class="eyebrow">Data terbaru</div><h2>Aktivitas katalog</h2></div><a class="button secondary" href="{{ route('applications.index') }}">Lihat semua</a></div>
    <div class="table-wrap"><table><thead><tr><th>Aplikasi</th><th>Pemilik</th><th>Teknologi</th><th>Status</th><th>Diubah</th></tr></thead><tbody>
    @forelse($latestApplications as $application)
    <tr><td><div class="code">{{ $application->code }}</div><div class="app-name">{{ $application->name }}</div></td><td class="muted">{{ $application->owner ?: '-' }}</td><td class="muted">{{ $application->language ?: '-' }} / {{ $application->framework ?: '-' }}</td><td><span class="status {{ strtolower(str_replace(' ', '-', $application->status)) }}">{{ $application->status }}</span></td><td class="muted">{{ $application->updated_at->diffForHumans() }}</td></tr>
    @empty <tr><td colspan="5" class="muted">Belum ada aplikasi. Tambahkan data pertama.</td></tr> @endforelse
    </tbody></table></div>
</div>
@endsection

</div>

</body>
</html>