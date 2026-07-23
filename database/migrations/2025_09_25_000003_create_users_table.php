<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('contact', 20)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->string('role')->default('indigenous');
            $table->string('status')->default('pending');
            $table->string('profile_picture', 255)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};