<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('kenya_division_pages'))
            return;

        Schema::create('kenya_division_pages', function (Blueprint $table) {
            $table->id();
            $table->longText('intro_text')->nullable();
            $table->string('hero_image')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('kenya_division_pages');
    }
};