<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blogpost_tag', function (Blueprint $table) {
            $table->foreignId('blogpost_id')->constrained('blogposts')->nullable();
            $table->foreignId('tag_id')->constrained('tags')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogpost_tags');
    }
};
