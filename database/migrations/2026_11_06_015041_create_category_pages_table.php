<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('category_pages'))
            return;

        Schema::create('category_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();           // "kilimani", "10m-20m", "family-homes"
            $table->enum('purpose', ['buy', 'rent']);   // which section
            $table->enum('category_type', ['location', 'use', 'style', 'budget', 'type']);
            $table->string('filter_value');              // raw value used to filter (e.g. "Kilimani", "10000000-20000000", "family")
            $table->string('h1');                        // "Properties for sale in Kilimani"
            $table->longText('description')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->index(['purpose', 'category_type']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('category_pages');
    }
};