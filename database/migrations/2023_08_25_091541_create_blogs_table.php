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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // title
            $table->string('content'); // content
            $table->foreignId('users_id')->nullable()->constrained('users', 'id'); // user_id
            $table->foreignId('categories_id')->nullable()->constrained('categories', 'id'); // category_id
            $table->text('image')->nullable(); // image
            $table->string('tags'); // tags
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
