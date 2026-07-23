<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ip_applicants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->boolean('is_archived')->default(false);
            $table->string('first_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->string('spouse_first_name', 255)->nullable();
            $table->string('spouse_last_name', 255)->nullable();
            $table->string('purpose', 255)->nullable();
            $table->json('step2_data')->nullable();
            $table->json('step3_data')->nullable();
            $table->json('step4_data')->nullable();
            $table->string('tribe', 255)->nullable();
            $table->json('documents')->nullable();
            $table->string('purpose_others', 255)->nullable();
            $table->text('height_waiver')->nullable();
            $table->string('contact', 50)->nullable();
            $table->string('sex', 255)->nullable();
            $table->string('ip_group', 255)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('origin_province', 255)->nullable();
            $table->string('origin_municipality', 255)->nullable();
            $table->string('origin_barangay', 255)->nullable();
            $table->string('province', 255)->nullable();
            $table->string('province_name', 255)->nullable();
            $table->string('municipality', 255)->nullable();
            $table->string('municipality_name', 255)->nullable();
            $table->string('barangay', 255)->nullable();
            $table->string('barangay_name', 255)->nullable();
            $table->date('census_date')->nullable();
            $table->string('civil_status', 255)->nullable();
            $table->string('religion', 255)->nullable();
            $table->string('ncip_number', 255)->nullable();
            $table->string('occupation', 255)->nullable();
            $table->string('income', 255)->nullable();
            $table->string('pwd', 255)->nullable();
            $table->string('educational_level', 255)->nullable();
            $table->string('degree', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->timestamps();
            
            // Generated column - Note: MySQL specific syntax
            $table->string('name')->nullable()->virtualAs('CONCAT(first_name, \' \', last_name)');
            
            $table->string('educational_attainment', 50)->nullable();
            $table->string('degree_obtained', 100)->nullable();
            $table->string('father_name', 100)->nullable();
            $table->string('father_ipgroup', 100)->nullable();
            $table->string('father_origin', 100)->nullable();
            $table->string('mother_name', 100)->nullable();
            $table->string('mother_first_name', 255)->nullable();
            $table->string('mother_last_name', 255)->nullable();
            $table->string('mother_ipgroup', 100)->nullable();
            $table->string('mother_origin', 100)->nullable();
            $table->string('father_grandfather_name', 100)->nullable();
            $table->string('father_grandfather_ipgroup', 100)->nullable();
            $table->string('father_grandfather_origin', 100)->nullable();
            $table->string('father_grandmother_name', 100)->nullable();
            $table->string('father_grandmother_ipgroup', 100)->nullable();
            $table->string('father_grandmother_origin', 100)->nullable();
            $table->string('mother_grandfather_name', 100)->nullable();
            $table->string('mother_grandfather_ipgroup', 100)->nullable();
            $table->string('mother_grandfather_origin', 100)->nullable();
            $table->string('mother_grandmother_name', 100)->nullable();
            $table->string('mother_grandmother_ipgroup', 100)->nullable();
            $table->string('mother_grandmother_origin', 100)->nullable();
            $table->boolean('land_matter')->default(false);
            $table->string('homestead_no', 50)->nullable();
            $table->string('lot_no', 50)->nullable();
            $table->date('issuance_date')->nullable();
            $table->string('area', 50)->nullable();
            $table->string('location', 255)->nullable();
            $table->string('applicant_name', 150)->nullable();
            $table->string('applicant_first_name', 255)->nullable();
            $table->string('applicant_last_name', 255)->nullable();
            $table->string('applicant_origin', 255)->nullable();
            $table->string('applicant_ipgroup', 255)->nullable();
            $table->date('date_accomplishment')->nullable();
            $table->string('birth_certificate', 255)->nullable();
            $table->string('document_path', 255)->nullable();
            $table->longText('document_text')->nullable();
            $table->string('status', 50)->default('pending');
            $table->timestamp('deleted_at')->nullable();
            $table->string('father_first_name', 255)->nullable();
            $table->string('father_last_name', 255)->nullable();
            $table->string('grandfather_first_name', 255)->nullable();
            $table->string('grandfather_last_name', 255)->nullable();
            $table->string('grandfather_origin', 255)->nullable();
            $table->string('grandfather_ipgroup', 255)->nullable();
            $table->string('grandmother_first_name', 255)->nullable();
            $table->string('grandmother_last_name', 255)->nullable();
            $table->string('grandmother_origin', 255)->nullable();
            $table->string('grandmother_ipgroup', 255)->nullable();
            $table->string('great_grandfather_first_name', 255)->nullable();
            $table->string('great_grandfather_last_name', 255)->nullable();
            $table->string('great_grandfather_origin', 255)->nullable();
            $table->string('great_grandfather_ipgroup', 255)->nullable();
            $table->string('great_grandmother_first_name', 255)->nullable();
            $table->string('great_grandmother_last_name', 255)->nullable();
            $table->string('great_grandmother_origin', 255)->nullable();
            $table->string('great_grandmother_ipgroup', 255)->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ip_applicants');
    }
};