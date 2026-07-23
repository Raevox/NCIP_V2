<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Target admin/staff user
            $table->string('type'); // pending_account, coc_approval, coc_returned, account_approved
            $table->string('title');
            $table->text('message');
           $table->foreign('related_id')
      ->references('id')
      ->on('ip_accounts')
      ->onDelete('cascade');
            $table->string('related_type')->nullable(); // Model type: IpAccount, CocApplication
            $table->string('action_url')->nullable(); // URL to view the full record
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->string('priority')->default('normal'); // critical, high, normal, low
            $table->timestamps();

            $table->index('user_id');
            $table->index('type');
            $table->index('is_read');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
    }
};
