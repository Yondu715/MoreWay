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
        Schema::create('user_active_routes', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_group')->default(false);
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('route_id')->constrained('routes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'route_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_active_routes');
    }
};
