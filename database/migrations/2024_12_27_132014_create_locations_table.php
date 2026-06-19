<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->string('country_code');
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->text('address')->nullable();
            $table->text('land_line')->nullable();
            $table->text('call_center')->nullable();
            $table->text('email')->nullable();
            $table->text('phone')->nullable();
            $table->text('schedule')->nullable();
            $table->text('longitude')->nullable();
            $table->text('latitude')->nullable();
            $table->text('map_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
