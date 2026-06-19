<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->integer('product_id')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('url')->nullable();
            $table->text('pdf')->nullable();
            $table->text('website')->nullable();
            $table->text('logo')->nullable();
            $table->text('country_code')->nullable();
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
        Schema::dropIfExists('partners');
    }
}
