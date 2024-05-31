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
            $table->foreignId('place_id')->constrained('places')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('constructor_id')->constrained('route_constructors')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['place_id', 'constructor_id']);
            $table->unique(['index', 'constructor_id']);
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
