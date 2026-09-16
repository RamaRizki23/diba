@extends('layouts.app')
@section('content')
<style>
.password-page{max-width:760px}
.password-page .panel{padding:24px}
.password-page .panel-head{margin-bottom:22px}
.password-page .panel-head h2{font-size:26px}
.password-page .password-help{margin:0;color:#71808a;font-size:17px}
.password-page .form-actions{justify-content:flex-start}
</style>
<div class="password-page">
    <div class="topbar"><div><h1 class="page-title">Ganti Password</h1></div></div>
    @if(session('success')) <div class="alert">{{ session('success') }}</div> @endif
    @if($errors->any()) <div class="alert errors"><ul style="margin:0;padding-left:20px">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div> @endif
    <section class="panel">
        <div class="panel-head"><div><h2>Form Ganti Password</h2><p class="password-help">Password harus memenuhi kriteria berikut:</p><ul class="password-help"><li>Minimal 8 karakter</li><li>Mengandung huruf besar dan kecil</li><li>Mengandung angka</li><li>Mengandung karakter khusus (!@#$%^&amp;*)</li></ul></div></div>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf @method('PUT')
            <div class="form-grid">
                <div class="full"><label for="current_password">Password Lama</label><input id="current_password" type="password" name="current_password" required autocomplete="current-password"></div>
                <div><label for="password">Password Baru</label><input id="password" type="password" name="password" required autocomplete="new-password"></div>
                <div><label for="password_confirmation">Konfirmasi Password Baru</label><input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"></div>
            </div>
            <div class="form-actions"><button class="button" type="submit"><i class="bi bi-check-lg"></i> Ganti Password</button></div>
        </form>
    </section>
</div>
@endsection
