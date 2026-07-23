<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name', 100)->nullable()->after('id');
            $table->string('last_name', 100)->nullable()->after('first_name');
            $table->string('contact', 20)->nullable()->after('email');
            $table->string('address', 255)->nullable()->after('contact');
            $table->string('status', 255)->default('pending')->after('role');
            $table->string('profile_picture', 255)->nullable()->after('status');
            $table->timestamp('deleted_at')->nullable()->after('updated_at');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name', 'contact', 'address', 'status', 'profile_picture', 'deleted_at']);
        });
    }
};