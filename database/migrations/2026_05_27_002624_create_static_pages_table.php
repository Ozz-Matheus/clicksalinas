<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('static_pages', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->string('slug')->unique(); // Antes 'url' (home, about, contact)
            $table->string('cover_title')->nullable();
            $table->mediumText('cover_paragraph')->nullable();
            $table->string('info_title')->nullable();
            $table->mediumText('info_paragraph')->nullable();
            $table->string('cover_image_path')->nullable(); // Antes 'cover'
            $table->json('gallery')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('static_pages');
    }
};