<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Change the enum to include 'pending' and 'approved' statuses
        if (Schema::hasColumn('ip_accounts', 'status')) {
            // For MySQL, we need to modify the enum
            DB::statement("ALTER TABLE ip_accounts MODIFY status ENUM('pending', 'active', 'approved', 'archived') DEFAULT 'pending'");
        }
    }

    public function down()
    {
        // Revert back
        if (Schema::hasColumn('ip_accounts', 'status')) {
            DB::statement("ALTER TABLE ip_accounts MODIFY status ENUM('active', 'archived') DEFAULT 'active'");
        }
    }
};
