<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('unit_types')) return;

        Schema::create('unit_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->enum('category', ['residential', 'commercial'])->default('residential');
            $table->string('name');
            $table->decimal('size_min_sqm', 8, 2)->nullable();
            $table->decimal('size_max_sqm', 8, 2)->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('unit_types'); }
};