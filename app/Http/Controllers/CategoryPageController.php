<?php

namespace App\Http\Controllers;

use App\Models\BudgetRange;
use App\Models\CategoryPage;
use App\Models\Style;
use App\Models\UnitType;
use App\Models\UnitTypeLookup;
use App\Models\UseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryPageController extends Controller
{
    private const CATEGORY_TYPES = ['location', 'use', 'style', 'type', 'budget'];

    public function show(Request $request, string $purpose, string $slug)
    {
        if (!in_array($purpose, ['buy', 'rent'])) {
            abort(404);
        }

        // Optional hint from links, resolves slug clashes (style "apartment" vs type "apartment")
        $by = $request->query('by');
        $by = in_array($by, self::CATEGORY_TYPES, true) ? $by : null;

        // Split slug: "apartment" or "apartment/2-bedroom"
        $parts = explode('/', trim($slug, '/'));
        $baseSlug = $parts[0];
        $bedroomSegment = $parts[1] ?? null;

        // ── Resolve the category page ──
        $page = CategoryPage::published()
            ->where('purpose', $purpose)
            ->where('slug', $baseSlug)
            ->when($by, fn($q) => $q->where('category_type', $by))
            ->first();

        if (!$page) {
            $page = $this->resolveFromLookup($purpose, $baseSlug, $by);
            if (!$page) {
                abort(404);
            }
        }

        // ── Parse bedrooms (once): slug segment or ?bedrooms= ──
        $bedrooms = null;

        if ($bedroomSegment !== null) {
            $bedrooms = $this->parseBedroomSegment($bedroomSegment);
            if ($bedrooms === false) {
                abort(404);
            }
        } elseif ($request->filled('bedrooms')) {
            $raw = $request->query('bedrooms');
            if (!is_numeric($raw) || (int) $raw < 0) {
                abort(404);
            }
            $bedrooms = min((int) $raw, 4); // 4 means "4 or more"
        }

        if ($bedrooms !== null) {
            $segment = $bedrooms === 0 ? 'studio' : $bedrooms . '-bedroom';

            // Optional hand-written override page for this bedroom count
            $bedroomPage = CategoryPage::published()
                ->where('purpose', $purpose)
                ->where('slug', $baseSlug . '/' . $segment)
                ->when($by, fn($q) => $q->where('category_type', $by))
                ->first();

            if ($bedroomPage) {
                $page = $bedroomPage;
            } else {
                $bedroomLabel = match ($bedrooms) {
                    0 => 'Studio',
                    4 => '4+ Bedroom',
                    default => $bedrooms . '-Bedroom',
                };
                $page->h1 = $bedroomLabel . ' ' . Str::plural($page->h1);
            }
        }

        // ── Query units ──
        $unitQuery = UnitType::query()
            ->with([
                'project.country',
                'project.highlights',
                'style',
                'unitTypeLookup',
                'images',
                'videos',
            ])
            ->whereHas('project')
            ->whereIn('purpose', $purpose === 'buy' ? ['sale', 'both'] : ['rent', 'both']);

        // Category filter
        switch ($page->category_type) {
            case 'location':
                $unitQuery->whereHas('project', fn($q) => $q->where('location', $page->filter_value));
                break;
            case 'use':
                $unitQuery->whereHas('project.useCategory', fn($q) => $q->where('slug', $page->filter_value));
                break;
            case 'style':
                $unitQuery->whereHas('style', fn($q) => $q->where('slug', $page->filter_value));
                break;
            case 'type':
                $unitQuery->whereHas('unitTypeLookup', fn($q) => $q->where('slug', $page->filter_value));
                break;
            case 'budget':
                [$min, $max] = array_pad(explode('-', $page->filter_value, 2), 2, null);
                if ($min !== '' && $min !== null) {
                    $unitQuery->where('price_kes', '>=', (float) $min);
                }
                if ($max !== '' && $max !== null) {
                    $unitQuery->where('price_kes', '<', (float) $max);
                }
                break;
        }

        // Bedroom filter (4 means 4+)  <-- this was missing in your version
        if ($bedrooms !== null) {
            if ($bedrooms >= 4) {
                $unitQuery->where('bedrooms', '>=', 4);
            } else {
                $unitQuery->where('bedrooms', '=', $bedrooms);
            }
        }

        $units = $unitQuery->orderBy('price_kes')->get()->groupBy('project_id');
        $totalUnits = $units->flatten()->count();

        $related = CategoryPage::published()
            ->where('purpose', $purpose)
            ->where('category_type', $page->category_type)
            ->where('id', '!=', $page->id)
            ->limit(6)
            ->get();

        return view('category-pages.show', compact(
            'page',
            'purpose',
            'units',
            'totalUnits',
            'bedrooms',
            'related'
        ));
    }

    private function parseBedroomSegment(string $segment)
    {
        return match ($segment) {
            'studio' => 0,
            '1-bedroom' => 1,
            '2-bedroom' => 2,
            '3-bedroom' => 3,
            '4-bedroom' => 4,
            default => false,
        };
    }

    private function resolveFromLookup(string $purpose, string $slug, ?string $by = null): ?CategoryPage
    {
        if (!$by || $by === 'style') {
            $style = Style::where('slug', $slug)->first();
            if ($style) {
                return new CategoryPage([
                    'purpose' => $purpose,
                    'category_type' => 'style',
                    'filter_value' => $style->slug,
                    'h1' => Str::plural($style->name),
                    'description' => $style->description,
                    'slug' => $slug,
                ]);
            }
        }

        if (!$by || $by === 'use') {
            $use = UseCategory::where('slug', $slug)->first();
            if ($use) {
                return new CategoryPage([
                    'purpose' => $purpose,
                    'category_type' => 'use',
                    'filter_value' => $use->slug,
                    'h1' => $use->name,
                    'description' => $use->description,
                    'slug' => $slug,
                ]);
            }
        }

        if (!$by || $by === 'type') {
            $type = UnitTypeLookup::where('slug', $slug)->first();
            if ($type) {
                return new CategoryPage([
                    'purpose' => $purpose,
                    'category_type' => 'type',
                    'filter_value' => $type->slug,
                    'h1' => Str::plural($type->name),
                    'description' => $type->description,
                    'slug' => $slug,
                ]);
            }
        }

        if ((!$by || $by === 'budget') && (str_contains($slug, '-') || is_numeric($slug))) {
            $purposeKey = $purpose === 'buy' ? 'sale' : 'rent';
            $range = BudgetRange::where('purpose', $purposeKey)->get()
                ->first(fn($r) => ($r->min_value ?? '') . '-' . ($r->max_value ?? '') === $slug);
            if ($range) {
                return new CategoryPage([
                    'purpose' => $purpose,
                    'category_type' => 'budget',
                    'filter_value' => $slug,
                    'h1' => 'Properties — ' . $range->label,
                    'description' => $range->description,
                    'slug' => $slug,
                ]);
            }
        }

        if (!$by || $by === 'location') {
            $label = ucwords(str_replace(['-', '_'], ' ', $slug));
            return new CategoryPage([
                'purpose' => $purpose,
                'category_type' => 'location',
                'filter_value' => $label,
                'h1' => 'Properties in ' . $label,
                'description' => null,
                'slug' => $slug,
            ]);
        }

        return null;
    }
}