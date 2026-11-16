<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Uses (Family Homes, Investments, etc.)
        if (!Schema::hasTable('uses')) {
            Schema::create('uses', function (Blueprint $table) {
                $table->id();
                $table->string('name');            // "Family Homes"
                $table->string('slug')->unique();  // "family"
                $table->integer('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // Styles (duplex, simplex, triplex, penthouse, ...)
        if (!Schema::hasTable('styles')) {
            Schema::create('styles', function (Blueprint $table) {
                $table->id();
                $table->string('name');            // "Duplex"
                $table->string('slug')->unique();  // "duplex"
                $table->boolean('show_in_type')->default(false);  // true for apartment/villa/etc.
                $table->integer('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // Budget ranges — separate by purpose
        if (!Schema::hasTable('budget_ranges')) {
            Schema::create('budget_ranges', function (Blueprint $table) {
                $table->id();
                $table->enum('purpose', ['sale', 'rent']);
                $table->string('label');                   // "KES 10M – 20M"
                $table->decimal('min_value', 14, 2)->nullable();
                $table->decimal('max_value', 14, 2)->nullable();
                $table->integer('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('budget_ranges');
        Schema::dropIfExists('styles');
        Schema::dropIfExists('uses');
    }
};