<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('projects')) return;

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('region', ['kenya', 'china'])->default('china');
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->longText('description')->nullable();
            $table->string('investment')->nullable();
            $table->string('land_area')->nullable();
            $table->string('construction_area')->nullable();
            $table->string('unit_count')->nullable();
            $table->string('distance_subway')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('contact_email')->nullable();
            $table->string('cover_image')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->index(['region', 'is_featured']);
        });
    }
    public function down(): void { Schema::dropIfExists('projects'); }
};