<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBookNowToSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->boolean('use_book_now')->default(false)->after('btn2_url');
            $table->json('book_now_url')->nullable()->after('use_book_now');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn(['use_book_now', 'book_now_url']);
        });
    }
}
