<?php

namespace App\Http\Controllers;

use App\Models\MasterData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MasterDataController extends Controller
{
    public function index(Request $request): View
    {
        return view('master-data.index', ['types' => MasterData::TYPES]);
    }

    public function category(Request $request, string $type): View
    {
        abort_unless(array_key_exists($type, MasterData::TYPES), 404);

        $items = MasterData::query()->where('type', $type)
            ->when($request->filled('search'), fn ($query) => $query->where('name', 'like', '%'.$request->string('search')->toString().'%'))
            ->orderBy('name')->paginate(15)->withQueryString();

        return view('master-data.category', ['items' => $items, 'type' => $type, 'label' => MasterData::TYPES[$type]]);
    }

    public function create(string $type): View
    {
        abort_unless(array_key_exists($type, MasterData::TYPES), 404);

        return view('master-data.create', ['type' => $type, 'label' => MasterData::TYPES[$type]]);
    }

    public function store(Request $request, string $type): RedirectResponse
    {
        MasterData::create($this->validated($request, $type));

        return redirect()->route('master-data.category', $type)->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit(string $type, MasterData $masterDatum): View
    {
        abort_unless($masterDatum->type === $type && array_key_exists($type, MasterData::TYPES), 404);

        return view('master-data.edit', ['masterData' => $masterDatum, 'type' => $type, 'label' => MasterData::TYPES[$type]]);
    }

    public function update(Request $request, string $type, MasterData $masterDatum): RedirectResponse
    {
        abort_unless($masterDatum->type === $type, 404);
        $masterDatum->update($this->validated($request, $type, $masterDatum));

        return redirect()->route('master-data.category', $type)->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(string $type, MasterData $masterDatum): RedirectResponse
    {
        abort_unless($masterDatum->type === $type, 404);
        $masterDatum->delete();

        return redirect()->route('master-data.category', $type)->with('success', 'Data berhasil dihapus.');
    }

    private function validated(Request $request, string $type, ?MasterData $masterData = null): array
    {
        return $request->validate([
            'type' => ['required', Rule::in([$type])],
            'name' => [
                'required', 'string', 'max:150',
                Rule::unique('master_data', 'name')
                    ->where(fn ($query) => $query->where('type', $type))
                    ->ignore($masterData),
            ],
        ]);
    }
}
