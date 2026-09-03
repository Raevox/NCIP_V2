<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coc_application_id')->constrained()->cascadeOnDelete();
            $table->string('document_type', 60);
            $table->unsignedInteger('revision');
            $table->string('path');
            $table->string('original_name')->nullable();
            $table->string('mime_type', 120)->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->unsignedBigInteger('uploaded_by_id')->nullable();
            $table->string('uploaded_by_type', 30)->default('applicant');
            $table->timestamps();

            $table->unique(['coc_application_id', 'document_type', 'revision'], 'document_versions_revision_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_versions');
    }
};
