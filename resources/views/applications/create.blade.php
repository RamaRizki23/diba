@extends('layouts.app')
@section('content')
<style>
.detail-backdrop{position:fixed;z-index:10;inset:0;background:#0008;overflow:auto;padding:24px 18px}.detail-modal{width:min(1180px,100%);margin:auto;background:#fff;border-radius:4px;box-shadow:0 8px 30px #0005}.detail-head{display:flex;align-items:center;justify-content:space-between;padding:18px 16px;border-bottom:1px solid #dfe4e7}.detail-head h1{font:600 22px 'DM Sans';margin:0}.close-detail{font-size:23px;color:#777;text-decoration:none;line-height:1}.create-form{padding:16px}.create-form .form-panel{max-width:none;padding:0}.create-form .form-actions{padding-bottom:2px;margin-bottom:0}@media(max-width:700px){.detail-modal{margin:0}.detail-backdrop{padding:10px 5px}}
</style>
<div class="detail-backdrop"><section class="detail-modal"><header class="detail-head"><h1>Tambah Aplikasi</h1><a class="close-detail" href="{{ route('applications.index') }}" aria-label="Tutup">&times;</a></header><div class="create-form"><form method="POST" action="{{ route('applications.store') }}">@csrf @include('applications._form', ['submitLabel' => 'Simpan aplikasi'])</form></div></section></div>
@endsection
