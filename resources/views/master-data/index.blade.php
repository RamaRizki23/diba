@extends('layouts.app')
@section('content')
<div class="topbar"><div><div class="eyebrow">Konfigurasi katalog</div><h1 class="page-title">Master Data</h1></div></div>
<div class="stat-grid">@foreach($types as $key => $label)<a class="stat" href="{{ route('master-data.category', $key) }}"><div class="stat-label">Kelola master</div><div class="stat-value" style="font-size:20px">{{ $label }}</div><div class="muted" style="margin-top:10px;font-size:13px">Buka data <i class="bi bi-arrow-right"></i></div></a>@endforeach</div>
<footer class="site-footer">&copy; {{ date('Y') }} DIBA Katalog Aplikasi Jawa Barat</footer>
@endsection
