<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('unit_type_lookups'))
            return;

        Schema::create('unit_type_lookups', function (Blueprint $table) {
            $table->id();
            $table->string('name');            // "Apartment"
            $table->string('slug')->unique();  // "apartment"
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('unit_type_lookups');
    }
};