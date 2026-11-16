<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('unit_types', 'features')) {
            Schema::table('unit_types', function (Blueprint $table) {
                $table->json('features')->nullable()->after('price_negotiable');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('unit_types', 'features')) {
            Schema::table('unit_types', function (Blueprint $table) {
                $table->dropColumn('features');
            });
        }
    }
};