<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpiContactSectionsTable extends Migration
{
    public function up()
    {
        Schema::create('tpi_contact_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_title')->nullable();
            $table->string('title_highlight')->nullable();
            $table->json('phone_cards')->nullable();
            $table->json('social_card')->nullable();
            $table->json('email_cards')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tpi_contact_sections');
    }
}
