<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpiSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tpi_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('heading')->nullable();
            $table->string('benefit1')->nullable();
            $table->text('benefit2')->nullable();
            $table->string('cta_text')->nullable();
            $table->string('deposit_amount')->nullable();
            $table->string('practice_tests_count')->nullable();
            $table->string('months_text')->nullable();
            $table->string('apply_btn_text')->nullable();
            $table->string('learn_more_text')->nullable();
            $table->string('learn_more_url')->nullable();
            $table->string('image')->nullable();
            $table->json('countries')->nullable();
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
        Schema::dropIfExists('tpi_sections');
    }
}
