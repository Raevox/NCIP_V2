<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ip_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('name')->default('');
            $table->string('email', 255)->unique();
            $table->string('contact', 50)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('province_code', 20)->nullable();
            $table->string('province_name', 100)->nullable();
            $table->string('municipality_code', 20)->nullable();
            $table->string('municipality_name', 100)->nullable();
            $table->string('barangay_code', 20)->nullable();
            $table->string('barangay_name', 100)->nullable();
            $table->string('tribe', 255)->nullable();
            $table->string('leader', 255)->nullable();
            $table->string('password', 255);
            $table->enum('status', ['active', 'archived'])->default('active');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->string('document_path', 255)->nullable();
            $table->longText('document_text')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ip_accounts');
    }
};