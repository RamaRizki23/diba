@extends('layouts.app')
@section('content')
<div class="topbar"><div><div class="eyebrow">Master data / pembaruan</div><h1 class="page-title">Edit Master Data</h1></div></div>
<div class="panel form-panel"><div class="panel-head"><div><h2>{{ $masterData->name }}</h2><div class="muted" style="font-size:13px;margin-top:5px">Perbarui referensi master data.</div></div></div><form method="POST" action="{{ route('master-data.update', [$type, $masterData]) }}">@csrf @method('PUT') @include('master-data._form', ['submitLabel' => 'Simpan perubahan'])</form></div>
@endsection
