<?php
namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

use App\Models\Project;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $countries = Country::active()->orderBy('sort_order')->get();

        // ── Active country — ONLY when explicitly clicked ──
        $activeCountrySlug = $request->query('country');
        $activeCountry = $activeCountrySlug
            ? $countries->firstWhere('slug', $activeCountrySlug)
            : null;   // ← no default — null means "All countries"

        // ── Locations — depends on active country (or all if none) ──
        $locationsQuery = Project::query()->whereNotNull('location');
        if ($activeCountry) {
            $locationsQuery->where('country_id', $activeCountry->id);
        }
        $locations = $locationsQuery->distinct()->orderBy('location')->pluck('location');

        // ── Filters ──
        $purpose = $request->query('purpose');
        $status = $request->query('status');
        $location = $request->query('location');
        $type = $request->query('type');        // residential / commercial
        $bedrooms = $request->query('bedrooms');
        $maxPrice = $request->query('max_price');

        $projects = Project::with([
            'country',
            'unitTypes.unitTypeLookup',
            'unitTypes.style',
            'unitTypes.images',
            'unitTypes.videos',
            'highlights',
            'videos' => fn($q) => $q->published(),
        ])
            ->when($activeCountry, fn($q) => $q->where('country_id', $activeCountry->id))
            ->byStatus($status)
            ->inLocation($location)
            ->when($type, fn($q) => $q->whereHas('unitTypes', fn($u) => $u->where('category', $type)))
            ->when($bedrooms, fn($q) => $q->whereHas('unitTypes', fn($u) => $u->where('bedrooms', '>=', $bedrooms)))
            ->when($maxPrice, fn($q) => $q->whereHas('unitTypes', fn($u) => $u->where('price_kes', '<=', $maxPrice)))
            ->when($purpose, function ($q) use ($purpose) {
                $q->whereHas('unitTypes', function ($u) use ($purpose) {
                    $u->whereIn('purpose', $purpose === 'rent' ? ['rent', 'both'] : ['sale', 'both']);
                });
            })
            ->orderBy('sort_order')
            ->get();

        return view('projects.index', compact(
            'countries',
            'activeCountry',
            'activeCountrySlug',
            'locations',
            'projects',
            'purpose',
            'status',
        ));
    }

    public function show(Project $project)
    {
        $project->load([
            'country',
            'unitTypes',
            'highlights',
            'images',
            'unitTypes.style',
            'unitTypes.images',
            'unitTypes.videos',
            'videos' => fn($q) => $q->published(),
        ]);

        $insight = \App\Models\Insight::published()
            ->where('location', $project->location)
            ->first();

        $relatedProjects = Project::where('country_id', $project->country_id)
            ->where('id', '!=', $project->id)
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return view('projects.show', compact('project', 'insight', 'relatedProjects'));
    }
}