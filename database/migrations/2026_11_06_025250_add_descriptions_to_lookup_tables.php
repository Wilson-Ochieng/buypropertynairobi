<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // uses
        if (!Schema::hasColumn('uses', 'description')) {
            Schema::table('uses', function (Blueprint $table) {
                $table->text('description')->nullable()->after('slug');
            });
        }

        // styles
        if (!Schema::hasColumn('styles', 'description')) {
            Schema::table('styles', function (Blueprint $table) {
                $table->text('description')->nullable()->after('slug');
            });
        }

        // budget_ranges
        if (!Schema::hasColumn('budget_ranges', 'description')) {
            Schema::table('budget_ranges', function (Blueprint $table) {
                $table->text('description')->nullable()->after('label');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('uses', 'description')) {
            Schema::table('uses', fn(Blueprint $t) => $t->dropColumn('description'));
        }
        if (Schema::hasColumn('styles', 'description')) {
            Schema::table('styles', fn(Blueprint $t) => $t->dropColumn('description'));
        }
        if (Schema::hasColumn('budget_ranges', 'description')) {
            Schema::table('budget_ranges', fn(Blueprint $t) => $t->dropColumn('description'));
        }
    }
};