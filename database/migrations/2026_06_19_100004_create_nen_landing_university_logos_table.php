<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nen_landing_university_logos', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('image')->nullable();
            $table->string('url', 500)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nen_landing_university_logos');
    }
};
