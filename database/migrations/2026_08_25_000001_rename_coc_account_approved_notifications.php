<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('admin_notifications')
            ->where('type', 'account_approved')
            ->where('related_type', 'CocApplication')
            ->update(['type' => 'coc_approved']);
    }

    public function down(): void
    {
        DB::table('admin_notifications')
            ->where('type', 'coc_approved')
            ->where('related_type', 'CocApplication')
            ->update(['type' => 'account_approved']);
    }
};
