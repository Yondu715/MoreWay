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
        Schema::create('chat_active_routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')->constrained('chats')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('route_id')->constrained('routes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['chat_id', 'route_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_active_routes');
    }
};
