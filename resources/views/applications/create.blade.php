@extends('layouts.app')
@section('content')
<div class="topbar"><div><div class="eyebrow">Katalog aplikasi / entri baru</div><h1 class="page-title">Tambah aplikasi</h1></div></div>
<div class="panel form-panel"><div class="panel-head"><div><h2>Informasi aplikasi</h2><div class="muted" style="font-size:13px;margin-top:5px">Isi detail agar katalog mudah dicari dan dipantau.</div></div></div><form method="POST" action="{{ route('applications.store') }}">@csrf @include('applications._form', ['submitLabel' => 'Simpan aplikasi'])</form></div>
@endsection
