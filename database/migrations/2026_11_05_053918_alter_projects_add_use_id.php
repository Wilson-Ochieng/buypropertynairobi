<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('projects', 'use_id')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->foreignId('use_id')->nullable()->after('country_id')
                    ->constrained('uses')->nullOnDelete();
            });
        }
    }
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['use_id']);
            $table->dropColumn('use_id');
        });
    }
};