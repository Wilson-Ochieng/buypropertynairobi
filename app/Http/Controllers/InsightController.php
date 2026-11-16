<?php
namespace App\Http\Controllers;

use App\Models\Insight;
use App\Models\Project;
use Illuminate\Http\Request;

class InsightController extends Controller
{
    public function index(Request $request)
    {
        $insights = Insight::published()
            ->when($request->query('location'), fn($q, $loc) => $q->where('location', $loc))
            ->orderBy('sort_order')
            ->get();

        $locations = Insight::published()
            ->distinct()
            ->orderBy('location')
            ->pluck('location');

        return view('insights.index', compact('insights', 'locations'));
    }

    public function show(Insight $insight)
    {
        $relatedProjects = Project::where('location', $insight->location)
            ->with('country')
            ->orderBy('sort_order')
            ->get();

        $otherInsights = Insight::published()
            ->where('id', '!=', $insight->id)
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return view('insights.show', compact('insight', 'relatedProjects', 'otherInsights'));
    }
}