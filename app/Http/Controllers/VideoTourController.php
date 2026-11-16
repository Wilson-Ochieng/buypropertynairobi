<?php
namespace App\Http\Controllers;

use App\Models\ProjectVideo;

class VideoTourController extends Controller
{
    public function index()
    {
        $videos = ProjectVideo::published()
            ->with('project.country')
            ->orderBy('sort_order')
            ->get()
            ->groupBy(fn($v) => $v->project?->name ?? 'Other');

        return view('media.video-tours', compact('videos'));
    }
}