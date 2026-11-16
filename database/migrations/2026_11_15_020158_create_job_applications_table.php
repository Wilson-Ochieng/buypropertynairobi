<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('job_applications'))
            return;

        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_listing_id')->nullable()->constrained()->nullOnDelete();

            // Applicant
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('current_location')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->text('cover_letter');

            // File
            $table->string('cv_path')->nullable();
            $table->string('cv_original_name')->nullable();

            // Status
            $table->enum('status', ['new', 'reviewing', 'shortlisted', 'rejected', 'hired'])
                ->default('new');
            $table->text('admin_notes')->nullable();

            $table->timestamps();

            $table->index('status');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};