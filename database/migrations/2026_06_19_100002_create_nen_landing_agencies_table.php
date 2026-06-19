<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nen_landing_agencies', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['translation', 'trusted'])->default('trusted')->index();
            $table->string('name', 255);
            $table->string('service_description', 500)->nullable();
            $table->string('image')->nullable();
            $table->string('location', 255)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('website', 500)->nullable();
            $table->string('whatsapp_url', 500)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nen_landing_agencies');
    }
};
