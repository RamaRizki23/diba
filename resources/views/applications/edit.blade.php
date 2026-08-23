@extends('layouts.app')
@section('content')
<div class="topbar"><div><div class="eyebrow">Katalog aplikasi / pembaruan</div><h1 class="page-title">Edit aplikasi</h1></div></div>
<div class="panel form-panel"><div class="panel-head"><div><h2>{{ $application->name }}</h2><div class="muted" style="font-size:13px;margin-top:5px">Perbarui informasi aplikasi.</div></div></div><form method="POST" action="{{ route('applications.update', $application) }}">@csrf @method('PUT') @include('applications._form', ['submitLabel' => 'Simpan perubahan'])</form></div>
@endsection
