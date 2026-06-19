<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('home_section_settings', function (Blueprint $table) {
            $table->id();
            $table->string('products_title')->nullable();
            $table->string('products_subtitle')->nullable();
            $table->string('products_link_text')->nullable();
            $table->string('products_show_more_text')->nullable();
            $table->string('offers_title')->nullable();
            $table->string('offers_subtitle')->nullable();
            $table->string('offers_link_text')->nullable();
            $table->string('events_title')->nullable();
            $table->string('events_link_text')->nullable();
            $table->string('library_title')->nullable();
            $table->string('blogs_title')->nullable();
            $table->string('blogs_subtitle')->nullable();
            $table->string('blogs_link_text')->nullable();
            $table->string('faq_title')->nullable();
            $table->string('faq_more_text')->nullable();
            $table->string('faq_more_url')->nullable();
            $table->string('join_title')->nullable();
            $table->string('network_title')->nullable();
            $table->string('network_tab_authorized_label')->nullable();
            $table->string('network_tab_trainers_label')->nullable();
            $table->string('network_apply_center_text')->nullable();
            $table->string('network_apply_center_url')->nullable();
            $table->string('network_apply_trainer_text')->nullable();
            $table->string('network_apply_trainer_url')->nullable();
            $table->string('network_community_text')->nullable();
            $table->string('network_community_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_section_settings');
    }
};
