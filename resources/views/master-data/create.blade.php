@extends('layouts.app')
@section('content')
<div class="topbar"><div><div class="eyebrow">Master data / entri baru</div><h1 class="page-title">Tambah Master Data</h1></div></div>
<div class="panel form-panel"><div class="panel-head"><div><h2>Informasi {{ $label }}</h2><div class="muted" style="font-size:13px;margin-top:5px">Tambahkan pilihan baru untuk digunakan pada katalog aplikasi.</div></div></div><form method="POST" action="{{ route('master-data.store', $type) }}">@csrf @include('master-data._form', ['submitLabel' => 'Simpan data'])</form></div>
@endsection
