@extends('layouts.app')
@section('content')
@include('security._styles')
<div class="security-page">
    <header class="sec-head"><div><div class="sec-crumb"><a href="{{ route('security.dashboard') }}">Beranda</a>　›　<a href="{{ route('security.findings.index') }}">Temuan Keamanan</a>　›　Tambah Temuan</div><h1 class="page-title">Tambah Temuan Keamanan</h1><p class="sec-subtitle">Catat informasi temuan, rekomendasi perbaikan, bukti, dan PIC tindak lanjut.</p></div></header>
    @if($errors->any())<div class="alert errors"><strong>Periksa kembali data:</strong><ul style="margin:7px 0 0;padding-left:20px">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <form class="sec-form" method="POST" action="{{ route('security.findings.store') }}" enctype="multipart/form-data" id="finding-wizard">@csrf
        <div class="sec-wizard">
            <section class="sec-card"><div class="sec-card-body">
                <div class="sec-steps" id="wizard-steps"><div class="sec-step active" data-step-label="1"><div class="sec-step-dot">1</div>Informasi Temuan</div><div class="sec-step" data-step-label="2"><div class="sec-step-dot">2</div>Rekomendasi &amp; Bukti</div><div class="sec-step" data-step-label="3"><div class="sec-step-dot">3</div>Penugasan &amp; Notifikasi</div></div>
                <section class="sec-step-pane" data-step="1"><h2 class="sec-section-title"><i class="bi bi-shield-exclamation"></i> Informasi Temuan</h2><div class="sec-form-grid">
                    <div class="full"><label for="application_id">Aplikasi <span class="sec-required">*</span></label><select id="application_id" name="application_id" required><option value="">Pilih aplikasi atau ketik nama...</option>@foreach($applications as $application)<option value="{{ $application->id }}" data-url="{{ $application->url }}" data-owner="{{ $application->owner }}" data-pic="{{ $application->pic }}" data-phone="{{ $application->pic_phone }}" @selected(old('application_id') == $application->id)>{{ $application->name }}{{ $application->owner ? ' — '.$application->owner : '' }}</option>@endforeach</select><small class="sec-count">Pilih aplikasi dari katalog untuk mengisi perangkat daerah dan URL.</small></div>
                    <div><label for="application_url_preview">URL Aplikasi</label><input id="application_url_preview" value="" placeholder="Terisi dari katalog aplikasi" readonly></div>
                    <div><label for="owner_preview">Perangkat Daerah</label><input id="owner_preview" value="" placeholder="Terisi dari katalog aplikasi" readonly></div>
                    <div><label for="finding_type">Jenis Temuan <span class="sec-required">*</span></label><select id="finding_type" name="finding_type" required><option value="">Pilih jenis temuan</option>@foreach($types as $type)<option value="{{ $type }}" @selected(old('finding_type') === $type)>{{ $type }}</option>@endforeach</select></div>
                    <div><label for="severity">Severity <span class="sec-required">*</span></label><select id="severity" name="severity" required><option value="">Pilih tingkat risiko</option>@foreach(['High','Medium','Low'] as $severity)<option value="{{ $severity }}" @selected(old('severity', 'Medium') === $severity)>{{ $severity }}</option>@endforeach</select></div>
                    <div><label for="source">Sumber Temuan <span class="sec-required">*</span></label><select id="source" name="source" required><option value="">Pilih sumber temuan</option>@foreach($sources as $source)<option value="{{ $source }}" @selected(old('source') === $source)>{{ $source }}</option>@endforeach</select></div>
                    <div><label for="found_at">Tanggal Temuan <span class="sec-required">*</span></label><input id="found_at" type="datetime-local" name="found_at" value="{{ old('found_at', now()->format('Y-m-d\TH:i')) }}" required></div>
                    <div class="full"><label for="title">Judul Temuan <span class="sec-required">*</span></label><input id="title" name="title" value="{{ old('title') }}" maxlength="180" placeholder="Contoh: Web Defacement pada SITABAH" required><small class="sec-count">Beri judul yang ringkas dan mudah dikenali.</small></div>
                    <div class="full"><label for="description">Deskripsi Temuan <span class="sec-required">*</span></label><textarea id="description" name="description" maxlength="10000" placeholder="Jelaskan detail temuan keamanan..." required>{{ old('description') }}</textarea></div>
                </div><div class="sec-form-actions"><a class="sec-button light" href="{{ route('security.findings.index') }}"><i class="bi bi-x-lg"></i> Batal</a><button class="sec-button wizard-next" type="button">Selanjutnya <i class="bi bi-arrow-right"></i></button></div></section>
                <section class="sec-step-pane" data-step="2" hidden><h2 class="sec-section-title"><i class="bi bi-lightbulb-fill"></i> Rekomendasi Penanganan</h2><div class="sec-form-grid">
                    <div class="full"><label for="impact">Dampak Temuan</label><textarea id="impact" name="impact" maxlength="5000" placeholder="Jelaskan potensi dampak temuan...">{{ old('impact') }}</textarea></div>
                    <div class="full"><label for="recommendation">Rekomendasi <span class="sec-required">*</span></label><textarea id="recommendation" name="recommendation" maxlength="10000" placeholder="Tuliskan langkah penanganan yang direkomendasikan..." required>{{ old('recommendation') }}</textarea></div>
                    <div class="full"><label for="evidence">Bukti Temuan</label><div class="sec-drop"><i class="bi bi-cloud-arrow-up" style="font-size:28px;color:#087cf0"></i><p style="margin:6px 0">Pilih atau tarik berkas bukti ke sini</p><small>JPG, PNG, PDF, ZIP, TXT, LOG · Maks. 10 MB per berkas · Maks. 10 berkas</small><input id="evidence" type="file" name="evidence[]" accept=".jpg,.jpeg,.png,.pdf,.zip,.txt,.log" multiple style="margin-top:12px"></div><div id="evidence-list" class="sec-count" style="margin-top:8px"></div></div>
                </div><div class="sec-form-actions"><button class="sec-button light wizard-back" type="button"><i class="bi bi-arrow-left"></i> Kembali</button><button class="sec-button wizard-next" type="button">Selanjutnya <i class="bi bi-arrow-right"></i></button></div></section>
                <section class="sec-step-pane" data-step="3" hidden><h2 class="sec-section-title"><i class="bi bi-people-fill"></i> Penugasan &amp; Notifikasi</h2><div class="sec-callout" style="margin-bottom:15px"><i class="bi bi-info-circle-fill"></i> Data PIC akan dicatat bersama temuan. Pengiriman email otomatis belum dikonfigurasi.</div><div class="sec-form-grid">
                    <div class="full"><label for="pic_name">PIC / Penanggung Jawab</label><input id="pic_name" name="pic_name" value="{{ old('pic_name') }}" maxlength="150" placeholder="Nama PIC perangkat daerah"></div>
                    <div class="full"><label for="pic_email">Email PIC</label><input id="pic_email" type="email" name="pic_email" value="{{ old('pic_email') }}" maxlength="190" placeholder="nama@jabarprov.go.id"></div>
                    <div><label for="deadline">Batas Waktu Tindak Lanjut</label><input id="deadline" type="date" name="deadline" min="{{ now()->toDateString() }}" value="{{ old('deadline') }}"></div>
                    <div><label>Status Awal</label><input value="Baru" readonly></div>
                    <div class="full"><label for="internal_note">Catatan Internal (Opsional)</label><textarea id="internal_note" name="internal_note" maxlength="500" placeholder="Catatan untuk tim internal...">{{ old('internal_note') }}</textarea><small class="sec-count">Maksimal 500 karakter.</small></div>
                </div><div class="sec-form-actions"><button class="sec-button light wizard-back" type="button"><i class="bi bi-arrow-left"></i> Kembali</button><button class="sec-button success" type="submit"><i class="bi bi-check-lg"></i> Simpan Temuan</button></div></section>
            </div></section>
            <aside class="sec-summary"><section class="sec-card"><div class="sec-card-head"><span><i class="bi bi-file-earmark-text"></i> Ringkasan Temuan</span></div><div class="sec-card-body"><div class="sec-summary-row"><strong>Aplikasi</strong><span id="summary-app">Belum dipilih</span></div><div class="sec-summary-row"><strong>URL</strong><span id="summary-url">—</span></div><div class="sec-summary-row"><strong>Perangkat Daerah</strong><span id="summary-owner">—</span></div><div class="sec-summary-row"><strong>Jenis Temuan</strong><span id="summary-type">—</span></div><div class="sec-summary-row"><strong>Severity</strong><span id="summary-severity">—</span></div><div class="sec-summary-row"><strong>Status</strong><span class="sec-badge status-baru">Baru</span></div><div class="sec-summary-row"><strong>Tanggal</strong><span id="summary-date">—</span></div><div class="sec-callout" style="margin-top:14px"><i class="bi bi-shield-check"></i> Lengkapi seluruh langkah sebelum menyimpan temuan.</div></div></section></aside>
        </div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('finding-wizard');
    const panes = [...form.querySelectorAll('.sec-step-pane')];
    const steps = [...document.querySelectorAll('.sec-step')];
    let activeStep = 0;
    function showStep(index) {
        activeStep = Math.max(0, Math.min(index, panes.length - 1));
        panes.forEach((pane, i) => pane.hidden = i !== activeStep);
        steps.forEach((step, i) => { step.classList.toggle('active', i === activeStep); step.classList.toggle('done', i < activeStep); });
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    form.querySelectorAll('.wizard-next').forEach(button => button.addEventListener('click', function () {
        const required = [...panes[activeStep].querySelectorAll('[required]')];
        const invalid = required.find(field => !field.checkValidity());
        if (invalid) { invalid.reportValidity(); return; }
        showStep(activeStep + 1);
    }));
    form.querySelectorAll('.wizard-back').forEach(button => button.addEventListener('click', () => showStep(activeStep - 1)));
    const application = document.getElementById('application_id');
    const setText = (id, value) => document.getElementById(id).textContent = value || '—';
    application.addEventListener('change', function () {
        const option = this.selectedOptions[0];
        const name = option?.textContent.split(' — ')[0] || '';
        const url = option?.dataset.url || '';
        const owner = option?.dataset.owner || '';
        document.getElementById('application_url_preview').value = url;
        document.getElementById('owner_preview').value = owner;
        setText('summary-app', name || 'Belum dipilih');
        setText('summary-url', url);
        setText('summary-owner', owner);
        document.getElementById('pic_name').value = option?.dataset.pic || '';
    });
    document.getElementById('finding_type').addEventListener('change', event => setText('summary-type', event.target.value));
    document.getElementById('severity').addEventListener('change', event => setText('summary-severity', event.target.value));
    document.getElementById('found_at').addEventListener('change', event => setText('summary-date', event.target.value.replace('T', ' ')));
    document.getElementById('evidence').addEventListener('change', function () {
        document.getElementById('evidence-list').textContent = [...this.files].map(file => `${file.name} (${Math.ceil(file.size / 1024)} KB)`).join(' · ');
    });
    application.dispatchEvent(new Event('change'));
    document.getElementById('found_at').dispatchEvent(new Event('change'));
});
</script>
@endsection
