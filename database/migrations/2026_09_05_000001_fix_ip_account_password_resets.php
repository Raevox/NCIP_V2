<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('ip_accounts', 'remember_token')) {
            Schema::table('ip_accounts', function (Blueprint $table) {
                $table->rememberToken();
            });
        }

        if (! Schema::hasTable('ip_password_reset_tokens')) {
            Schema::create('ip_password_reset_tokens', function (Blueprint $table) {
                $table->string('email')->primary();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ip_password_reset_tokens');

        if (Schema::hasColumn('ip_accounts', 'remember_token')) {
            Schema::table('ip_accounts', function (Blueprint $table) {
                $table->dropRememberToken();
            });
        }
    }
};
