<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('contact_submissions'))
            return;

        Schema::create('contact_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->text('message');
            $table->enum('source', ['bay', 'island', 'partnership', 'general'])->default('general');
            $table->timestamps();
            $table->index('source');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('contact_submissions');
    }
};