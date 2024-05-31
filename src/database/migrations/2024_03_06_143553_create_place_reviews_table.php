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
        Schema::create('place_reviews', function (Blueprint $table) {
            $table->id();
            $table->text('text')->nullable();
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('place_id')->constrained('places')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedInteger('rating');
            $table->timestamps();

            $table->unique(['author_id', 'place_id']);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('place_comments');
    }
};
