<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('job_listings'))
            return;

        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('department')->nullable();
            $table->string('location')->nullable();
            $table->string('employment_type')->nullable();
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->longText('requirements')->nullable();
            $table->string('salary_range')->nullable();
            $table->string('contact_email')->nullable();
            $table->date('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'expires_at']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};