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
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->double('lat');
            $table->double('lon');
            $table->foreignId('locality_id')->constrained('localities')->cascadeOnUpdate();
            $table->foreignId('type_id')->constrained('place_types')->cascadeOnUpdate();
            $table->timestamps();

            $table->unique(['lat', 'lon']);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
