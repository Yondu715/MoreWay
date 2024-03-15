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
            $table->text('text');
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('place_id');
            $table->unsignedInteger('rating');
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('users')->cascadeOnUpdate();
            $table->foreign('place_id')->references('id')->on('places')->cascadeOnDelete()->cascadeOnUpdate();

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
