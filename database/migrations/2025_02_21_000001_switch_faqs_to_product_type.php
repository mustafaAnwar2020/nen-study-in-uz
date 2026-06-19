<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class SwitchFaqsToProductType extends Migration
{
    public function up()
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->string('product_type')->nullable()->after('slug');
        });

        // Backfill product_type from related product's type
        $faqs = DB::table('faqs')->whereNotNull('product_id')->get();
        foreach ($faqs as $faq) {
            $type = DB::table('products')->where('id', $faq->product_id)->value('type');
            if ($type) {
                DB::table('faqs')->where('id', $faq->id)->update(['product_type' => $type]);
            }
        }

        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn('product_id');
        });
    }

    public function down()
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->integer('product_id')->nullable()->after('slug');
        });

        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn('product_type');
        });
    }
}
