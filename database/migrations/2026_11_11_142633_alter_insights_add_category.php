<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('insights', 'category')) {
            Schema::table('insights', function (Blueprint $table) {
                $table->enum('category', ['area_guide', 'market'])
                    ->default('area_guide')
                    ->after('slug');
            });
        }
    }
    public function down(): void
    {
        Schema::table('insights', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};