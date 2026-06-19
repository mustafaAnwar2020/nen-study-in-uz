<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraColsToNetwrokTab extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('networks', function (Blueprint $table) {
            $table->string('status')->default('active')->after('type');
            $table->text('social_media')->nullable()->after('status');
            $table->text('since')->nullable()->after('social_media');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
