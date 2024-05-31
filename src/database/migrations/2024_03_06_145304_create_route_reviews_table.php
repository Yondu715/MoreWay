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
        Schema::create('route_reviews', function (Blueprint $table) {
            $table->id();
            $table->text('text')->nullable();
            $table->foreignId('author_id')->constrained('users')->cascadeOnUpdate();
            $table->foreignId('route_id')->constrained('routes')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedInteger('rating');
            $table->timestamps();

            $table->unique(['author_id', 'route_id']);
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
