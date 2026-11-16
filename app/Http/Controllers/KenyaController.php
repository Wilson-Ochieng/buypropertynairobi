<?php
namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\KenyaDivisionPage;
use App\Models\Project;
use App\Models\Testimonial;

class KenyaController extends Controller
{
    public function index()
    {
        $page = KenyaDivisionPage::current();
        $kenya = Country::where('slug', 'kenya')->first();

        $projects = Project::with(['country', 'highlights', 'videos', 'unitTypes'])
            ->where('country_id', $kenya?->id)
            ->orderBy('sort_order')
            ->get();

        $featuredTestimonials = Testimonial::published()
            ->featured()
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return view('kenya.index', compact('page', 'kenya', 'projects', 'featuredTestimonials'));
    }

    public function bay()
    {
        $project = Project::where('slug', 'nanchong-longines-bay')
            ->with(['country', 'unitTypes.unitTypeLookup', 'unitTypes.style', 'highlights', 'images', 'videos'])
            ->firstOrFail();

        $insight = \App\Models\Insight::published()->where('location', $project->location)->first();
        $relatedProjects = Project::where('country_id', $project->country_id)
            ->where('id', '!=', $project->id)->orderBy('sort_order')->limit(3)->get();

        return view('projects.show', compact('project', 'insight', 'relatedProjects'));
    }

    public function island()
    {
        $project = Project::where('slug', 'nanchong-longines-island')
            ->with(['country', 'unitTypes.unitTypeLookup', 'unitTypes.style', 'highlights', 'images', 'videos'])
            ->firstOrFail();

        $insight = \App\Models\Insight::published()->where('location', $project->location)->first();
        $relatedProjects = Project::where('country_id', $project->country_id)
            ->where('id', '!=', $project->id)->orderBy('sort_order')->limit(3)->get();

        return view('projects.show', compact('project', 'insight', 'relatedProjects'));
    }
}