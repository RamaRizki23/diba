@if ($errors->any())<div class="alert errors"><ul style="margin:0;padding-left:18px">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<div class="form-grid">
<div><label for="code">Kode aplikasi *</label><input id="code" name="code" value="{{ old('code', $application->code ?? '') }}" required></div>
<div><label for="name">Nama aplikasi *</label><input id="name" name="name" value="{{ old('name', $application->name ?? '') }}" required></div>
<div><label for="owner">Perangkat daerah</label><select id="owner" name="owner"><option value="">-- Pilih perangkat daerah --</option>@foreach($masterData['perangkat_daerah'] ?? [] as $item)<option value="{{ $item->name }}" {{ old('owner', $application->owner ?? '') === $item->name ? 'selected' : '' }}>{{ $item->name }}</option>@endforeach</select></div>
<div><label for="service">Layanan</label><select id="service" name="service"><option value="">-- Pilih layanan --</option>@foreach($masterData['layanan'] ?? [] as $item)<option value="{{ $item->name }}" {{ old('service', $application->service ?? '') === $item->name ? 'selected' : '' }}>{{ $item->name }}</option>@endforeach</select></div>
<div><label for="year">Tahun pembuatan</label><input id="year" type="number" name="year" min="2000" max="2100" value="{{ old('year', $application->year ?? '') }}"></div>
<div><label for="status">Status</label><select id="status" name="status">@foreach(['Aktif','Dalam Pengembangan','Nonaktif'] as $status)<option {{ old('status', $application->status ?? 'Aktif') === $status ? 'selected' : '' }}>{{ $status }}</option>@endforeach</select></div>
<div><label for="sector">Sektor</label><select id="sector" name="sector"><option value="">-- Pilih sektor --</option>@foreach($masterData['sektor'] ?? [] as $item)<option value="{{ $item->name }}" {{ old('sector', $application->sector ?? '') === $item->name ? 'selected' : '' }}>{{ $item->name }}</option>@endforeach</select></div>
<div><label for="url">URL aplikasi</label><input id="url" type="url" name="url" value="{{ old('url', $application->url ?? '') }}"></div>
<div><label for="language">Bahasa pemrograman</label><select id="language" name="language"><option value="">-- Pilih bahasa --</option>@foreach($masterData['bahasa_pemrograman'] ?? [] as $item)<option value="{{ $item->name }}" {{ old('language', $application->language ?? '') === $item->name ? 'selected' : '' }}>{{ $item->name }}</option>@endforeach</select></div>
<div><label for="framework">Framework</label><select id="framework" name="framework"><option value="">-- Pilih framework --</option>@foreach($masterData['framework'] ?? [] as $item)<option value="{{ $item->name }}" {{ old('framework', $application->framework ?? '') === $item->name ? 'selected' : '' }}>{{ $item->name }}</option>@endforeach</select></div>
<div><label for="database">Database</label><select id="database" name="database"><option value="">-- Pilih database --</option>@foreach($masterData['database'] ?? [] as $item)<option value="{{ $item->name }}" {{ old('database', $application->database ?? '') === $item->name ? 'selected' : '' }}>{{ $item->name }}</option>@endforeach</select></div>
<div><label for="operating_system">Operating system</label><select id="operating_system" name="operating_system"><option value="">-- Pilih operating system --</option>@foreach($masterData['operating_system'] ?? [] as $item)<option value="{{ $item->name }}" {{ old('operating_system', $application->operating_system ?? '') === $item->name ? 'selected' : '' }}>{{ $item->name }}</option>@endforeach</select></div>
<div><label for="server">Server</label><input id="server" name="server" value="{{ old('server', $application->server ?? '') }}"></div>
<div><label for="architecture">Arsitektur</label><input id="architecture" name="architecture" value="{{ old('architecture', $application->architecture ?? '') }}"></div>
<div><label for="server_location">Lokasi server</label><input id="server_location" name="server_location" value="{{ old('server_location', $application->server_location ?? '') }}"></div>
<div><label for="pic">PIC</label><input id="pic" name="pic" value="{{ old('pic', $application->pic ?? '') }}"></div>
<div><label for="pic_phone">No HP PIC</label><input id="pic_phone" name="pic_phone" value="{{ old('pic_phone', $application->pic_phone ?? '') }}"></div>
<div><label for="geoaccess">Geoakses</label><input id="geoaccess" name="geoaccess" value="{{ old('geoaccess', $application->geoaccess ?? '') }}"></div>
<div><label for="login_type">Tipe login</label><input id="login_type" name="login_type" value="{{ old('login_type', $application->login_type ?? '') }}"></div>
<div><label for="splp_connection">Terhubung dengan SPLP</label><input id="splp_connection" name="splp_connection" value="{{ old('splp_connection', $application->splp_connection ?? '') }}"></div>
<div><label for="profile_status">Profil</label><input id="profile_status" name="profile_status" value="{{ old('profile_status', $application->profile_status ?? '') }}"></div>
<div><label for="repository_status">Repository</label><input id="repository_status" name="repository_status" value="{{ old('repository_status', $application->repository_status ?? '') }}"></div>
<div><label for="pse_status">PSE</label><input id="pse_status" name="pse_status" value="{{ old('pse_status', $application->pse_status ?? '') }}"></div>
<div><label for="pse_badge">Badge PSE</label><input id="pse_badge" name="pse_badge" value="{{ old('pse_badge', $application->pse_badge ?? '') }}"></div>
<div><label for="api_availability">Ketersediaan API</label><input id="api_availability" name="api_availability" value="{{ old('api_availability', $application->api_availability ?? '') }}"></div>
<div><label for="haki_status">HAKI</label><input id="haki_status" name="haki_status" value="{{ old('haki_status', $application->haki_status ?? '') }}"></div>
<div><label for="haki_year">Tahun HAKI</label><input id="haki_year" type="number" name="haki_year" min="1900" max="2100" value="{{ old('haki_year', $application->haki_year ?? '') }}"></div>
<div><label for="development_cost">Biaya pembangunan</label><input id="development_cost" type="number" min="0" step="0.01" name="development_cost" value="{{ old('development_cost', $application->development_cost ?? 0) }}"></div>
<div><label for="total_investment">Total nilai investasi</label><input id="total_investment" type="number" min="0" step="0.01" name="total_investment" value="{{ old('total_investment', $application->total_investment ?? '') }}"></div>
<div><label for="development_expansion_cost">Biaya pengembangan</label><input id="development_expansion_cost" type="number" min="0" step="0.01" name="development_expansion_cost" value="{{ old('development_expansion_cost', $application->development_expansion_cost ?? '') }}"></div>
<div><label for="application_type">Tipe aplikasi</label><input id="application_type" name="application_type" value="{{ old('application_type', $application->application_type ?? '') }}"></div>
<div><label for="license">Lisensi</label><input id="license" name="license" value="{{ old('license', $application->license ?? '') }}"></div>
<div><label for="platform_basis">Basis</label><input id="platform_basis" name="platform_basis" value="{{ old('platform_basis', $application->platform_basis ?? '') }}"></div>
<div><label for="e_service_type">Jenis e-service</label><input id="e_service_type" name="e_service_type" value="{{ old('e_service_type', $application->e_service_type ?? '') }}"></div>
<div><label for="user_type">Jenis pengguna</label><input id="user_type" name="user_type" value="{{ old('user_type', $application->user_type ?? '') }}"></div>
<div><label for="developer_type">Pengembang</label><input id="developer_type" name="developer_type" value="{{ old('developer_type', $application->developer_type ?? '') }}"></div>
<div><label for="developer_name">Nama pengembang</label><input id="developer_name" name="developer_name" value="{{ old('developer_name', $application->developer_name ?? '') }}"></div>
<div><label for="personal_data">Data pribadi</label><input id="personal_data" name="personal_data" value="{{ old('personal_data', $application->personal_data ?? '') }}"></div>
<div><label for="support_info">Pendukung</label><input id="support_info" name="support_info" value="{{ old('support_info', $application->support_info ?? '') }}"></div>
<div class="full"><label for="description">Deskripsi</label><textarea id="description" name="description">{{ old('description', $application->description ?? '') }}</textarea></div>
<div><label for="operational_unit">Unit operasional</label><textarea id="operational_unit" name="operational_unit">{{ old('operational_unit', $application->operational_unit ?? '') }}</textarea></div>
<div><label for="integrations">Aplikasi terintegrasi</label><textarea id="integrations" name="integrations">{{ old('integrations', $application->integrations ?? '') }}</textarea></div>
<div><label for="business_process">Proses bisnis</label><textarea id="business_process" name="business_process">{{ old('business_process', $application->business_process ?? '') }}</textarea></div>
<div><label for="input_data">Inputan</label><textarea id="input_data" name="input_data">{{ old('input_data', $application->input_data ?? '') }}</textarea></div>
<div><label for="output_data">Output</label><textarea id="output_data" name="output_data">{{ old('output_data', $application->output_data ?? '') }}</textarea></div>
</div>
<div class="form-actions"><a class="button secondary" href="{{ route('applications.index') }}">Batal</a><button class="button" type="submit">{{ $submitLabel }}</button></div>
