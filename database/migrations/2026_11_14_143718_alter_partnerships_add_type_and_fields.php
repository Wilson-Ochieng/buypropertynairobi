<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('partnerships', 'type')) {
            Schema::table('partnerships', function (Blueprint $table) {
                $table->enum('type', ['land', 'agency', 'freelancer'])
                    ->default('land')
                    ->after('title');

                $table->string('subtitle')->nullable()->after('type');
                $table->string('cta_label')->nullable()->after('description');
                $table->string('cta_url')->nullable()->after('cta_label');
                $table->text('benefits')->nullable()->after('cta_url');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('partnerships', 'type')) {
            Schema::table('partnerships', function (Blueprint $table) {
                $table->dropColumn(['type', 'subtitle', 'cta_label', 'cta_url', 'benefits']);
            });
        }
    }
};