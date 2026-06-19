<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->date('date')->nullable();
            $table->string('time')->nullable(); // in hours
            $table->text('location')->nullable();
            $table->text('address')->nullable();
            $table->text('excel_file')->nullable();
            $table->text('book_now_url')->nullable();
            $table->string('country_code')->nullable();
            $table->boolean('is_online')->default(false);
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
        Schema::dropIfExists('events');
    }
}
