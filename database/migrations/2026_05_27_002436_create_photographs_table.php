<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('photographs', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->string('cover_title')->nullable();
            $table->mediumText('cover_paragraph')->nullable();

            $table->string('info_title')->nullable();
            $table->mediumText('info_paragraph')->nullable();

            $table->string('url');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photographs');
    }
};
