<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\KenyaController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\InsightController;
use App\Http\Controllers\CategoryPageController;
use App\Http\Controllers\VideoTourController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\PropertyController;



use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Static pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/subsidiaries', [PageController::class, 'subsidiaries'])->name('subsidiaries');


Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');

Route::get('/projects/{purpose}/{slug}', [CategoryPageController::class, 'show'])
    ->whereIn('purpose', ['buy', 'rent'])
    ->where('slug', '.*')
    ->name('category-pages.show');

Route::get('/units/{id}', function ($id) {
    $unit = \App\Models\UnitType::find($id);
    if (!$unit)
        abort(404);
    return redirect()->route('units.show', $unit, 301);
})->where('id', '[0-9]+');

Route::get('/units/{unit:slug}', [UnitController::class, 'show'])->name('units.show');

Route::get('/projects/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');
// Allow multi-segment slugs (e.g. apartment/2-bedroom)
Route::get('/projects/{purpose}/{slug}', [CategoryPageController::class, 'show'])
    ->whereIn('purpose', ['buy', 'rent'])
    ->where('slug', '.*')
    ->name('category-pages.show');

// China portfolio
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::redirect('/china-portfolio', '/projects?country=china');

// Kenya division
Route::get('/kenya', [KenyaController::class, 'index'])->name('kenya');
Route::get('/kenya/longines-bay', [KenyaController::class, 'bay'])->name('kenya.bay');
Route::get('/kenya/longines-island', [KenyaController::class, 'island'])->name('kenya.island');

// Cooperate / Land partnership
Route::get('/cooperate', [PageController::class, 'cooperate'])->name('cooperate');

// Contact + enquiry
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/enquiry', [ContactController::class, 'store'])->name('enquiry.store');
Route::get('/insights', [InsightController::class, 'index'])->name('insights.index');
Route::get('/insights/{insight:slug}', [InsightController::class, 'show'])->name('insights.show');

Route::get('/media/video-tours', [VideoTourController::class, 'index'])->name('media.video-tours');

// About
Route::get('/about', [AboutController::class, 'company'])->name('about');
Route::get('/about/board', [AboutController::class, 'board'])->name('about.board');
Route::get('/about/management', [AboutController::class, 'management'])->name('about.management');
Route::get('/about/careers', [AboutController::class, 'careers'])->name('about.careers');

// Media
Route::get('/media/area-guides', [MediaController::class, 'areaGuides'])->name('media.area-guides');
Route::get('/media/area-guides/{insight:slug}', [MediaController::class, 'areaGuideShow'])->name('media.area-guides.show');
Route::get('/media/blog', [MediaController::class, 'blog'])->name('media.blog');
Route::get('/media/blog/{post:slug}', [MediaController::class, 'blogShow'])->name('media.blog.show');
Route::get('/media/faqs', [MediaController::class, 'faqs'])->name('media.faqs');
Route::get('/media/market-insights', [MediaController::class, 'marketInsights'])->name('media.market-insights');
Route::get('/media/market-insights/{insight:slug}', [MediaController::class, 'marketInsightShow'])->name('media.market-insights.show');
Route::get('/testimonials', [TestimonialController::class, 'index'])
    ->name('testimonials');
Route::get('/thank-you/{ref}', function ($ref) {
    $submission = \App\Models\ContactSubmission::find($ref);
    return view('pages.enquiry-thanks', compact('submission'));
})->name('enquiry.thanks');
Route::get('/careers/apply', [JobApplicationController::class, 'create'])->name('careers.apply');
Route::post('/careers/apply', [JobApplicationController::class, 'store'])->name('careers.apply.store');
Route::get('/careers/apply/thanks', [JobApplicationController::class, 'thanks'])->name('careers.apply.thanks');
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{property:slug}', [PropertyController::class, 'show'])->name('properties.show');

// Optional: legacy redirects from /projects
Route::get('/projects', fn () => redirect()->route('properties.index'))->name('projects.index');
Route::get('/projects/{slug}', fn ($slug) => redirect("/properties/{$slug}"));