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
        Schema::create('route_points', function (Blueprint $table) {
            $table->id();
            $table->integer('index');
            $table->foreignId('place_id')->constrained('places')->cascadeOnUpdate();
            $table->foreignId('route_id')->constrained('routes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['place_id', 'route_id']);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_points');
    }
};
