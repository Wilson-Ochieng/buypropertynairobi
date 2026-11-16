<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('group_infos', 'careers_intro')) {
            Schema::table('group_infos', function (Blueprint $table) {
                $table->text('careers_intro')->nullable()->after('intro_text');
                $table->string('careers_advert_image')->nullable()->after('careers_intro');
                $table->string('careers_advert_url')->nullable()->after('careers_advert_image');
                $table->string('careers_cta_email')->nullable()->after('careers_advert_url');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('group_infos', 'careers_intro')) {
            Schema::table('group_infos', function (Blueprint $table) {
                $table->dropColumn([
                    'careers_intro',
                    'careers_advert_image',
                    'careers_advert_url',
                    'careers_cta_email',
                ]);
            });
        }
    }
};