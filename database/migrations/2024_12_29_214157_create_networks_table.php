<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNetworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('networks', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->text('country_code')->nullable();
            $table->text('city')->nullable();
            $table->text('id_text')->nullable();
            $table->text('phone')->nullable();
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->text('email')->nullable();
            $table->text('image')->nullable();
            $table->text('center_name')->nullable();
            $table->text('position')->nullable();
            $table->string('type')->default('test-site')->nullable(); //
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
        Schema::dropIfExists('networks');
    }
}

