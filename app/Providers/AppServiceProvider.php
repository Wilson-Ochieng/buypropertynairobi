<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Project;
use App\Models\UnitType;
use App\Models\UseCategory;
use App\Models\Style;
use App\Models\BudgetRange;
use App\Services\MegaMenuService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        foreach ([Project::class, UnitType::class, UseCategory::class, Style::class, BudgetRange::class] as $model) {
            $model::saved(fn() => MegaMenuService::flush());
            $model::deleted(fn() => MegaMenuService::flush());
        }
    }
}
