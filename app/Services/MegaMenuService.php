<?php

namespace App\Services;

use App\Models\BudgetRange;
use App\Models\Project;
use App\Models\UnitType;
use Illuminate\Support\Facades\Cache;

class MegaMenuService
{
    /** Bumped to v4 because the styles data shape changed. */
    public const CACHE_KEY = 'mega_menu_data_v4';

    public const CACHE_KEY_STATUS = 'mega_menu_projects_status_v2';

    public const CACHE_TTL = 300;

    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
        Cache::forget(self::CACHE_KEY_STATUS);
        Cache::forget('mega_menu_data_v3'); // old key, harmless cleanup
    }

    public function data(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return [
                'buy' => $this->buildMenu('sale'),
                'rent' => $this->buildMenu('rent'),
            ];
        });
    }

    public function projectStatusMenu(): array
    {
        return Cache::remember(self::CACHE_KEY_STATUS, self::CACHE_TTL, function () {
            $statuses = [
                'ongoing' => ['label' => 'Ongoing', 'sort' => 1],
                'completed' => ['label' => 'Completed', 'sort' => 2],
                'off_plan' => ['label' => 'Off-Plan', 'sort' => 3],
            ];

            $result = [];

            foreach ($statuses as $key => $meta) {
                $countries = Project::query()
                    ->where('status', $key)
                    ->with('country')
                    ->selectRaw('country_id, COUNT(*) as c')
                    ->groupBy('country_id')
                    ->get()
                    ->map(fn($p) => [
                        'slug' => $p->country?->slug,
                        'name' => $p->country?->name,
                        'count' => $p->c,
                    ])
                    ->filter(fn($c) => $c['slug'] !== null)
                    ->sortBy('name')
                    ->values()
                    ->toArray();

                $total = array_sum(array_column($countries, 'count'));

                $result[$key] = [
                    'label' => $meta['label'],
                    'count' => $total,
                    'countries' => $countries,
                    'has_data' => $total > 0,
                ];
            }

            return $result;
        });
    }

    private function bedroomLabel(int $n): string
    {
        return match (true) {
            $n === 0 => 'Studio',
            $n === 1 => '1 Bedroom',
            default => $n . ' Bedrooms',
        };
    }

    private function buildMenu(string $purpose): array
    {
        $purposeValues = $purpose === 'sale' ? ['sale', 'both'] : ['rent', 'both'];

        // ── Locations ──
        $locations = UnitType::query()
            ->whereIn('purpose', $purposeValues)
            ->whereHas('project', fn($q) => $q->whereNotNull('location'))
            ->join('projects', 'unit_types.project_id', '=', 'projects.id')
            ->selectRaw('projects.location as location, COUNT(unit_types.id) as c')
            ->groupBy('projects.location')
            ->orderBy('projects.location')
            ->get()
            ->pluck('c', 'location')
            ->toArray();

        // ── Uses ──
        $uses = UnitType::query()
            ->whereIn('purpose', $purposeValues)
            ->whereHas('project.useCategory')
            ->join('projects', 'unit_types.project_id', '=', 'projects.id')
            ->join('uses', 'projects.use_id', '=', 'uses.id')
            ->selectRaw('uses.slug as slug, uses.name as name, COUNT(unit_types.id) as c')
            ->groupBy('uses.slug', 'uses.name')
            ->orderBy('uses.sort_order')
            ->get()
            ->mapWithKeys(fn($u) => [
                $u->slug => ['name' => $u->name, 'count' => $u->c],
            ])
            ->toArray();

        // ── Styles with bedroom breakdown ──
        $styleRows = UnitType::query()
            ->whereIn('purpose', $purposeValues)
            ->whereNotNull('style_id')
            ->whereNotNull('bedrooms')
            ->selectRaw('style_id, bedrooms, COUNT(*) as c')
            ->groupBy('style_id', 'bedrooms')
            ->with('style')
            ->get();

        $styles = $styleRows
            ->groupBy('style_id')
            ->map(function ($rows) {
                $style = $rows->first()->style;
                if (!$style) {
                    return null;
                }

                // Bucket bedrooms: 0..3 as-is, 4 and above together
                $buckets = [];
                foreach ($rows as $r) {
                    $key = min((int) $r->bedrooms, 4);
                    $buckets[$key] = ($buckets[$key] ?? 0) + (int) $r->c;
                }
                ksort($buckets);

                $bedrooms = [];
                foreach ($buckets as $value => $count) {
                    $bedrooms[] = [
                        'value' => $value,
                        'segment' => $value === 0 ? 'studio' : $value . '-bedroom',
                        'label' => match ($value) {
                            0 => 'Studio',
                            1 => '1 Bedroom',
                            4 => '4+ Bedrooms',
                            default => $value . ' Bedrooms',
                        },
                        'count' => $count,
                    ];
                }

                return [
                    'slug' => $style->slug,
                    'name' => $style->name,
                    'count' => array_sum($buckets),
                    'bedrooms' => $bedrooms,
                    'flyout' => count($bedrooms) > 1,
                    'sort' => $style->sort_order ?? 999,
                ];
            })
            ->filter()
            ->sortBy('sort')
            ->values()
            ->toArray();

        // ── Budgets ──
        $budgets = [];
        foreach (BudgetRange::active()->forPurpose($purpose)->orderBy('sort_order')->get() as $range) {
            $q = UnitType::whereIn('purpose', $purposeValues)->whereNotNull('price_kes');
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
                    'slug' => ($range->min_value ?? '') . '-' . ($range->max_value ?? ''),
                ];
            }
        }

        // ── Types ──
        $types = UnitType::query()
            ->whereIn('purpose', $purposeValues)
            ->whereNotNull('unit_type_lookup_id')
            ->selectRaw('unit_type_lookup_id, COUNT(*) as c')
            ->groupBy('unit_type_lookup_id')
            ->with('unitTypeLookup')
            ->get()
            ->map(function ($row) {
                $lookup = $row->unitTypeLookup;
                if (!$lookup) {
                    return null;
                }
                return [
                    'slug' => $lookup->slug,
                    'name' => $lookup->name,
                    'count' => $row->c,
                    'sort' => $lookup->sort_order ?? 999,
                ];
            })
            ->filter()
            ->sortBy('sort')
            ->values()
            ->toArray();

        $hasData = !empty($locations) || !empty($styles) || !empty($types);

        return [
            'locations' => $locations,
            'uses' => $uses,
            'styles' => $styles,
            'budgets' => $budgets,
            'types' => $types,
            'has_data' => $hasData,
        ];
    }
}