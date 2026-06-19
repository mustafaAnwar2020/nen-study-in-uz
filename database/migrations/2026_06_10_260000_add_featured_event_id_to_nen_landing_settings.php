<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('nen_landing_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('featured_event_id')->nullable()->after('hero_btn_url');
            $table->foreign('featured_event_id')
                ->references('id')
                ->on('events')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('nen_landing_settings', function (Blueprint $table) {
            $table->dropForeign(['featured_event_id']);
            $table->dropColumn('featured_event_id');
        });
    }
};
