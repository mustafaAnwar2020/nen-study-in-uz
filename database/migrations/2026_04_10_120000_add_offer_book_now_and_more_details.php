<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOfferBookNowAndMoreDetails extends Migration
{
    public function up()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->boolean('use_book_now')->default(false)->after('book_now_url');
            $table->text('book_now_by_country')->nullable()->after('use_book_now');
            $table->string('more_details_text')->nullable()->after('book_now_by_country');
            $table->text('more_details_url')->nullable()->after('more_details_text');
        });
    }

    public function down()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn(['use_book_now', 'book_now_by_country', 'more_details_text', 'more_details_url']);
        });
    }
}
