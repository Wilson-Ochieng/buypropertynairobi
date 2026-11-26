<?php

namespace App\Services;

use App\Models\BudgetRange;
use App\Models\Property;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class PropertyMegaMenuService
{
    public const CACHE_KEY = 'property_mega_menu_data_v1';

    public const CACHE_KEY_STATUS = 'property_mega_menu_status_v1';

    public const CACHE_TTL = 300;

    /** Call from Property::saved / deleted / restored (see notes). */
    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
        Cache::forget(self::CACHE_KEY_STATUS);
    }

    /** Keys must match app.blade: $megaMenu['sale'] / $megaMenu['rent'] */
    public function data(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, fn () => [
            'sale' => $this->buildMenu('sale'),
            'rent' => $this->buildMenu('rent'),
        ]);
    }

    /** Status → category menu used by the "Properties" dropdown. */
    public function statusMenu(): array
    {
        return Cache::remember(self::CACHE_KEY_STATUS, self::CACHE_TTL, function () {
            $statuses = [
                'available' => 'Available',
                'off_plan' => 'Off-Plan',
                'under_construction' => 'Under Construction',
                'sold' => 'Sold',
                'rented' => 'Rented',
            ];

            $rows = Property::query()
                ->published()
                ->whereNotNull('status')
                ->selectRaw('status, category, COUNT(*) as c')
                ->groupBy('status', 'category')
                ->get()
                ->groupBy('status');

            $result = [];

            foreach ($statuses as $key => $label) {
                $group = $rows->get($key, collect());

                $categories = $group
                    ->filter(fn ($r) => filled($r->category))
                    ->map(fn ($r) => [
                        'slug' => $r->category,
                        'name' => Str::headline($r->category),
                        'count' => (int) $r->c,
                    ])
                    ->sortBy('name')
                    ->values()
                    ->all();

                $total = (int) $group->sum('c');

                $result[$key] = [
                    'label' => $label,
                    'count' => $total,
                    'categories' => $categories,
                    'has_data' => $total > 0,
                ];
            }

            return $result;
        });
    }

    private function buildMenu(string $purpose): array
    {
        $purposeValues = $purpose === 'sale' ? ['sale', 'both'] : ['rent', 'both'];

        $base = fn () => Property::query()->published()->whereIn('purpose', $purposeValues);

        // ── Locations ──
        $locations = $base()
            ->whereNotNull('location')
            ->selectRaw('location, COUNT(*) as c')
            ->groupBy('location')
            ->orderBy('location')
            ->pluck('c', 'location')
            ->map(fn ($c) => (int) $c)
            ->toArray();

        // ── Uses ──
        $uses = $base()
            ->whereNotNull('use_id')
            ->selectRaw('use_id, COUNT(*) as c')
            ->groupBy('use_id')
            ->with('useCategory')
            ->get()
            ->filter(fn ($r) => $r->useCategory)
            ->map(fn ($r) => [
                'slug' => $r->useCategory->slug,
                'name' => $r->useCategory->name,
                'count' => (int) $r->c,
                'sort' => $r->useCategory->sort_order ?? 999,
            ])
            ->sortBy('sort')
            ->values()
            ->all();

        // ── Categories, with "N+ bedrooms" flyout ──
        $categoryRows = $base()
            ->whereNotNull('category')
            ->selectRaw('category, bedrooms, COUNT(*) as c')
            ->groupBy('category', 'bedrooms')
            ->get()
            ->groupBy('category');

        $categories = $categoryRows
            ->map(function ($rows, $category) {
                $total = (int) $rows->sum('c');

                // bedroom filter is "minimum bedrooms", so counts are cumulative
                $bedrooms = [];
                foreach ([1, 2, 3, 4] as $n) {
                    $count = (int) $rows->filter(fn ($r) => (int) $r->bedrooms >= $n)->sum('c');
                    if ($count > 0) {
                        $bedrooms[] = [
                            'value' => $n,
                            'label' => $n . '+ Bedroom' . ($n > 1 ? 's' : ''),
                            'count' => $count,
                        ];
                    }
                }

                return [
                    'slug' => $category,
                    'name' => Str::headline($category),
                    'count' => $total,
                    'bedrooms' => $bedrooms,
                    'flyout' => count($bedrooms) > 1,
                ];
            })
            ->sortBy('name')
            ->values()
            ->all();

        // ── Budgets ──
        $budgets = [];
        foreach (BudgetRange::active()->forPurpose($purpose)->orderBy('sort_order')->get() as $range) {
            $q = $base()->whereNotNull('price_kes');
            if ($range->min_value !== null) {
                $q->where('price_kes', '>=', $range->min_value);
            }
            if ($range->max_value !== null) {
                $q->where('price_kes', '<', $range->max_value);
            }
            $count = $q->count();

            if ($count > 0) {
                $budgets[$range->id] = [
                    'label' => $range->label,
                    'count' => $count,
                    'min' => $range->min_value,
                    'max' => $range->max_value,
                ];
            }
        }

        // ── Property types ──
        $types = $base()
            ->whereNotNull('property_type')
            ->selectRaw('property_type, COUNT(*) as c')
            ->groupBy('property_type')
            ->orderBy('property_type')
            ->get()
            ->map(fn ($r) => [
                'slug' => $r->property_type,
                'name' => Str::headline($r->property_type),
                'count' => (int) $r->c,
            ])
            ->all();

        return [
            'locations' => $locations,
            'uses' => $uses,
            'categories' => $categories,
            'budgets' => $budgets,
            'types' => $types,
            'has_data' => ! empty($locations) || ! empty($categories) || ! empty($types),
        ];
    }
}
