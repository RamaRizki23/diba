<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $scope = $request->input('scope', 'provinsi');
        $scope = in_array($scope, ['provinsi', 'kabupaten-kota'], true) ? $scope : 'provinsi';

        $applications = Application::query()
            ->when($scope === 'kabupaten-kota', fn ($query) => $query->where(function ($query) {
                $query->where('owner', 'like', '%Kabupaten%')
                    ->orWhere('owner', 'like', '%Kota%');
            }))
            ->get();

        $countBy = fn (string $field) => $applications
            ->filter(fn ($application) => filled($application->{$field}))
            ->groupBy($field)
            ->map(fn ($items) => $items->count())
            ->sortDesc();

        return view('dashboard', [
            'scope' => $scope,
            'applications' => $applications,
            'stats' => [
                'total' => $applications->count(),
                'pse' => $applications->where('pse_status', 'Sudah')->count(),
                'repository' => $applications->where('repository_status', 'Sudah')->count(),
                'profile' => $applications->where('profile_status', 'Sudah')->count(),
            ],
            'charts' => [
                'sector' => $countBy('sector'),
                'service' => $countBy('service'),
                'status' => $applications->groupBy('status')->map(fn ($items) => $items->count())->sortDesc(),
                'language' => $countBy('language'),
                'framework' => $countBy('framework'),
                'database' => $countBy('database'),
            ],
        ]);
    }
}