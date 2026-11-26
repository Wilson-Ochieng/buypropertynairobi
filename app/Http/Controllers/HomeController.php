<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\GroupInfo;
use App\Models\HomeSlide;
use App\Models\Project;
use App\Models\SiteContact;
use App\Models\Subsidiary;

class HomeController extends Controller
{
    public function index()
    {
        $group = GroupInfo::current();

        // Active homepage hero slides
        $slides = HomeSlide::active()
            ->orderBy('sort_order')
            ->get();

        // Featured properties
        $featuredProjects = Project::with([
            'country',
            'unitTypes.unitTypeLookup',
            'unitTypes.style',
            'unitTypes.images',
            'highlights',
            'videos' => fn($q) => $q->published(),
        ])
            ->featured()
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        // Off-plan projects
        $offPlanProjects = Project::with([
            'country',
            'unitTypes.unitTypeLookup',
            'unitTypes.style',
            'unitTypes.images',
            'highlights',
            'videos' => fn($q) => $q->published(),
        ])
            ->where('status', 'off_plan')
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        // Unique locations from projects
        $homeLocations = Project::whereNotNull('location')
            ->distinct()
            ->orderBy('location')
            ->pluck('location')
            ->toArray();

        // Latest insights
        $homeInsights = \App\Models\Insight::published()
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return view('home', compact(
            'group',
            'slides',
            'featuredProjects',
            'offPlanProjects',
            'homeLocations',
            'homeInsights'
        ));
    }
}
