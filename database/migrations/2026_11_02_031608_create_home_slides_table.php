<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('home_slides'))
            return;

        Schema::create('home_slides', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['image', 'youtube', 'vimeo'])->default('image');
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('cta_label')->nullable();
            $table->string('cta_url')->nullable();

            // image
            $table->string('image_path')->nullable();

            // video
            $table->string('video_url')->nullable();
            $table->string('video_id')->nullable();
            $table->string('poster_path')->nullable();

            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_slides');
    }
};