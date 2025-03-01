<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('section_id')->constrained('article_sections');

            $table->string('title');
            $table->text('description')->nullable();
            $table->longText('content');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
