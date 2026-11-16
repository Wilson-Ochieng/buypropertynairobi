<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('unit_type_videos'))
            return;

        Schema::create('unit_type_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_type_id')->constrained()->cascadeOnDelete();

            $table->enum('type', ['youtube', 'vimeo', 'mp4'])->default('youtube');
            $table->string('title')->nullable();

            $table->string('video_url')->nullable();
            $table->string('video_id')->nullable();
            $table->string('video_path')->nullable();
            $table->string('thumbnail_path')->nullable();

            $table->integer('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->index(['unit_type_id', 'is_published']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('unit_type_videos');
    }
};