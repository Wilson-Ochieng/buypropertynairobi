<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('unit_types', function (Blueprint $table) {
            if (!Schema::hasColumn('unit_types', 'price_kes')) {
                $table->decimal('price_kes', 14, 2)->nullable()->after('category');
            }
            if (!Schema::hasColumn('unit_types', 'price_negotiable')) {
                $table->boolean('price_negotiable')->default(false)->after('price_kes');
            }
            if (!Schema::hasColumn('unit_types', 'bedrooms')) {
                $table->unsignedTinyInteger('bedrooms')->nullable()->after('name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('unit_types', function (Blueprint $table) {
            $table->dropColumn(['price_kes', 'price_negotiable', 'bedrooms']);
        });
    }
};