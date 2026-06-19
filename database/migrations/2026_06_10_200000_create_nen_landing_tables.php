<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nen_landing_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_product_title')->nullable();
            $table->string('hero_subtitle')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('hero_btn_text')->nullable();
            $table->string('hero_btn_url')->nullable();
            $table->string('about_label')->nullable();
            $table->string('about_title')->nullable();
            $table->longText('about_description')->nullable();
            $table->string('about_image')->nullable();
            $table->string('about_stat_value')->nullable();
            $table->string('about_stat_label')->nullable();
            $table->string('highlights_title')->nullable();
            $table->string('highlights_subtitle')->nullable();
            $table->string('archive_title')->nullable();
            $table->string('archive_subtitle')->nullable();
            $table->string('archive_btn_text')->nullable();
            $table->string('archive_btn_url')->nullable();
            $table->string('partners_title')->nullable();
            $table->string('faq_title')->nullable();
            $table->string('media_title')->nullable();
            $table->string('contact_title')->nullable();
            $table->text('contact_description')->nullable();
            $table->string('footer_phone')->nullable();
            $table->string('footer_copyright')->nullable();
            $table->string('footer_collaboration_text')->nullable();
            $table->string('footer_collaboration_url')->nullable();
            $table->string('header_register_text')->nullable();
            $table->string('header_register_url')->nullable();
            $table->string('nav_about_url')->nullable();
            $table->string('nav_events_url')->nullable();
            $table->string('nav_partners_url')->nullable();
            $table->string('nav_contact_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('nen_landing_partner_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('nen_landing_event_items', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('highlight');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->date('event_date')->nullable();
            $table->string('url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('nen_landing_faq_items', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('answer')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('nen_landing_media_items', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('caption')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nen_landing_media_items');
        Schema::dropIfExists('nen_landing_faq_items');
        Schema::dropIfExists('nen_landing_event_items');
        Schema::dropIfExists('nen_landing_partner_items');
        Schema::dropIfExists('nen_landing_settings');
    }
};
