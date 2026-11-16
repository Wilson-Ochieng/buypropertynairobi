<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('subsidiaries')) return;

        Schema::create('subsidiaries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('qualification')->nullable();
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('subsidiaries'); }
};