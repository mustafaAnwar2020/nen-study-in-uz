<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->string('url')->nullable();
            $table->string('btn_text')->nullable();
            $table->string('btn_url')->nullable();
            $table->string('btn2_text')->nullable();
            $table->string('btn2_url')->nullable();
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
        Schema::dropIfExists('sliders');
    }
}
