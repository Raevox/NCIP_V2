<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('applicant_registrations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('name', 255)->nullable();
            $table->string('email', 255);
            $table->string('contact', 20)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('tribe', 255)->nullable();
            $table->string('leader', 255)->nullable();
            $table->string('password', 255);
            $table->string('status', 50)->default('pending');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->string('document_path', 255)->nullable();
            $table->string('province_code', 10)->nullable();
            $table->string('province_name', 255)->nullable();
            $table->string('municipality_code', 10)->nullable();
            $table->string('municipality_name', 255)->nullable();
            $table->string('barangay_code', 10)->nullable();
            $table->string('barangay_name', 255)->nullable();
            
            $table->unique('email');
        });
    }

    public function down()
    {
        Schema::dropIfExists('applicant_registrations');
    }
};