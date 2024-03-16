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
        Schema::create('route_comments', function (Blueprint $table) {
            $table->id();
            $table->text('text')->nullable();
            $table->unsignedBigInteger('author_id');
            $table->unsignedBigInteger('route_id');
            $table->unsignedInteger('rating');
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('users')->cascadeOnUpdate();
            $table->foreign('route_id')->references('id')->on('routes')->cascadeOnUpdate()->cascadeOnDelete();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_comments');
    }
};
