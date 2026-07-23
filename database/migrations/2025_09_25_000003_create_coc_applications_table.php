<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('coc_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->enum('status', ['Draft', 'Pending', 'Under Review', 'Returned', 'Approved'])->default('Draft');
            $table->enum('coc_status', ['Under Review', 'Returned', 'Admin Approval', 'Approved'])->default('Under Review');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->string('homestead_no', 50)->nullable();
            $table->string('lot_no', 50)->nullable();
            $table->date('issuance_date')->nullable();
            $table->boolean('is_archived')->default(0);
            $table->timestamp('deleted_at')->nullable();
            $table->json('step1')->nullable();
            $table->json('step2')->nullable();
            $table->json('step3')->nullable();
            $table->json('step4')->nullable();
            $table->string('applicant_picture', 255)->nullable();
            $table->string('signature', 255)->nullable();
            $table->string('tribal_certificate', 255)->nullable();
            $table->string('genealogy_form', 255)->nullable();
            $table->string('index_status', 50)->nullable();
            $table->text('index_remarks')->nullable();
            $table->string('genealogy_status', 50)->nullable();
            $table->text('genealogy_remarks')->nullable();
            $table->string('documents_status', 50)->nullable();
            $table->text('documents_remarks')->nullable();
            $table->json('classification')->nullable();
            
            $table->foreign('user_id')->references('id')->on('ip_accounts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('coc_applications');
    }
};