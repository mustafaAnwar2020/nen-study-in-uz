<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('nen_landing_settings', function (Blueprint $table) {
            $table->string('contact_email')->nullable()->after('contact_description');
            $table->string('contact_headquarters')->nullable()->after('contact_email');
        });
    }

    public function down(): void
    {
        Schema::table('nen_landing_settings', function (Blueprint $table) {
            $table->dropColumn(['contact_email', 'contact_headquarters']);
        });
    }
};
