<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowInHomeToFaqsTable extends Migration
{
    public function up()
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->boolean('show_in_home')->default(false)->after('is_active');
        });
    }

    public function down()
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn('show_in_home');
        });
    }
}
