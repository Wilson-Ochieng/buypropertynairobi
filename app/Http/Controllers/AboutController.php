<?php
namespace App\Http\Controllers;

use App\Models\GroupInfo;
use App\Models\TeamMember;

class AboutController extends Controller
{
    public function company()
    {
        $group = GroupInfo::current();
        return view('pages.about', compact('group'));
    }

    public function board()
    {
        $members = TeamMember::active()->board()->orderBy('sort_order')->get();
        return view('about.board', compact('members'));
    }

    public function management()
    {
        $members = TeamMember::active()->management()->orderBy('sort_order')->get();
        return view('about.management', compact('members'));
    }

    public function careers()
    {
        $group = GroupInfo::current();
        return view('about.careers', compact('group'));
    }
}