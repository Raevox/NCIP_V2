<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('coc_applications', function (Blueprint $table) {
            $table->string('birth_certificate')->nullable()->after('tribal_certificate');

            foreach (['applicant_picture', 'birth_certificate', 'tribal_certificate', 'genealogy_form'] as $document) {
                $table->string($document . '_status', 50)->nullable()->after('documents_remarks');
                $table->text($document . '_remarks')->nullable()->after($document . '_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('coc_applications', function (Blueprint $table) {
            $table->dropColumn([
                'birth_certificate',
                'applicant_picture_status',
                'applicant_picture_remarks',
                'birth_certificate_status',
                'birth_certificate_remarks',
                'tribal_certificate_status',
                'tribal_certificate_remarks',
                'genealogy_form_status',
                'genealogy_form_remarks',
            ]);
        });
    }
};
