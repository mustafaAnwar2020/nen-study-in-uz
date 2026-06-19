<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nen_landing_settings', function (Blueprint $table) {
            $table->string('features_title', 255)->nullable()->after('show_contact');
            $table->string('features_subtitle', 500)->nullable()->after('features_title');
            $table->string('how_it_works_title', 255)->nullable()->after('features_subtitle');
            $table->string('how_it_works_subtitle', 500)->nullable()->after('how_it_works_title');
            $table->string('how_it_works_btn_text', 100)->nullable()->after('how_it_works_subtitle');
            $table->string('how_it_works_btn_url', 500)->nullable()->after('how_it_works_btn_text');
            $table->string('milestones_title', 255)->nullable()->after('how_it_works_btn_url');
            $table->string('milestones_subtitle', 500)->nullable()->after('milestones_title');
            $table->text('milestones_description')->nullable()->after('milestones_subtitle');
            $table->string('milestones_cta_text', 100)->nullable()->after('milestones_description');
            $table->string('milestones_cta_url', 500)->nullable()->after('milestones_cta_text');
            $table->string('agencies_title', 255)->nullable()->after('milestones_cta_url');
            $table->string('agencies_subtitle', 500)->nullable()->after('agencies_title');
            $table->string('documents_title', 255)->nullable()->after('agencies_subtitle');
            $table->string('documents_subtitle', 500)->nullable()->after('documents_title');
            $table->string('trusted_agencies_title', 255)->nullable()->after('documents_subtitle');
            $table->string('trusted_agencies_subtitle', 500)->nullable()->after('trusted_agencies_title');
            $table->string('university_logos_title', 255)->nullable()->after('trusted_agencies_subtitle');
        });
    }

    public function down(): void
    {
        Schema::table('nen_landing_settings', function (Blueprint $table) {
            $table->dropColumn([
                'features_title', 'features_subtitle',
                'how_it_works_title', 'how_it_works_subtitle', 'how_it_works_btn_text', 'how_it_works_btn_url',
                'milestones_title', 'milestones_subtitle', 'milestones_description', 'milestones_cta_text', 'milestones_cta_url',
                'agencies_title', 'agencies_subtitle',
                'documents_title', 'documents_subtitle',
                'trusted_agencies_title', 'trusted_agencies_subtitle',
                'university_logos_title',
            ]);
        });
    }
};
