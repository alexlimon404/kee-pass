<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('user_id')->constrained();
            $table->foreignId('parent_id')->nullable()->constrained('groups');

            $table->string('name');
            $table->string('breadcrumb')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
