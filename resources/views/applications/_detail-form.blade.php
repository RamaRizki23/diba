@if ($errors->any())<div class="alert errors"><ul style="margin:0;padding-left:18px">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
@php($value = fn ($field) => old($field, $application->{$field} ?? ''))
<div class="detail-grid">
<div class="detail-list">
<div class="detail-row"><label for="name">Nama Aplikasi</label><div><input id="name" name="name" value="{{ $value('name') }}" required></div></div>
<div class="detail-row"><label for="code">Kode</label><div><input id="code" name="code" value="{{ $value('code') }}" required></div></div>
<div class="detail-row"><label for="url">URL</label><div><input id="url" type="url" name="url" value="{{ $value('url') }}"></div></div>
<div class="detail-row"><label for="description">Deskripsi</label><div><textarea id="description" name="description">{{ $value('description') }}</textarea></div></div>
<div class="detail-row"><label for="owner">Perangkat Daerah</label><div><select id="owner" name="owner"><option value="">-</option>@foreach($masterData['perangkat_daerah'] ?? [] as $item)<option value="{{ $item->name }}" {{ $value('owner') === $item->name ? 'selected' : '' }}>{{ $item->name }}</option>@endforeach</select></div></div>
<div class="detail-row"><label for="sector">Sektor</label><div><select id="sector" name="sector"><option value="">-</option>@foreach($masterData['sektor'] ?? [] as $item)<option value="{{ $item->name }}" {{ $value('sector') === $item->name ? 'selected' : '' }}>{{ $item->name }}</option>@endforeach</select></div></div>
<div class="detail-row"><label for="service">Layanan</label><div><select id="service" name="service"><option value="">-</option>@foreach($masterData['layanan'] ?? [] as $item)<option value="{{ $item->name }}" {{ $value('service') === $item->name ? 'selected' : '' }}>{{ $item->name }}</option>@endforeach</select></div></div>
<div class="detail-row"><label for="year">Tahun Pembuatan</label><div><input id="year" type="number" name="year" min="2000" max="2100" value="{{ $value('year') }}"></div></div>
<div class="detail-row"><label for="architecture">Arsitektur</label><div><input id="architecture" name="architecture" value="{{ $value('architecture') }}"></div></div>
<div class="detail-row"><label for="server">Server</label><div><input id="server" name="server" value="{{ $value('server') }}"></div></div>
<div class="detail-row"><label for="server_location">Lokasi Server</label><div><input id="server_location" name="server_location" value="{{ $value('server_location') }}"></div></div>
<div class="detail-row"><label for="pic">PIC</label><div><input id="pic" name="pic" value="{{ $value('pic') }}"></div></div>
<div class="detail-row"><label for="pic_phone">No HP PIC</label><div><input id="pic_phone" name="pic_phone" value="{{ $value('pic_phone') }}"></div></div>
<div class="detail-row"><label for="geoaccess">Geoakses</label><div><input id="geoaccess" name="geoaccess" value="{{ $value('geoaccess') }}"></div></div>
<div class="detail-row"><label for="status">Status</label><div><select id="status" name="status"><option {{ $value('status') === 'Aktif' ? 'selected' : '' }}>Aktif</option><option {{ $value('status') === 'Dalam Pengembangan' ? 'selected' : '' }}>Dalam Pengembangan</option><option {{ $value('status') === 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option></select></div></div>
<div class="detail-row"><label for="login_type">Tipe Login</label><div><input id="login_type" name="login_type" value="{{ $value('login_type') }}"></div></div>
<div class="detail-row"><label for="splp_connection">Terhubung dengan SPLP</label><div><input id="splp_connection" name="splp_connection" value="{{ $value('splp_connection') }}"></div></div>
<div class="detail-row"><label for="profile_status">Profil</label><div><input id="profile_status" name="profile_status" value="{{ $value('profile_status') }}"></div></div>
<div class="detail-row"><label for="repository_status">Repository</label><div><input id="repository_status" name="repository_status" value="{{ $value('repository_status') }}"></div></div>
<div class="detail-row"><label for="pse_status">PSE</label><div><input id="pse_status" name="pse_status" value="{{ $value('pse_status') }}"></div></div>
<div class="detail-row"><label for="pse_badge">Badge PSE</label><div><input id="pse_badge" name="pse_badge" value="{{ $value('pse_badge') }}"></div></div>
<div class="detail-row"><label for="api_availability">Ketersediaan API</label><div><input id="api_availability" name="api_availability" value="{{ $value('api_availability') }}"></div></div>
<div class="detail-row"><label for="haki_status">HAKI</label><div><input id="haki_status" name="haki_status" value="{{ $value('haki_status') }}"></div></div>
<div class="detail-row"><label for="haki_year">Tahun HAKI</label><div><input id="haki_year" type="number" name="haki_year" min="1900" max="2100" value="{{ $value('haki_year') }}"></div></div>
</div>
<div class="detail-list">
<div class="detail-row"><label for="total_investment">Total Nilai Investasi</label><div><input id="total_investment" type="number" min="0" step="0.01" name="total_investment" value="{{ $value('total_investment') }}"></div></div>
<div class="detail-row"><label for="development_cost">Biaya Pembangunan</label><div><input id="development_cost" type="number" min="0" step="0.01" name="development_cost" value="{{ $value('development_cost') }}"></div></div>
<div class="detail-row"><label for="development_expansion_cost">Biaya Pengembangan</label><div><input id="development_expansion_cost" type="number" min="0" step="0.01" name="development_expansion_cost" value="{{ $value('development_expansion_cost') }}"></div></div>
<div class="detail-row"><label for="application_type">Tipe Aplikasi</label><div><input id="application_type" name="application_type" value="{{ $value('application_type') }}"></div></div>
<div class="detail-row"><label for="license">Lisensi</label><div><input id="license" name="license" value="{{ $value('license') }}"></div></div>
<div class="detail-row"><label for="platform_basis">Basis</label><div><input id="platform_basis" name="platform_basis" value="{{ $value('platform_basis') }}"></div></div>
<div class="detail-row"><label for="language">Bahasa Pemrograman</label><div><select id="language" name="language"><option value="">-</option>@foreach($masterData['bahasa_pemrograman'] ?? [] as $item)<option value="{{ $item->name }}" {{ $value('language') === $item->name ? 'selected' : '' }}>{{ $item->name }}</option>@endforeach</select></div></div>
<div class="detail-row"><label for="framework">Framework</label><div><select id="framework" name="framework"><option value="">-</option>@foreach($masterData['framework'] ?? [] as $item)<option value="{{ $item->name }}" {{ $value('framework') === $item->name ? 'selected' : '' }}>{{ $item->name }}</option>@endforeach</select></div></div>
<div class="detail-row"><label for="database">Database</label><div><select id="database" name="database"><option value="">-</option>@foreach($masterData['database'] ?? [] as $item)<option value="{{ $item->name }}" {{ $value('database') === $item->name ? 'selected' : '' }}>{{ $item->name }}</option>@endforeach</select></div></div>
<div class="detail-row"><label for="operating_system">Operating System</label><div><select id="operating_system" name="operating_system"><option value="">-</option>@foreach($masterData['operating_system'] ?? [] as $item)<option value="{{ $item->name }}" {{ $value('operating_system') === $item->name ? 'selected' : '' }}>{{ $item->name }}</option>@endforeach</select></div></div>
<div class="detail-row"><label for="web_server">Web Server</label><div><input id="web_server" value="{{ $value('server') }}" disabled></div></div>
<div class="detail-row"><label for="e_service_type">Jenis E-service</label><div><input id="e_service_type" name="e_service_type" value="{{ $value('e_service_type') }}"></div></div>
<div class="detail-row"><label for="user_type">Jenis Pengguna</label><div><input id="user_type" name="user_type" value="{{ $value('user_type') }}"></div></div>
<div class="detail-row"><label for="developer_type">Pengembang</label><div><input id="developer_type" name="developer_type" value="{{ $value('developer_type') }}"></div></div>
<div class="detail-row"><label for="developer_name">Nama Pengembang</label><div><input id="developer_name" name="developer_name" value="{{ $value('developer_name') }}"></div></div>
<div class="detail-row"><label for="operational_unit">Unit Operasional</label><div><textarea id="operational_unit" name="operational_unit">{{ $value('operational_unit') }}</textarea></div></div>
<div class="detail-row"><label for="personal_data">Data Pribadi</label><div><input id="personal_data" name="personal_data" value="{{ $value('personal_data') }}"></div></div>
<div class="detail-row"><label for="support_info">Pendukung</label><div><input id="support_info" name="support_info" value="{{ $value('support_info') }}"></div></div>
<div class="detail-row"><label for="integrations">Berintegrasi dengan Aplikasi</label><div><textarea id="integrations" name="integrations">{{ $value('integrations') }}</textarea></div></div>
<div class="detail-row"><label for="business_process">Proses Bisnis</label><div><textarea id="business_process" name="business_process">{{ $value('business_process') }}</textarea></div></div>
<div class="detail-row"><label for="input_data">Inputan</label><div><textarea id="input_data" name="input_data">{{ $value('input_data') }}</textarea></div></div>
<div class="detail-row"><label for="output_data">Output</label><div><textarea id="output_data" name="output_data">{{ $value('output_data') }}</textarea></div></div>
</div>
</div>
<div class="detail-actions"><a class="button secondary" href="{{ route('applications.index') }}">Batal</a><button class="button" type="submit">{{ $submitLabel }}</button></div>