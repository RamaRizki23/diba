@extends('layouts.app')
@section('content')
<style>.master-data-page{font-size:21px}.master-data-page .page-title{font-size:40px}.master-data-page .eyebrow{font-size:17px}.master-data-page .panel h2{font-size:25px}.master-data-page .muted{font-size:17px !important}.master-data-page label{font-size:17px}.master-data-page input{font-size:19px}.master-data-page .button{font-size:18px}</style>
<div class="master-data-page"><div class="topbar"><div><div class="eyebrow">Master data / entri baru</div><h1 class="page-title">Tambah Master Data</h1></div></div>
<div class="panel form-panel"><div class="panel-head"><div><h2>Informasi {{ $label }}</h2><div class="muted" style="font-size:13px;margin-top:5px">Tambahkan pilihan baru untuk digunakan pada katalog aplikasi.</div></div></div><form method="POST" action="{{ route('master-data.store', $type) }}">@csrf @include('master-data._form', ['submitLabel' => 'Simpan data'])</form></div>
</div>
@endsection
