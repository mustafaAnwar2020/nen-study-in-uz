<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->nullable();
            $table->string('slug');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->text('url')->nullable();
            $table->json('book_now_url')->nullable();
            $table->text('more_link')->nullable();
            $table->string('type')->nullable()->default('assessment'); // preparation, certificates
            $table->boolean('is_active')->default(true);

            $table->text('country_list_file')->nullable();// only when the type is assessments
            $table->text('become_partner_url')->nullable();// only when the type is assessments

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
        Schema::dropIfExists('products');
    }
}
