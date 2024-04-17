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
        Schema::create('route_constructor_points', function (Blueprint $table) {
            $table->id();
            $table->integer('index');
            $table->unsignedBigInteger('place_id');
            $table->unsignedBigInteger('constructor_id');
            $table->timestamps();

            $table->unique(['place_id', 'constructor_id']);
            $table->unique(['index', 'constructor_id']);

            $table->foreign('place_id')->references('id')->on('places')->cascadeOnUpdate();
            $table->foreign('constructor_id')->references('id')->on('route_constructors')->cascadeOnUpdate()->cascadeOnDelete();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_constructor_points');
    }
};
