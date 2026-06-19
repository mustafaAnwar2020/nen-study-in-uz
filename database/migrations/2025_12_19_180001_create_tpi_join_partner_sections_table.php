<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpiJoinPartnerSectionsTable extends Migration
{
    public function up()
    {
        Schema::create('tpi_join_partner_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_title')->nullable();
            $table->json('items')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tpi_join_partner_sections');
    }
}
