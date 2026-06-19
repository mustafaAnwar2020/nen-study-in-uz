<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('key');
            $table->integer('product_id')->nullable();
            $table->text('title')->nullable();
            $table->longText('subtitle')->nullable();
            $table->longText('description')->nullable();
            $table->longText('data')->nullable();
            $table->longText('list_items')->nullable();
            $table->string('image')->nullable();
            $table->string('btn_text')->nullable();
            $table->string('btn_url')->nullable();
            $table->string('type')->nullable()->default('usual');
            $table->boolean('is_active')->default(true)->nullable();
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
        Schema::dropIfExists('sections');
    }
};
