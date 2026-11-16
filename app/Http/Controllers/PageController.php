<?php
namespace App\Http\Controllers;

use App\Models\GroupInfo;
use App\Models\Partnership;
use App\Models\SiteContact;
use App\Models\Subsidiary;

class PageController extends Controller
{
    public function about()
    {
        $group = GroupInfo::current();
        return view('pages.about', compact('group'));
    }

    public function subsidiaries()
    {
        $subsidiaries = Subsidiary::orderBy('sort_order')->get();
        return view('pages.subsidiaries', compact('subsidiaries'));
    }

    public function cooperate()
    {
        $land = Partnership::active()->ofType('land')->first();
        $agency = Partnership::active()->ofType('agency')->first();
        $freelancer = Partnership::active()->ofType('freelancer')->first();
        $chairman = SiteContact::where('role', 'like', '%Chairman%')->first();
        $primary = SiteContact::primary();

        return view('pages.cooperate', compact(
            'land',
            'agency',
            'freelancer',
            'chairman',
            'primary'
        ));
    }

}