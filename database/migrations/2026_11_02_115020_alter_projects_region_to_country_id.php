<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // 1. Add country_id nullable
        if (!Schema::hasColumn('projects', 'country_id')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->foreignId('country_id')->nullable()->after('id')
                    ->constrained('countries')->nullOnDelete();
            });
        }

        // 2. Add location column (was 'city' before — keep for back-compat,
        //    but use 'location' as the primary display field)
        if (!Schema::hasColumn('projects', 'location')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->string('location')->nullable()->after('country_id');
            });
        }

        // 3. Drop region column
        if (Schema::hasColumn('projects', 'region')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropColumn('region');
            });
        }
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (Schema::hasColumn('projects', 'country_id')) {
                $table->dropForeign(['country_id']);
                $table->dropColumn('country_id');
            }
            if (Schema::hasColumn('projects', 'location')) {
                $table->dropColumn('location');
            }
            $table->enum('region', ['kenya', 'china'])->default('china');
        });
    }
};