<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');                       // human title: "3-Bedroom Apartment in Westlands"
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // Classification
            $table->foreignId('country_id')->constrained();
            $table->foreignId('use_id')->nullable()->constrained('uses');
            $table->enum('category', ['residential', 'commercial', 'land'])->default('residential');
            $table->enum('purpose', ['sale', 'rent', 'both'])->default('sale');
            $table->enum('status', ['available', 'sold', 'rented', 'off_plan', 'under_construction'])->default('available');

            // Property kind (was unit_type_lookup)
            $table->string('property_type')->nullable();   // 'apartment', 'villa', 'townhouse', 'plot', 'office'
            $table->unsignedSmallInteger('bedrooms')->nullable();
            $table->unsignedSmallInteger('bathrooms')->nullable();
            $table->unsignedSmallInteger('floors')->nullable();

            // Size & price
            $table->decimal('size_sqm', 10, 2)->nullable();
            $table->decimal('price_kes', 15, 2)->nullable();
            $table->boolean('price_negotiable')->default(false);

            // Location
            $table->string('location')->nullable();        // 'Westlands, Nairobi'
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Features (JSON array)
            $table->json('features')->nullable();

            // Media
            $table->string('cover_image')->nullable();

            // Contact
            $table->string('contact_email')->nullable();
            $table->string('whatsapp_number')->nullable();

            // Meta
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->integer('sort_order')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'is_published']);
            $table->index(['country_id', 'location']);
            $table->index(['category', 'purpose']);
        });

        Schema::create('property_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->string('caption')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('property_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['youtube', 'vimeo', 'mp4'])->default('youtube');
            $table->string('title')->nullable();
            $table->string('video_url')->nullable();
            $table->string('video_id')->nullable();
            $table->string('video_path')->nullable();
            $table->string('thumbnail_path')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('property_highlights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->string('label');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_highlights');
        Schema::dropIfExists('property_videos');
        Schema::dropIfExists('property_images');
        Schema::dropIfExists('properties');
    }
};