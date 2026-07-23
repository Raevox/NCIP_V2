<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ip_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name')->default('');
            $table->string('contact', 50)->nullable();
            $table->string('ip_group', 255)->nullable();
            $table->string('tribe', 255)->nullable();
            $table->string('origin_province', 255)->nullable();
            $table->string('origin_municipality', 255)->nullable();
            $table->string('origin_barangay', 255)->nullable();
            $table->string('municipality', 255)->nullable();
            $table->date('census_date')->nullable();
            $table->string('civil_status', 100)->nullable();
            $table->string('religion', 100)->nullable();
            $table->string('occupation', 255)->nullable();
            $table->string('income', 255)->nullable();
            $table->string('educational_level', 255)->nullable();
            $table->string('degree', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('status', 100)->default('pending');
            $table->string('coc_status', 100)->nullable();
            $table->boolean('is_archived')->default(false);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->string('first_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->string('sex', 10)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('province', 255)->nullable();
            $table->string('barangay', 255)->nullable();
            $table->string('ncip_number', 50)->nullable();
            $table->string('pwd', 50)->nullable();

            $table->foreign('user_id')->references('id')->on('ip_accounts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ip_records');
    }
};