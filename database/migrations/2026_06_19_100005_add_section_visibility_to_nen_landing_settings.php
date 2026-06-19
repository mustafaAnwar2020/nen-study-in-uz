<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nen_landing_settings', function (Blueprint $table) {
            $table->boolean('show_hero')->default(true)->after('is_active');
            $table->boolean('show_about')->default(true)->after('show_hero');
            $table->boolean('show_events')->default(true)->after('show_about');
            $table->boolean('show_archive')->default(true)->after('show_events');
            $table->boolean('show_features')->default(true)->after('show_archive');
            $table->boolean('show_how_it_works')->default(true)->after('show_features');
            $table->boolean('show_milestones')->default(true)->after('show_how_it_works');
            $table->boolean('show_agencies')->default(true)->after('show_milestones');
            $table->boolean('show_documents')->default(true)->after('show_agencies');
            $table->boolean('show_trusted_agencies')->default(true)->after('show_documents');
            $table->boolean('show_partners')->default(true)->after('show_trusted_agencies');
            $table->boolean('show_university_logos')->default(true)->after('show_partners');
            $table->boolean('show_media')->default(true)->after('show_university_logos');
            $table->boolean('show_faq')->default(true)->after('show_media');
            $table->boolean('show_contact')->default(true)->after('show_faq');
        });
    }

    public function down(): void
    {
        Schema::table('nen_landing_settings', function (Blueprint $table) {
            $table->dropColumn([
                'show_hero', 'show_about', 'show_events', 'show_archive',
                'show_features', 'show_how_it_works', 'show_milestones',
                'show_agencies', 'show_documents', 'show_trusted_agencies',
                'show_partners', 'show_university_logos', 'show_media',
                'show_faq', 'show_contact',
            ]);
        });
    }
};
