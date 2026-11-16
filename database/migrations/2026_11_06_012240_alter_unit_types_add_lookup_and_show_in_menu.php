<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('unit_types', function (Blueprint $table) {
            if (!Schema::hasColumn('unit_types', 'unit_type_lookup_id')) {
                $table->foreignId('unit_type_lookup_id')->nullable()->after('project_id')
                    ->constrained('unit_type_lookups')->nullOnDelete();
            }
        });

        // Ensure styles no longer need show_in_type — Type now comes from unit_type_lookups
        // (Keep the column but stop relying on it; safer than dropping.)
    }
    public function down(): void
    {
        Schema::table('unit_types', function (Blueprint $table) {
            $table->dropForeign(['unit_type_lookup_id']);
            $table->dropColumn('unit_type_lookup_id');
        });
    }
};