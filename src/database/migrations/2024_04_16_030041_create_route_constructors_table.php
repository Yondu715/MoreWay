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
        Schema::create('route_constructors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creator_id')->unique();
            $table->timestamps();

            $table->foreign('creator_id')->references('id')->on('users')->cascadeOnUpdate();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_constructors');
    }
};
