<?php

namespace App\Http\Controllers;

use App\Models\HomeSlide;
use App\Models\Insight;
use App\Models\Property;

class HomeController extends Controller
{
    public function index()
    {
        // Active homepage hero slides
        $slides = HomeSlide::active()
            ->orderBy('sort_order')
            ->get();

        // Featured properties (falls back to newest published if none are featured)
        $featuredProperties = Property::published()->featured()
            ->with('country')
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        if ($featuredProperties->isEmpty()) {
            $featuredProperties = Property::published()
                ->with('country')
                ->orderBy('sort_order')
                ->latest()
                ->limit(6)
                ->get();
        }

        // New developments (off-plan / under construction)
        $offPlanProperties = Property::published()
            ->with('country')
            ->whereIn('status', ['off_plan', 'under_construction'])
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        // Search dropdowns: only values that exist on published properties
        $homeLocations = Property::published()
            ->whereNotNull('location')
            ->distinct()
            ->orderBy('location')
            ->pluck('location');

        $homeTypes = Property::published()
            ->whereNotNull('property_type')
            ->distinct()
            ->orderBy('property_type')
            ->pluck('property_type');

        // Neighbourhood tiles: top areas by listing count, with a cover image from one of their listings
        $neighbourhoods = Property::published()
            ->whereNotNull('location')
            ->selectRaw('location, COUNT(*) as c')
            ->groupBy('location')
            ->orderByDesc('c')
            ->limit(6)
            ->get()
            ->map(fn ($row) => [
                'location' => $row->location,
                'count' => (int) $row->c,
                'image' => Property::published()
                    ->where('location', $row->location)
                    ->whereNotNull('cover_image')
                    ->orderBy('sort_order')
                    ->value('cover_image'),
            ]);

        // Latest insights
        $homeInsights = Insight::published()
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return view('home', compact(
            'slides',
            'featuredProperties',
            'offPlanProperties',
            'homeLocations',
            'homeTypes',
            'neighbourhoods',
            'homeInsights',
        ));
    }
}