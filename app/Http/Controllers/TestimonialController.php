<?php
namespace App\Http\Controllers;

use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index()
    {
        $featured = Testimonial::published()->featured()->orderBy('sort_order')->get();

        $manual = Testimonial::published()->manual()
            ->where('is_featured', false)
            ->orderBy('sort_order')
            ->get();

        $google = Testimonial::published()->google()
            ->where('is_featured', false)
            ->orderByDesc('google_review_time')
            ->limit(30)
            ->get();

        $stats = [
            'total' => Testimonial::published()->count(),
            'average' => round(Testimonial::published()->avg('rating') ?? 0, 1),
            'five_star' => Testimonial::published()->where('rating', 5)->count(),
            'google_url' => 'https://search.google.com/local/reviews?placeid=' . config('services.google_places.place_id'),
        ];

        return view('testimonials', compact('featured', 'manual', 'google', 'stats'));
    }
}