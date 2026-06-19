<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpiOverviewSectionsTable extends Migration
{
    public function up()
    {
        Schema::create('tpi_overview_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_title')->nullable();
            $table->string('lead')->nullable();
            $table->text('intro_paragraph')->nullable();
            $table->json('benefits')->nullable();
            $table->string('student_image')->nullable();
            $table->json('features')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tpi_overview_sections');
    }
}
