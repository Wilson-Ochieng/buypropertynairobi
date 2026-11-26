<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $countries = Country::active()->orderBy('sort_order')->get();

        $activeCountrySlug = $request->query('country');
        $activeCountry = $activeCountrySlug
            ? $countries->firstWhere('slug', $activeCountrySlug)
            : null;

        $locationsQuery = Property::query()->published()->whereNotNull('location');
        if ($activeCountry) {
            $locationsQuery->where('country_id', $activeCountry->id);
        }
        $locations = $locationsQuery->distinct()->orderBy('location')->pluck('location');

        $purpose = $request->query('purpose');
        $status = $request->query('status');
        $location = $request->query('location');
        $category = $request->query('category');
        $bedrooms = $request->query('bedrooms');
        $maxPrice = $request->query('max_price');

        $properties = Property::with(['country', 'images', 'videos' => fn($q) => $q->published()])
            ->published()
            ->when($activeCountry, fn($q) => $q->where('country_id', $activeCountry->id))
            ->byStatus($status)
            ->inLocation($location)
            ->byCategory($category)
            ->byPurpose($purpose)
            ->minBedrooms($bedrooms)
            ->maxPrice($maxPrice)
            ->orderBy('sort_order')
            ->paginate(12)
            ->withQueryString();

        return view('properties.index', compact(
            'countries',
            'activeCountry',
            'activeCountrySlug',
            'locations',
            'properties',
            'purpose',
            'status',
        ));
    }

    public function show(Property $property)
    {
        abort_unless($property->is_published, 404);

        $property->load([
            'country',
            'images',
            'highlights',
            'videos' => fn($q) => $q->published(),
        ]);

        $related = Property::published()
            ->where('country_id', $property->country_id)
            ->where('id', '!=', $property->id)
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return view('properties.show', compact('property', 'related'));
    }
}