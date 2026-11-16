<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('category_pages', 'bedrooms')) {
            Schema::table('category_pages', function (Blueprint $table) {
                $table->unsignedTinyInteger('bedrooms')->nullable()->after('filter_value');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('category_pages', 'bedrooms')) {
            Schema::table('category_pages', function (Blueprint $table) {
                $table->dropColumn('bedrooms');
            });
        }
    }
};