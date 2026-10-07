<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Dinas {{ $finding->reference_code }}</title>
    <style>
        @page{margin:25mm 22mm}body{font-family:DejaVu Sans,sans-serif;color:#202b36;font-size:11px;line-height:1.6}h1{font-size:18px;text-align:center;margin:0 0 4px}h2{font-size:13px;margin:18px 0 6px;border-bottom:1px solid #aeb8c2;padding-bottom:5px}.institution{text-align:center;font-weight:bold;font-size:12px}.rule{border-top:3px solid #263748;margin:10px 0 22px}.meta{width:100%;border-collapse:collapse;margin:14px 0}.meta td{padding:5px 7px;vertical-align:top;border:1px solid #d5dce3}.meta td:first-child{width:27%;font-weight:bold;background:#f4f6f8}.paragraph{white-space:pre-line}.signature{margin:45px 0 0 auto;width:220px;text-align:center}.signature .space{height:65px}.footer{position:fixed;bottom:-14mm;left:0;right:0;text-align:center;color:#71808a;font-size:9px}
    </style>
</head>
<body>
    <div class="institution">PEMERINTAH DAERAH PROVINSI JAWA BARAT<br>RINGKASAN TEMUAN KEAMANAN APLIKASI</div><div class="rule"></div>
    <h1>NOTA DINAS / RINGKASAN TINDAK LANJUT</h1>
    <table class="meta"><tr><td>Nomor Temuan</td><td>{{ $finding->reference_code }}</td></tr><tr><td>Tanggal Temuan</td><td>{{ $finding->found_at?->format('d-m-Y H:i') }} WIB</td></tr><tr><td>Kepada</td><td>{{ $finding->pic_name ?: 'PIC '.$finding->owner }}</td></tr><tr><td>Perangkat Daerah</td><td>{{ $finding->owner }}</td></tr><tr><td>Dari</td><td>Tim Keamanan Aplikasi</td></tr><tr><td>Perihal</td><td>{{ $finding->title }}</td></tr></table>
    <p>Dengan hormat, bersama ini disampaikan ringkasan temuan keamanan aplikasi untuk ditindaklanjuti sesuai batas waktu yang ditentukan.</p>
    <h2>Informasi Temuan</h2><table class="meta"><tr><td>Aplikasi</td><td>{{ $finding->application_name }}</td></tr><tr><td>URL</td><td>{{ $finding->application_url ?: '—' }}</td></tr><tr><td>Jenis / Kategori</td><td>{{ $finding->finding_type }} / {{ $finding->category }}</td></tr><tr><td>Severity</td><td>{{ $finding->severity }}</td></tr><tr><td>Status</td><td>{{ $finding->status }}</td></tr><tr><td>Sumber</td><td>{{ $finding->source }}</td></tr><tr><td>Batas Tindak Lanjut</td><td>{{ $finding->deadline?->format('d-m-Y') ?: 'Belum ditentukan' }}</td></tr></table>
    <h2>Deskripsi</h2><p class="paragraph">{{ $finding->description }}</p>
    @if($finding->impact)<h2>Dampak</h2><p class="paragraph">{{ $finding->impact }}</p>@endif
    <h2>Rekomendasi Penanganan</h2><p class="paragraph">{{ $finding->recommendation ?: 'Mohon lakukan investigasi dan tindak lanjut sesuai prosedur keamanan aplikasi.' }}</p>
    @if($finding->follow_up)<h2>Tindak Lanjut Terakhir</h2><p class="paragraph">{{ $finding->follow_up }}</p>@endif
    <div class="signature"><div>Bandung, {{ now()->translatedFormat('d F Y') }}<br>Tim Keamanan Aplikasi</div><div class="space"></div><strong>Administrator</strong></div>
    <div class="footer">Dokumen ini dibuat oleh DIBA Console · {{ $finding->reference_code }}</div>
</body>
</html>
