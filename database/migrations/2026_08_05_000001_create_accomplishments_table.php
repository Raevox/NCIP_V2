<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accomplishments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('date_label')->nullable();        // e.g. "May 7, 2025"
            $table->string('image')->nullable();             // main image path (content/xxx.jpg)
            $table->json('extra_images')->nullable();        // for layout type 5 (image grid) — array of paths
            $table->unsignedTinyInteger('layout_type')->default(1); // 1, 2, 4, or 5
            $table->string('year_group')->nullable();        // e.g. "2025", "2020"
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accomplishments');
    }
};
