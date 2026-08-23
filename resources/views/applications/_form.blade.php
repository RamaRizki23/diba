@if ($errors->any())<div class="alert errors"><ul style="margin:0;padding-left:18px">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<div class="form-grid">
<div><label for="code">Kode aplikasi *</label><input id="code" name="code" value="{{ old('code', $application->code ?? '') }}" required></div>
<div><label for="name">Nama aplikasi *</label><input id="name" name="name" value="{{ old('name', $application->name ?? '') }}" required></div>
<div><label for="owner">Nama pemilik</label><input id="owner" name="owner" value="{{ old('owner', $application->owner ?? '') }}"></div>
<div><label for="service">Layanan</label><input id="service" name="service" value="{{ old('service', $application->service ?? '') }}"></div>
<div><label for="year">Tahun pembuatan</label><input id="year" type="number" name="year" min="2000" max="2100" value="{{ old('year', $application->year ?? '') }}"></div>
<div><label for="status">Status</label><select id="status" name="status">@foreach(['Aktif','Dalam Pengembangan','Nonaktif'] as $status)<option {{ old('status', $application->status ?? 'Aktif') === $status ? 'selected' : '' }}>{{ $status }}</option>@endforeach</select></div>
<div><label for="sector">Sektor</label><input id="sector" name="sector" value="{{ old('sector', $application->sector ?? '') }}"></div>
<div><label for="url">URL aplikasi</label><input id="url" type="url" name="url" value="{{ old('url', $application->url ?? '') }}"></div>
<div><label for="language">Bahasa pemrograman</label><input id="language" name="language" placeholder="Contoh: PHP" value="{{ old('language', $application->language ?? '') }}"></div>
<div><label for="framework">Framework</label><input id="framework" name="framework" placeholder="Contoh: Laravel" value="{{ old('framework', $application->framework ?? '') }}"></div>
<div><label for="database">Database</label><input id="database" name="database" placeholder="Contoh: MySQL" value="{{ old('database', $application->database ?? '') }}"></div>
<div><label for="operating_system">Operating system</label><input id="operating_system" name="operating_system" value="{{ old('operating_system', $application->operating_system ?? '') }}"></div>
<div><label for="server">Server</label><input id="server" name="server" value="{{ old('server', $application->server ?? '') }}"></div>
<div><label for="development_cost">Biaya pembangunan</label><input id="development_cost" type="number" min="0" step="0.01" name="development_cost" value="{{ old('development_cost', $application->development_cost ?? 0) }}"></div>
<div class="full"><label for="description">Deskripsi</label><textarea id="description" name="description">{{ old('description', $application->description ?? '') }}</textarea></div>
<div><label for="operational_unit">Unit operasional</label><textarea id="operational_unit" name="operational_unit">{{ old('operational_unit', $application->operational_unit ?? '') }}</textarea></div>
<div><label for="integrations">Aplikasi terintegrasi</label><textarea id="integrations" name="integrations">{{ old('integrations', $application->integrations ?? '') }}</textarea></div>
</div>
<div class="form-actions"><a class="button secondary" href="{{ route('applications.index') }}">Batal</a><button class="button" type="submit">{{ $submitLabel }}</button></div>
