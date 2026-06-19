<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nen_landing_feature_cards', function (Blueprint $table) {
            $table->id();
            $table->string('stat_value', 50)->nullable();
            $table->string('stat_label', 255)->nullable();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nen_landing_feature_cards');
    }
};
