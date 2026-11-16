<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('contact_submissions', 'status')) {
            Schema::table('contact_submissions', function (Blueprint $table) {
                $table->enum('status', ['new', 'contacted', 'closed'])
                    ->default('new')
                    ->after('source');

                $table->timestamp('contacted_at')->nullable()->after('status');
                $table->text('admin_notes')->nullable()->after('contacted_at');
            });
        }
    }
    public function down(): void
    {
        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->dropColumn(['status', 'contacted_at', 'admin_notes']);
        });
    }
};