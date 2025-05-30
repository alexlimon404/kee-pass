<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('article_comments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('article_id')->constrained();
            $table->text('comment');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_comments');
    }
};
