<?php
namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Insight;
use App\Models\Post;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function areaGuides()
    {
        $guides = Insight::published()->areaGuides()->orderBy('sort_order')->get();
        return view('media.area-guides', compact('guides'));
    }

    public function areaGuideShow(Insight $insight)
    {
        abort_unless($insight->category === 'area_guide' && $insight->is_published, 404);
        $relatedProjects = \App\Models\Project::where('location', $insight->location)
            ->with(['country', 'highlights', 'videos'])->orderBy('sort_order')->get();
        return view('media.area-guide-show', compact('insight', 'relatedProjects'));
    }

    public function blog(Request $request)
    {
        $query = Post::published()->orderByDesc('published_at');

        if ($request->query('category')) {
            $query->where('category', $request->query('category'));
        }

        $posts = $query->paginate(9)->withQueryString();
        $categories = Post::published()
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();

        return view('media.blog', compact('posts', 'categories'));
    }
    public function blogShow(Post $post)
    {
        abort_unless($post->is_published, 404);

        $related = Post::published()
            ->where('id', '!=', $post->id)
            ->when($post->category, fn($q) => $q->where('category', $post->category))
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        // Fallback: if not enough in same category, pull recent from anywhere
        if ($related->count() < 3) {
            $extra = Post::published()
                ->where('id', '!=', $post->id)
                ->whereNotIn('id', $related->pluck('id'))
                ->orderByDesc('published_at')
                ->limit(3 - $related->count())
                ->get();
            $related = $related->merge($extra);
        }

        return view('media.blog-show', compact('post', 'related'));
    }

    public function faqs()
    {
        $faqs = Faq::published()->orderBy('sort_order')->get()->groupBy('category');
        return view('media.faqs', compact('faqs'));
    }

    public function marketInsights()
    {
        $insights = Insight::published()->marketInsights()->orderBy('sort_order')->get();
        return view('media.market-insights', compact('insights'));
    }

    public function marketInsightShow(Insight $insight)
    {
        abort_unless($insight->category === 'market' && $insight->is_published, 404);
        $related = Insight::published()->marketInsights()->where('id', '!=', $insight->id)->limit(3)->get();
        return view('media.market-insight-show', compact('insight', 'related'));
    }
}