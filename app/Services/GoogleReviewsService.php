<?php
namespace App\Services;

use App\Models\Testimonial;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleReviewsService
{
    public function sync(): array
    {
        $apiKey = config('services.google_places.api_key');
        $placeId = config('services.google_places.place_id');

        if (!$apiKey || !$placeId) {
            return ['error' => 'Google Places API key or Place ID not configured.'];
        }

        // Fetch place details + reviews
        $response = Http::timeout(15)->get('https://maps.googleapis.com/maps/api/place/details/json', [
            'place_id' => $placeId,
            'fields' => 'reviews,rating,user_ratings_total',
            'key' => $apiKey,
        ]);

        if (!$response->ok() || $response->json('status') !== 'OK') {
            $err = $response->json('error_message') ?? $response->json('status') ?? 'Unknown error';
            Log::warning('Google Reviews sync failed: ' . $err);
            return ['error' => $err];
        }

        $reviews = $response->json('result.reviews', []);
        $created = 0;
        $updated = 0;

        foreach ($reviews as $review) {
            $googleId = $review['time'] . '_' . md5($review['author_name']);

            $data = [
                'source' => 'google',
                'author_name' => $review['author_name'] ?? 'Google User',
                'author_role' => 'Google Review',
                'quote' => $review['text'] ?? '',
                'rating' => (int) ($review['rating'] ?? 5),
                'google_review_id' => $googleId,
                'google_author_url' => $review['author_url'] ?? null,
                'google_profile_photo_url' => $review['profile_photo_url'] ?? null,
                'google_review_time' => isset($review['time']) ? now()->setTimestamp($review['time']) : null,
                'is_published' => true,
            ];

            $existing = Testimonial::where('google_review_id', $googleId)->first();

            if ($existing) {
                $existing->update($data);
                $updated++;
            } else {
                Testimonial::create($data);
                $created++;
            }
        }

        return [
            'created' => $created,
            'updated' => $updated,
            'total' => count($reviews),
        ];
    }
}