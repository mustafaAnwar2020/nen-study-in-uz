<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBookNowTextToOffersTable extends Migration
{
    public function up()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->string('book_now_text')->nullable()->after('book_now_url');
        });
    }

    public function down()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn('book_now_text');
        });
    }
}
