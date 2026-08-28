@if ($errors->any())<div class="alert errors"><ul style="margin:0;padding-left:18px">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<div class="form-grid">
    <input type="hidden" name="type" value="{{ $type }}"><div><label>Kategori</label><input value="{{ $label }}" readonly></div>
    <div><label for="name">Nama data *</label><input id="name" name="name" value="{{ old('name', $masterData->name ?? '') }}" placeholder="Contoh: Diskominfo Jabar" required></div>
</div>
<div class="form-actions"><a class="button secondary" href="{{ route('master-data.index') }}">Batal</a><button class="button" type="submit">{{ $submitLabel }}</button></div>
