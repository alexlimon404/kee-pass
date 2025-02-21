<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('group_id')->constrained();
            $table->foreignId('file_id')->nullable()->constrained();
            $table->string('title');
            $table->string('username');
            $table->string('password');
            $table->string('url', 500)->nullable();
            $table->text('description')->nullable();
            $table->timestamp('last_edit_at')->nullable();
            $table->timestamp('created_at_from_export')->nullable();
            $table->string('search', 500)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
