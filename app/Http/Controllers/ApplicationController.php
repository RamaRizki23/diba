<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class ApplicationController extends Controller
{
    public function index(Request $request): View
    {
        $owners = Application::query()
            ->whereNotNull('owner')
            ->where('owner', '<>', '')
            ->distinct()
            ->orderBy('owner')
            ->pluck('owner');

        $applications = Application::query()
            ->when($request->filled('owner'), fn ($query) => $query->where('owner', $request->string('owner')))
            ->when($request->filled('search'), fn ($query) => $query->where(function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('code', 'like', '%'.$request->search.'%')
                    ->orWhere('owner', 'like', '%'.$request->search.'%');
            }))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('applications.index', compact('applications', 'owners'));
    }

    public function create(): View
    {
        return view('applications.create');
    }

    public function show(Application $application): View
    {
        return view('applications.show', compact('application'));
    }

    public function pdf(Application $application)
    {
        return Pdf::loadView('applications.pdf', compact('application'))
            ->setPaper('a4')
            ->download('detail-'.$application->code.'.pdf');
    }

    public function store(Request $request): RedirectResponse
    {
        Application::create($this->validated($request));

        return redirect()->route('applications.index')->with('success', 'Aplikasi berhasil ditambahkan.');
    }

    public function edit(Application $application): View
    {
        return view('applications.edit', compact('application'));
    }

    public function update(Request $request, Application $application): RedirectResponse
    {
        $application->update($this->validated($request));

        return redirect()->route('applications.index')->with('success', 'Data aplikasi berhasil diperbarui.');
    }

    public function destroy(Application $application): RedirectResponse
    {
        $application->delete();

        return redirect()->route('applications.index')->with('success', 'Aplikasi berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'code' => ['required', 'string', 'max:50', Rule::unique('applications', 'code')->ignore($request->route('application'))],
            'name' => ['required', 'string', 'max:150'],
            'owner' => ['nullable', 'string', 'max:150'],
            'service' => ['nullable', 'string', 'max:150'],
            'sector' => ['nullable', 'string', 'max:150'],
            'status' => ['required', 'in:Aktif,Nonaktif,Dalam Pengembangan'],
            'year' => ['nullable', 'integer', 'between:2000,2100'],
            'url' => ['nullable', 'url', 'max:255'],
            'language' => ['nullable', 'string', 'max:80'],
            'framework' => ['nullable', 'string', 'max:80'],
            'database' => ['nullable', 'string', 'max:80'],
            'operating_system' => ['nullable', 'string', 'max:80'],
            'server' => ['nullable', 'string', 'max:80'],
            'description' => ['nullable', 'string'],
            'operational_unit' => ['nullable', 'string'],
            'integrations' => ['nullable', 'string'],
            'development_cost' => ['nullable', 'numeric', 'min:0'],
        ]);
    }
}
