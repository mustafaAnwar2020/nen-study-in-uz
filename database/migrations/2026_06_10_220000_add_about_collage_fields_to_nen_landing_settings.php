<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('nen_landing_settings', function (Blueprint $table) {
            $table->string('about_metric1_value')->nullable()->after('about_stat_label');
            $table->string('about_metric1_label')->nullable()->after('about_metric1_value');
            $table->string('about_metric2_value')->nullable()->after('about_metric1_label');
            $table->string('about_metric2_label')->nullable()->after('about_metric2_value');
            $table->string('about_image_main')->nullable()->after('about_image');
            $table->string('about_image_secondary')->nullable()->after('about_image_main');
            $table->string('about_image_side')->nullable()->after('about_image_secondary');
        });
    }

    public function down(): void
    {
        Schema::table('nen_landing_settings', function (Blueprint $table) {
            $table->dropColumn([
                'about_metric1_value',
                'about_metric1_label',
                'about_metric2_value',
                'about_metric2_label',
                'about_image_main',
                'about_image_secondary',
                'about_image_side',
            ]);
        });
    }
};
