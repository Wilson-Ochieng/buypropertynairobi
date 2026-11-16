<?php
namespace App\Console\Commands;

use App\Services\GoogleReviewsService;
use Illuminate\Console\Command;

class SyncGoogleReviews extends Command
{
    protected $signature = 'reviews:sync';
    protected $description = 'Sync testimonials from Google Reviews';

    public function handle(GoogleReviewsService $service): int
    {
        $this->info('Syncing Google Reviews...');

        $result = $service->sync();

        if (isset($result['error'])) {
            $this->error('Sync failed: ' . $result['error']);
            return self::FAILURE;
        }

        $this->info("Created: {$result['created']}, Updated: {$result['updated']}, Total fetched: {$result['total']}");
        return self::SUCCESS;
    }
}