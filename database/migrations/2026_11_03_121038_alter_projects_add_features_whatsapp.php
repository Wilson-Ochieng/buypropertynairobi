<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (!Schema::hasColumn('projects', 'features')) {
                $table->json('features')->nullable()->after('description');
            }
            if (!Schema::hasColumn('projects', 'whatsapp_number')) {
                $table->string('whatsapp_number')->nullable()->after('contact_email');
            }
            if (!Schema::hasColumn('projects', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable()->after('address');
            }
            if (!Schema::hasColumn('projects', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            }
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['features', 'whatsapp_number', 'latitude', 'longitude']);
        });
    }
};