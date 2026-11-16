<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('unit_type_images'))
            return;

        Schema::create('unit_type_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_type_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('unit_type_id');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('unit_type_images');
    }
};