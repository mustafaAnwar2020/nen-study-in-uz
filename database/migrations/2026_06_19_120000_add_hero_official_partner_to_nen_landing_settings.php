<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nen_landing_settings', function (Blueprint $table) {
            $table->string('hero_official_logo')->nullable()->after('hero_btn_url');
            $table->string('hero_official_label', 255)->nullable()->after('hero_official_logo');
        });
    }

    public function down(): void
    {
        Schema::table('nen_landing_settings', function (Blueprint $table) {
            $table->dropColumn(['hero_official_logo', 'hero_official_label']);
        });
    }
};
