<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('unit_types', function (Blueprint $table) {
            if (!Schema::hasColumn('unit_types', 'purpose')) {
                $table->enum('purpose', ['sale', 'rent', 'both'])->default('sale')->after('category');
            }
            if (!Schema::hasColumn('unit_types', 'style_id')) {
                $table->foreignId('style_id')->nullable()->after('purpose')
                    ->constrained('styles')->nullOnDelete();
            }
        });
    }
    public function down(): void
    {
        Schema::table('unit_types', function (Blueprint $table) {
            $table->dropForeign(['style_id']);
            $table->dropColumn(['purpose', 'style_id']);
        });
    }
};