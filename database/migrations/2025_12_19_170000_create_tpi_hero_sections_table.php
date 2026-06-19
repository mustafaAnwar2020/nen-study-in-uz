<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpiHeroSectionsTable extends Migration
{
    public function up()
    {
        Schema::create('tpi_hero_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('image')->nullable();
            $table->string('apply_btn_text')->nullable();
            $table->json('countries')->nullable();
            $table->string('nearest_center_text')->nullable();
            $table->string('nearest_center_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tpi_hero_sections');
    }
}
