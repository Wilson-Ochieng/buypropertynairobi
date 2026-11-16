<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('testimonials'))
            return;

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->enum('source', ['manual', 'google'])->default('manual');

            // Person
            $table->string('author_name');
            $table->string('author_role')->nullable();       // "Homeowner, Kilimani"
            $table->string('author_photo')->nullable();

            // Content
            $table->text('quote');                            // testimonial body
            $table->unsignedTinyInteger('rating')->nullable(); // 1–5
            $table->string('location')->nullable();           // project location link
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();

            // Google-specific
            $table->string('google_review_id')->nullable()->unique();
            $table->string('google_author_url')->nullable();
            $table->string('google_profile_photo_url')->nullable();
            $table->timestamp('google_review_time')->nullable();

            // Meta
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['source', 'is_published']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};