<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('unit_types', 'slug')) {
            Schema::table('unit_types', function (Blueprint $table) {
                $table->string('slug')->nullable()->after('name');
                $table->index('slug');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('unit_types', 'slug')) {
            Schema::table('unit_types', function (Blueprint $table) {
                $table->dropIndex(['slug']);
                $table->dropColumn('slug');
            });
        }
    }
};