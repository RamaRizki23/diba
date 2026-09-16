@extends('layouts.app')
@section('content')
<style>
.master-data-page{font-size:21px}
.master-data-page .page-title{font-size:40px}
.master-data-page .stat-label{font-size:17px}
.master-data-page .stat-value{font-size:28px !important}
.master-data-page .muted{font-size:17px !important}
</style>
<div class="master-data-page"><div class="topbar"><div><h1 class="page-title">Master Data</h1></div></div>
<div class="stat-grid">@foreach($types as $key => $label)<a class="stat" href="{{ route('master-data.category', $key) }}"><div class="stat-label">Kelola master</div><div class="stat-value">{{ $label }}</div><div class="muted" style="margin-top:10px">Buka data <i class="bi bi-arrow-right"></i></div></a>@endforeach</div></div>
<footer class="site-footer">&copy; {{ date('Y') }} DIBA Katalog Aplikasi Jawa Barat</footer>
@endsection
