<?php
namespace App\Http\Controllers;

use App\Models\UnitType;
use App\Models\UnitTypeLookup;
use App\Models\Project;

class UnitController extends Controller
{
    public function show(UnitType $unit)
    {
        // Eager-load everything the page needs
        $unit->load([
            'project.country',
            'project.highlights',
            'project.videos' => fn($q) => $q->published(),
            'unitTypeLookup',
            'style',
            'images',
            'videos' => fn($q) => $q->published(),
        ]);

        // Similar units — same style + bedrooms, different units, in the same country
        $similarUnits = UnitType::query()
            ->with(['project.country', 'images', 'style', 'unitTypeLookup'])
            ->where('id', '!=', $unit->id)
            ->where('purpose', $unit->purpose)
            ->when($unit->style_id, fn($q) => $q->where('style_id', $unit->style_id))
            ->whereHas('project', fn($q) => $q->where('country_id', $unit->project->country_id))
            ->limit(3)
            ->get();

        // Related insight for this location
        $insight = \App\Models\Insight::published()
            ->where('location', $unit->project->location)
            ->first();

        return view('units.show', compact('unit', 'similarUnits', 'insight'));
    }
}