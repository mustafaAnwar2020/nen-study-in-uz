<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpiCtaSectionsTable extends Migration
{
    public function up()
    {
        Schema::create('tpi_cta_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('lead')->nullable();
            $table->string('image')->nullable();
            $table->string('pay_btn_text')->nullable();
            $table->json('payment_options')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tpi_cta_sections');
    }
}
