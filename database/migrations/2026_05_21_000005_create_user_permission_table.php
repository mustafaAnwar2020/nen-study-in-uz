<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPermissionTable extends Migration
{
    public function up()
    {
        Schema::create('user_permission', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('permission_id')->constrained('permissions')->onDelete('cascade');
            $table->primary(['user_id', 'permission_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_permission');
    }
}
