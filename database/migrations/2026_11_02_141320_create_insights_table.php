<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('insights')) return;

        Schema::create('insights', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('location');               
            $table->string('summary', 500)->nullable();
            $table->longText('body')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->boolean('is_published')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('location');
        });
    }
    public function down(): void { Schema::dropIfExists('insights'); }
};