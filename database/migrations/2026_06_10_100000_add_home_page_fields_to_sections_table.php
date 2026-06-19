<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->string('logo_image')->nullable()->after('image');
            $table->string('flags_text')->nullable()->after('logo_image');
            $table->string('video_image')->nullable()->after('flags_text');
            $table->string('video_url')->nullable()->after('video_image');
            $table->string('map_legend_main_label')->nullable()->after('video_url');
            $table->string('map_legend_authorized_label')->nullable()->after('map_legend_main_label');
        });
    }

    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn([
                'logo_image',
                'flags_text',
                'video_image',
                'video_url',
                'map_legend_main_label',
                'map_legend_authorized_label',
            ]);
        });
    }
};
